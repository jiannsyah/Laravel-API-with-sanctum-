<?php

namespace App\Http\Controllers\API\V1\Master\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Product\StoreMasterProductGroupRequest;
use App\Http\Requests\Master\Product\UpdateMasterProductGroupRequest;
use App\Http\Resources\Master\Product\MasterProductGroupCollection;
use App\Http\Resources\Master\Product\MasterProductGroupResource;
use App\Models\Master\MasterProduct;
use App\Models\Master\MasterProductGroup;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MasterProductGroup::query()->orderBy('codeProductGroup', 'asc');

        if (request('nameProductGroup')) {
            $query->where("nameProductGroup", "like", "%" . request("nameProductGroup") . "%");
        }

        $productGroups = $query->paginate(10);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($productGroups->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Product Group Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new MasterProductGroupCollection($productGroups);
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
    public function store(StoreMasterProductGroupRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        try {
            $productGroup = MasterProductGroup::withTrashed()->where('codeProductGroup', $request->codeProductGroup)->first();

            if ($productGroup) {
                $productGroup->restore();
                $productGroup->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete
            MasterProductGroup::create($data);

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
        $masterProductGroup = MasterProductGroup::findOrFail($id);
        // dd($masterProductGroup);

        return response()->json([
            'data' => new MasterProductGroupResource($masterProductGroup),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterProductGroup $masterProductGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterProductGroupRequest $request, $id)
    {
        $masterProductGroup = MasterProductGroup::findOrFail($id);
        $masterProductGroup['updated_by'] = Auth::id();
        $origin = clone $masterProductGroup;
        // dd(gettype($masterProductGroup));
        // 
        $masterProductGroup->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterProductGroupResource($masterProductGroup),
                'message' => "Product Group type with name '$origin->nameProductGroup' has been changed  '$masterProductGroup->nameProductGroup'",
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
        $productGroup = MasterProductGroup::find($id);
        $origin = $productGroup;

        $exists = MasterProduct::where('codeProductGroup', $productGroup['codeProductGroup'])->exists();
        // dd($exists);
        if ($exists) {
            return response()->json([
                'message' => "Code Product Group cannot be deleted because it is linked to a product",
                'status' => Response::HTTP_FORBIDDEN
            ], Response::HTTP_FORBIDDEN);
        }

        $productGroup->delete();

        try {
            return response()->json([
                'message' => "Product Group with name '$origin->nameProductGroup' has been deleted",
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
