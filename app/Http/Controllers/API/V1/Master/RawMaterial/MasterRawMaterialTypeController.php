<?php

namespace App\Http\Controllers\API\V1\Master\RawMaterial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RawMaterial\StoreMasterRawMaterialTypeRequest;
use App\Http\Requests\Master\RawMaterial\UpdateMasterRawMaterialTypeRequest;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialTypeCollection;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialTypeResource;
use App\Models\MasterRawMaterialType;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterRawMaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterRawMaterialType::query()->orderBy('codeRawMaterialType', 'asc');

        if (request('nameRawMaterialType')) {
            $query->where("nameRawMaterialType", "like", "%" . request("nameRawMaterialType") . "%");
        }

        $rawMaterialTypes = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($rawMaterialTypes->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Raw Material Type Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterRawMaterialTypeCollection($rawMaterialTypes);
        }

        //
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
    public function store(StoreMasterRawMaterialTypeRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        try {
            MasterRawMaterialType::create($data);

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
        $masterRawMaterialType = MasterRawMaterialType::findOrFail($id);
        // dd($masterRawMaterialType);

        return response()->json([
            'data' => new MasterRawMaterialTypeResource($masterRawMaterialType),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterRawMaterialType $masterRawMaterialType)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterRawMaterialTypeRequest $request, $id)
    {
        //
        $masterRawMaterialType = MasterRawMaterialType::findOrFail($id);
        $masterRawMaterialType['updated_by'] = Auth::id();
        $origin = clone $masterRawMaterialType;
        // dd(gettype($masterRawMaterialType));
        // 
        $masterRawMaterialType->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterRawMaterialTypeResource($masterRawMaterialType),
                'message' => "Raw material type with name '$origin->nameRawMaterialType' has been changed  '$masterRawMaterialType->nameRawMaterialType'",
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
        $rawMaterialType = MasterRawMaterialType::find($id);
        $origin = clone $rawMaterialType;

        if ($rawMaterialType) {
            $rawMaterialType->delete();
        }

        try {
            return response()->json([
                'message' => "Raw material type with name '$origin->nameRawMaterialType' has been deleted",
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
