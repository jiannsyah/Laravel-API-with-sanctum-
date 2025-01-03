<?php

namespace App\Http\Controllers\API\V1\Master\General;

use App\Exports\Master\Customer\MasterCustomerExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\General\StoreMasterCustomerRequest;
use App\Http\Requests\Master\General\UpdateMasterCustomerRequest;
use App\Http\Resources\Master\General\MasterCustomerCollection;
use App\Http\Resources\Master\General\MasterCustomerResource;
use App\Models\Master\MasterCustomer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;

class MasterCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterCustomer::query()->orderBy('codeCustomer', 'asc');

        if (request('nameCustomer')) {
            $query->where("nameCustomer", "like", "%" . request("nameCustomer") . "%");
        }

        $customers = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($customers->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Customer  Empty'
            ], Response::HTTP_OK);
        } else {
            return new MasterCustomerCollection($customers);
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
    public function store(StoreMasterCustomerRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        try {
            $codeCustomer = MasterCustomer::withTrashed()->where('codeCustomer', $request->codeCustomer)->first();

            if ($codeCustomer) {
                $codeCustomer->restore();
                $codeCustomer->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete

            MasterCustomer::create($data);

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
        $customer = MasterCustomer::find($id);
        // dd($customer);
        if ($customer === null) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Customer Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([
                'data' => new MasterCustomerResource($customer),
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterCustomer $masterCustomer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterCustomerRequest $request, $id)
    {
        $masterCustomer = MasterCustomer::findOrFail($id);
        $masterCustomer['updated_by'] = Auth::id();
        $origin = clone $masterCustomer;
        // dd($masterCustomer);
        // 
        $masterCustomer->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterCustomerResource($masterCustomer),
                'message' => "Master customer with name '$origin->nameCustomer' has been changed  '$masterCustomer->nameCustomer'",
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
        $customer = MasterCustomer::find($id);
        $origin = clone $customer;

        // $exists = MasterCustomer::where('codePremix', $id)->exists();
        // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Code Premix  type cannot be deleted because it is linked to a customer",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // }

        $customer->delete();

        try {
            return response()->json([
                'message' => "Customer  with name '$origin->nameCustomer' has been deleted",
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
        $logs = Audit::where('auditable_type', MasterCustomer::class)->get();

        if (request('event')) {
            if (request('event') !== 'created' && request('event') !== 'restored' && request('event') !== 'updated' && request('event') !== 'deleted') {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'The sent method is not correct'
                ], Response::HTTP_NOT_FOUND);
            }

            $logs = Audit::where('auditable_type', MasterCustomer::class)->where('event', request('event'))->get();
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

    public function export(Request $request)
    {
        // Ambil filter dari request
        $filters = $request->only(['code_from', 'code_to', 'name', 'status', 'ppn']); // Hanya ambil filter yang diizinkan

        // Pastikan nilai status berupa angka 0 atau 1 (jika diperlukan)
        if (isset($filters['status']) && !in_array($filters['status'], ['Active', 'InActive'])) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Status filter value must be Active or inActive'
            ], Response::HTTP_NOT_FOUND);
        }
        if (isset($filters['ppn']) && !in_array($filters['ppn'], ['PPN', 'Non-PPN'])) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'PPN filter value must be PPN or Non-PPN'
            ], Response::HTTP_NOT_FOUND);
        }

        $fileName = 'list-customer-' . now()->format('Y-m-d_i-s') . '.xlsx';

        return Excel::download(new MasterCustomerExport($filters), $fileName);
    }
}
