<?php

namespace App\Http\Controllers\API\V1\Master\RawMaterial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RawMaterial\StoreMasterRawMaterialTypeRequest;
use App\Http\Requests\Master\RawMaterial\UpdateMasterRawMaterialTypeRequest;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialTypeCollection;
use App\Models\MasterRawMaterialType;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
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
        //
        $data = $request->validated();
        // 
        $latest_code = MasterRawMaterialType::query()->orderBy('codeRawMaterialType', 'desc')->first();
        $next_code = strval((int)$latest_code->codeRawMaterialType + 10);

        // dd($next_code);
        if ((int)$next_code === 100) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'The code has reached the limit'
            ], Response::HTTP_NOT_FOUND);
        }

        $data['codeRawMaterialType'] = $next_code;

        // dd($latest_code->codeRawMaterialType);
        // dd($data);

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
    public function show(MasterRawMaterialType $masterRawMaterialType)
    {
        //
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
    public function update(UpdateMasterRawMaterialTypeRequest $request, MasterRawMaterialType $masterRawMaterialType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterRawMaterialType $masterRawMaterialType)
    {
        //
    }
}
