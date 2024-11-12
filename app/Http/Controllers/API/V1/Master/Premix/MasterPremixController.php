<?php

namespace App\Http\Controllers\API\V1\Master\Premix;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Premix\StoreMasterPremixRequest;
use App\Http\Requests\Master\Premix\UpdateMasterPremixRequest;
use App\Http\Resources\Master\Premix\MasterPremixCollection;
use App\Models\MasterPremix;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MasterPremixController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterPremix::with('group')->orderBy('codePremix', 'asc');

        if (request('namePremix')) {
            $query->where("namePremix", "like", "%" . request("namePremix") . "%");
        }

        $premixes = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($premixes->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Premix  Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterPremixCollection($premixes);
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
    public function store(StoreMasterPremixRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterPremix $masterPremix)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterPremix $masterPremix)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterPremixRequest $request, MasterPremix $masterPremix)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $premix = MasterPremix::find($id);
        $origin = clone $premix;

        $exists = MasterPremix::where('codePremix', $id)->exists();
        // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Code Premix  type cannot be deleted because it is linked to a premix",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // }

        $premix->delete();

        try {
            return response()->json([
                'message' => "Premix  with name '$origin->namePremix' has been deleted",
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
