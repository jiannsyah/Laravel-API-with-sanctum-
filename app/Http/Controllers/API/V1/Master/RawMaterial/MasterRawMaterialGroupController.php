<?php

namespace App\Http\Controllers\API\V1\Master\RawMaterial;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialGroupCollection;
use App\Http\Resources\Master\RawMaterial\MasterRawMaterialGroupResource;
use App\Models\MasterRawMaterialGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, MasterRawMaterialGroup $masterRawMaterialGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterRawMaterialGroup $masterRawMaterialGroup)
    {
        //
    }
}
