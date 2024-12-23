<?php

namespace App\Http\Controllers\API\V1\Master\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\General\StoreMasterSalesmanRequest;
use App\Http\Requests\Master\General\UpdateMasterSalesmanRequest;
use App\Http\Resources\Master\General\MasterSalesmanCollection;
use App\Http\Resources\Master\General\MasterSalesmanResource;
use App\Models\Master\General\MasterSalesman;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;

class MasterSalesmanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterSalesman::query()->orderBy('codeSalesman', 'asc');

        if (request('nameSalesman')) {
            $query->where("nameSalesman", "like", "%" . request("nameSalesman") . "%");
        }

        $salesman = $query->paginate(10);

        // $params = app('params');
        // $workDate = $params['workDate'];

        // dd($workDate);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($salesman->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Salesman  Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterSalesmanCollection($salesman);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterSalesmanRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        try {
            $codeSalesman = MasterSalesman::withTrashed()->where('codeSalesman', $request->codeSalesman)->first();

            if ($codeSalesman) {
                $codeSalesman->restore();
                $codeSalesman->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete

            MasterSalesman::create($data);

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Data stored to dbd'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error storing data :' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed Data stored to dbd'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $salesman = MasterSalesman::find($id);
        // dd($salesman);
        if ($salesman === null) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Salesman Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([
                'data' => new MasterSalesmanResource($salesman),
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterSalesman $masterSalesman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterSalesmanRequest $request, $id)
    {
        $masterSalesman = MasterSalesman::findOrFail($id);
        $masterSalesman['updated_by'] = Auth::id();
        $origin = clone $masterSalesman;
        // dd($masterSalesman);
        // 
        $masterSalesman->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterSalesmanResource($masterSalesman),
                'message' => "Master salesman with name '$origin->nameSalesman' has been changed  '$masterSalesman->nameSalesman'",
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error updated data :' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed Data updated to dbd'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $salesman = MasterSalesman::find($id);
        $origin = clone $salesman;

        // $exists = MasterSalesman::where('codePremix', $id)->exists();
        // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Code Premix  type cannot be deleted because it is linked to a salesman",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // }

        $salesman->delete();

        try {
            return response()->json([
                'message' => "Salesman  with name '$origin->nameSalesman' has been deleted",
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error updated data :' . $e->getMessage());
            return response()->json([
                'message' => "Failed Data deleted",
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logs(Request $request)
    {
        $logs = Audit::where('auditable_type', MasterSalesman::class)->get();

        if (request('event')) {
            if (request('event') !== 'created' && request('event') !== 'restored' && request('event') !== 'updated' && request('event') !== 'deleted') {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'The sent method is not correct'
                ], Response::HTTP_NOT_FOUND);
            }

            $logs = Audit::where('auditable_type', MasterSalesman::class)->where('event', request('event'))->get();
        }

        // Format data log untuk response
        $data = $logs->map(function ($log) {
            return [
                // 'id' => $log->id,
                'event' => $log->event,
                'old_values' => $log->old_values,
                'new_values' => $log->new_values,
                'user_id' => $log->user_id,
                'user_name' => optional($log->user)->name, // Ambil nama user
                'created_at' => $log->created_at,
            ];
        });

        // Return dalam bentuk JSON
        return response()->json([
            'success' => true,
            'logs' => $data,
        ]);
    }
}
