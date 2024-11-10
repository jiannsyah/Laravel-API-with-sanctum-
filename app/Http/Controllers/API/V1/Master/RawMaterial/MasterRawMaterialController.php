<?php

namespace App\Http\Controllers\API\V1\Master\RawMaterial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RawMaterial\StoreMasterRawMaterialRequest;
use App\Http\Requests\Master\RawMaterial\UpdateMasterRawMaterialRequest;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialCollection;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialResource;
use App\Models\MasterRawMaterial;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterRawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterRawMaterial::with(['type', 'group'])->orderBy('codeRawMaterial', 'asc');

        if (request('nameRawMaterial')) {
            $query->where("nameRawMaterial", "like", "%" . request("nameRawMaterial") . "%");
        }

        $rawMaterials = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($rawMaterials->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Raw Material  Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterRawMaterialCollection($rawMaterials);
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
    public function store(StoreMasterRawMaterialRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        // dd($data);
        try {
            MasterRawMaterial::create($data);

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
        $masterRawMaterial = MasterRawMaterial::with(['type', 'group'])->findOrFail($id);
        // dd($masterRawMaterial);

        return response()->json([
            'data' => new MasterRawMaterialResource($masterRawMaterial),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterRawMaterial $masterRawMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterRawMaterialRequest $request, $id)
    {
        $masterRawMaterial = MasterRawMaterial::with(['type', 'group'])->findOrFail($id);
        $masterRawMaterial['updated_by'] = Auth::id();
        $origin = clone $masterRawMaterial;
        // dd($masterRawMaterial);
        // 
        $masterRawMaterial->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterRawMaterialResource($masterRawMaterial),
                'message' => "Raw material type with name '$origin->nameRawMaterial' has been changed  '$masterRawMaterial->nameRawMaterial'",
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
        $rawMaterial = MasterRawMaterial::find($id);
        $origin = clone $rawMaterial;

        // $exists = MasterRawMaterial::where('codeRawMaterialGroup', $id)->exists();
        // // dd($exists);
        // if ($exists) {
        //     return response()->json([
        //         'message' => "Raw material group cannot be deleted because it is linked to a raw material",
        //         'status' => Response::HTTP_FORBIDDEN
        //     ], Response::HTTP_FORBIDDEN);
        // } else {
        //     $rawMaterialGroup->delete();
        // }
        // 
        $rawMaterial->delete();

        try {
            return response()->json([
                'message' => "Raw material with name '$origin->nameRawMaterial' has been deleted",
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
