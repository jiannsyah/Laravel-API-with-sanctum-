<?php

namespace App\Http\Controllers\API\V1\Master\RawMaterial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RawMaterial\StoreMasterRawMaterialRequest;
use App\Http\Requests\Master\RawMaterial\UpdateMasterRawMaterialRequest;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialCollection;
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
                'message' => 'Raw Material Group Empty'
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
    public function show(MasterRawMaterial $masterRawMaterial)
    {
        //
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
    public function update(UpdateMasterRawMaterialRequest $request, MasterRawMaterial $masterRawMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterRawMaterial $masterRawMaterial)
    {
        //
    }
}
