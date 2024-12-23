<?php

namespace App\Http\Controllers\API\V1\Master\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\General\StoreMasterSupplierRequest;
use App\Http\Requests\Master\General\UpdateMasterSupplierRequest;
use App\Http\Resources\Master\General\MasterSupplierCollection;
use App\Http\Resources\Master\General\MasterSupplierResource;
use App\Models\Master\General\MasterSupplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;

class MasterSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterSupplier::query()->orderBy('codeSupplier', 'asc');

        if (request('nameSupplier')) {
            $query->where("nameSupplier", "like", "%" . request("nameSupplier") . "%");
        }

        $suppliers = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($suppliers->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Supplier  Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterSupplierCollection($suppliers);
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
    public function store(StoreMasterSupplierRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        try {
            $codeSupplier = MasterSupplier::withTrashed()->where('codeSupplier', $request->codeSupplier)->first();

            if ($codeSupplier) {
                $codeSupplier->restore();
                $codeSupplier->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete

            MasterSupplier::create($data);

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
        $supplier = MasterSupplier::find($id);
        // dd($supplier);
        if ($supplier === null) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Supplier Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([
                'data' => new MasterSupplierResource($supplier),
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterSupplier $masterSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterSupplierRequest $request, $id)
    {
        $masterSupplier = MasterSupplier::findOrFail($id);
        $masterSupplier['updated_by'] = Auth::id();
        $origin = clone $masterSupplier;
        // dd($masterSupplier);
        // 
        $masterSupplier->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterSupplierResource($masterSupplier),
                'message' => "Master supplier with name '$origin->nameSupplier' has been changed  '$masterSupplier->nameSupplier'",
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
        $supplier = MasterSupplier::find($id);
        $origin = clone $supplier;

        // $exists = MasterSupplier::where('codePremix', $id)->exists();
        // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Code Premix  type cannot be deleted because it is linked to a supplier",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // }

        $supplier->delete();

        try {
            return response()->json([
                'message' => "Supplier  with name '$origin->nameSupplier' has been deleted",
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
        $logs = Audit::where('auditable_type', MasterSupplier::class)->get();

        if (request('event')) {
            if (request('event') !== 'created' && request('event') !== 'restored' && request('event') !== 'updated' && request('event') !== 'deleted') {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'The sent method is not correct'
                ], Response::HTTP_NOT_FOUND);
            }

            $logs = Audit::where('auditable_type', MasterSupplier::class)->where('event', request('event'))->get();
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
