<?php

namespace App\Http\Controllers\API\V1\Master\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Account\StoreMasterGeneralLedgerAccountRequest;
use App\Http\Requests\Master\Account\UpdateMasterGeneralLedgerAccountRequest;
use App\Http\Resources\Master\Account\MasterGeneralLedgerAccountCollection;
use App\Http\Resources\Master\Account\MasterGeneralLedgerAccountResource;
use App\Models\Master\Account\MasterGeneralLedgerAccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;

class MasterGeneralLedgerAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterGeneralLedgerAccount::with(['balanceSheetAccount'])->orderBy('numberGeneralLedgerAccount', 'asc');

        if (request('nameGeneralLedgerAccount')) {
            $query->where("nameGeneralLedgerAccount", "like", "%" . request("nameGeneralLedgerAccount") . "%");
        }

        $GeneralLedgerAccount = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($GeneralLedgerAccount->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'General Ledger Accounts Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterGeneralLedgerAccountCollection($GeneralLedgerAccount);
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
    public function store(StoreMasterGeneralLedgerAccountRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        try {
            // dd('masuk');
            $GeneralLedgerAccount = MasterGeneralLedgerAccount::withTrashed()->where('numberGeneralLedgerAccount', $request->numberGeneralLedgerAccount)->first();
            // dd($GeneralLedgerAccount);

            if ($GeneralLedgerAccount) {
                $GeneralLedgerAccount->restore();
                $GeneralLedgerAccount->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete

            MasterGeneralLedgerAccount::create($data);

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
        $GeneralLedgerAccount = MasterGeneralLedgerAccount::find($id);
        // dd($GeneralLedgerAccount);
        if ($GeneralLedgerAccount === null) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Balance Sheet Account Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([
                'data' => new MasterGeneralLedgerAccountResource($GeneralLedgerAccount),
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterGeneralLedgerAccount $masterGeneralLedgerAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterGeneralLedgerAccountRequest $request, $id)
    {
        $GeneralLedgerAccount = MasterGeneralLedgerAccount::findOrFail($id);
        $GeneralLedgerAccount['updated_by'] = Auth::id();
        $origin = clone $GeneralLedgerAccount;
        // dd($GeneralLedgerAccount);
        // 
        $GeneralLedgerAccount->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterGeneralLedgerAccountResource($GeneralLedgerAccount),
                'message' => "Master customer with name '$origin->nameGeneralLedgerAccount' has been changed  '$GeneralLedgerAccount->nameGeneralLedgerAccount'",
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
        $GeneralLedgerAccount = MasterGeneralLedgerAccount::find($id);
        $origin = clone $GeneralLedgerAccount;

        // $exists = MasterGeneralLedgerAccount::where('codePremix', $id)->exists();
        // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Code Premix  type cannot be deleted because it is linked to a GeneralLedgerAccount",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // }

        $GeneralLedgerAccount->delete();

        try {
            return response()->json([
                'message' => "Account general ledger  with name '$origin->nameGeneralLedgerAccount' has been deleted",
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
        $logs = Audit::where('auditable_type', MasterGeneralLedgerAccount::class)->get();

        if (request('event')) {
            if (request('event') !== 'created' && request('event') !== 'restored' && request('event') !== 'updated' && request('event') !== 'deleted') {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'The sent method is not correct'
                ], Response::HTTP_NOT_FOUND);
            }

            $logs = Audit::where('auditable_type', MasterGeneralLedgerAccount::class)->where('event', request('event'))->get();
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
