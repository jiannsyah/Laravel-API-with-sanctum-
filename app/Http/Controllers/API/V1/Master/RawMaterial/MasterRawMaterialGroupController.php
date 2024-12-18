<?php

namespace App\Http\Controllers\API\V1\Master\RawMaterial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RawMaterial\StoreMasterRawMaterialGroupRequest;
use App\Http\Requests\Master\RawMaterial\UpdateMasterRawMaterialGroupRequest;
use App\Http\Requests\Master\RawMaterial\UpdateMasterRawMaterialTypeRequest;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialGroupCollection;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialGroupResource;
use App\Models\Master\MasterRawMaterial;
use App\Models\Master\MasterRawMaterialGroup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterRawMaterialGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterRawMaterialGroup::with('type')->orderBy('codeRawMaterialGroup', 'asc');

        if (request('nameRawMaterialGroup')) {
            $query->where("nameRawMaterialGroup", "like", "%" . request("nameRawMaterialGroup") . "%");
        }

        $rawMaterialGroups = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($rawMaterialGroups->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Raw Material Group Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterRawMaterialGroupCollection($rawMaterialGroups);
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
    public function store(StoreMasterRawMaterialGroupRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        // dd($data);
        try {
            MasterRawMaterialGroup::create($data);

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
        $masterRawMaterialGroup = MasterRawMaterialGroup::with('type')->findOrFail($id);
        // dd($masterRawMaterialGroup);

        return response()->json([
            'data' => new MasterRawMaterialGroupResource($masterRawMaterialGroup),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterRawMaterialGroup $masterRawMaterialGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterRawMaterialGroupRequest $request, $id)
    {
        $masterRawMaterialGroup = MasterRawMaterialGroup::with('type')->findOrFail($id);
        $masterRawMaterialGroup['updated_by'] = Auth::id();
        $origin = clone $masterRawMaterialGroup;
        // dd($masterRawMaterialGroup);
        // 
        $masterRawMaterialGroup->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterRawMaterialGroupResource($masterRawMaterialGroup),
                'message' => "Raw material type with name '$origin->nameRawMaterialGroup' has been changed  '$masterRawMaterialGroup->nameRawMaterialGroup'",
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
        $rawMaterialGroup = MasterRawMaterialGroup::find($id);
        $origin = clone $rawMaterialGroup;
        $exists = MasterRawMaterial::where('codeRawMaterialGroup', $rawMaterialGroup['codeRawMaterialGroup'])->exists();
        // 
        if ($exists) {
            return response()->json([
                'message' => "Raw material group cannot be deleted because it is linked to a raw material",
                'status' => Response::HTTP_FORBIDDEN
            ], Response::HTTP_FORBIDDEN);
        } else {
            $rawMaterialGroup->delete();
        }

        try {
            return response()->json([
                'message' => "Raw material group with name '$origin->nameRawMaterialGroup' has been deleted",
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
