<?php

namespace App\Http\Controllers\API\V1\Master\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Account\StoreMasterBalanceSheetAccountRequest;
use App\Http\Requests\Master\Account\UpdateMasterBalanceSheetAccountRequest;
use App\Http\Resources\Master\Account\MasterBalanceSheetAccountCollection;
use App\Http\Resources\Master\Account\MasterBalanceSheetAccountResource;
use App\Models\Master\MasterBalanceSheetAccount;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterBalanceSheetAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterBalanceSheetAccount::query()->orderBy('numberAccount', 'asc');

        if (request('nameAccountBalance')) {
            $query->where("nameAccountBalance", "like", "%" . request("nameAccountBalance") . "%");
        }

        $BalanceSheetAccount = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($BalanceSheetAccount->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Balance Sheet Account Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterBalanceSheetAccountCollection($BalanceSheetAccount);
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
    public function store(StoreMasterBalanceSheetAccountRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        try {
            // dd('masuk');
            $BalanceSheetAccount = MasterBalanceSheetAccount::withTrashed()->where('numberAccount', $request->numberAccount)->first();
            // dd($BalanceSheetAccount);

            if ($BalanceSheetAccount) {
                $BalanceSheetAccount->restore();
                $BalanceSheetAccount->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete

            MasterBalanceSheetAccount::create($data);

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
        $BalanceSheetAccount = MasterBalanceSheetAccount::find($id);
        // dd($BalanceSheetAccount);
        if ($BalanceSheetAccount === null) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Balance Sheet Account Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([
                'data' => new MasterBalanceSheetAccountResource($BalanceSheetAccount),
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterBalanceSheetAccount $masterBalanceSheetAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterBalanceSheetAccountRequest $request, $id)
    {
        $BalanceSheetAccount = MasterBalanceSheetAccount::findOrFail($id);
        $BalanceSheetAccount['updated_by'] = Auth::id();
        $origin = clone $BalanceSheetAccount;
        // dd($BalanceSheetAccount);
        // 
        $BalanceSheetAccount->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterBalanceSheetAccountResource($BalanceSheetAccount),
                'message' => "Master customer with name '$origin->nameAccountBalance' has been changed  '$BalanceSheetAccount->nameAccountBalance'",
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
        $BalanceSheetAccount = MasterBalanceSheetAccount::find($id);
        $origin = clone $BalanceSheetAccount;

        // $exists = MasterBalanceSheetAccount::where('codePremix', $id)->exists();
        // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Code Premix  type cannot be deleted because it is linked to a BalanceSheetAccount",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // }

        $BalanceSheetAccount->delete();

        try {
            return response()->json([
                'message' => "Account Balance  with name '$origin->nameAccountBalance' has been deleted",
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
}