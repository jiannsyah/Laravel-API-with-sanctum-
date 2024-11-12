<?php

namespace App\Http\Controllers\API\V1\Master\Premix;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Premix\StoreMasterPremixGroupRequest;
use App\Http\Requests\Master\Premix\UpdateMasterPremixGroupRequest;
use App\Models\MasterPremixGroup;
use App\Http\Resources\Master\Premix\MasterPremixGroupCollection;
use App\Http\Resources\Master\Premix\MasterPremixGroupResource;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterPremixGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterPremixGroup::query()->orderBy('codePremixGroup', 'asc');

        if (request('namePremixGroup')) {
            $query->where("namePremixGroup", "like", "%" . request("namePremixGroup") . "%");
        }

        $productGroups = $query->paginate(2);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($productGroups->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Premix Groups Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterPremixGroupCollection($productGroups);
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
    public function store(StoreMasterPremixGroupRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        try {
            MasterPremixGroup::create($data);

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
        $masterPremixGroup = MasterPremixGroup::findOrFail($id);
        // dd($masterPremixGroup);

        return response()->json([
            'data' => new MasterPremixGroupResource($masterPremixGroup),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterPremixGroup $masterPremixGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterPremixGroupRequest $request, $id)
    {
        $masterPremixGroup = MasterPremixGroup::findOrFail($id);
        $masterPremixGroup['updated_by'] = Auth::id();
        $origin = clone $masterPremixGroup;
        // dd(gettype($masterPremixGroup));
        // 
        $masterPremixGroup->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterPremixGroupResource($masterPremixGroup),
                'message' => "Premix Group type with name '$origin->namePremixGroup' has been changed  '$masterPremixGroup->namePremixGroup'",
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
        $productGroup = MasterPremixGroup::find($id);
        $origin = clone $productGroup;

        // $exists = MasterPremix::where('codePremixGroup', $id)->exists();
        // // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Code Premix Group type cannot be deleted because it is linked to a product",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // }

        $productGroup->delete();

        try {
            return response()->json([
                'message' => "Premix Group with name '$origin->namePremixGroup' has been deleted",
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
