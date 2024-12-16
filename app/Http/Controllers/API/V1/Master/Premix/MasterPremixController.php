<?php

namespace App\Http\Controllers\API\V1\Master\Premix;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Premix\StoreMasterPremixRequest;
use App\Http\Requests\Master\Premix\UpdateMasterPremixRequest;
use App\Http\Resources\Master\Premix\MasterPremixCollection;
use App\Http\Resources\Master\Premix\MasterPremixResource;
use App\Models\MasterPremix;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


/**
 * @OA\Info(title="Docs", version="1.0.0")
 */

class MasterPremixController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *     path="/api/V1/premix", 
     *     summary="Get list Premixes",
     *     security={
     *        {"bearerAuth": {}}
     *     },
     *     tags={"Premix"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success", 
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="uuid"),
     *                 @OA\Property(property="codePremix", type="string", example="code"),
     *                 @OA\Property(property="namePremix", type="string", example="namePremix"),
     *                 @OA\Property(property="unitOfMeasurement", type="string", example="unitOfMeasurement"),
     *                 @OA\Property(property="status", type="string", example="status"),
     *                 @OA\Property(
     *                     property="group",
     *                     type="object",
     *                     @OA\Property(property="codePremixGroup", type="string", example="codePremixGroup"),
     *                     @OA\Property(property="namePremixGroup", type="string", example="namePremixGroup"),
     *                 ),
     *                 @OA\Property(property="created_by", type="string", example="created_by")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */

    public function index()
    {
        $user = Auth::user();
        if ($user['name'] === 'jian') {
            $query = MasterPremix::withTrashed()->with('group')->orderBy('codePremix', 'asc');
            // $query = MasterPremix::with('group')->orderBy('codePremix', 'asc');
        } else {
            $query = MasterPremix::with('group')->orderBy('codePremix', 'asc');
        }

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

    /**
     * @OA\Post(
     *     path="/api/V1/premix",
     *     summary="Create a new Premix",
     *     description="Create a new premix entry",
     *     operationId="createPremix",
     *     tags={"Premix"},
     *     security={
     *        {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Premix object that needs to be created",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"codePremix","namePremix","codePremixGroup"},
     *             @OA\Property(property="codePremix", type="string", example="4000103"),
     *             @OA\Property(property="namePremix", type="string", example="PREMIX-1C"),
     *             @OA\Property(property="codePremixGroup", type="string", example="40001"),
     *             @OA\Property(property="unitOfMeasurement", type="string", example="BKS"),
     *             @OA\Property(property="status", type="string", example="Active"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data stored to dbd",

     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed Data stored to dbd",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Premix already exists",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Premix already exists"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="codePremix", type="array", items=@OA\Items(type="string"), example={"Premix already exists"})
     *             )
     *         )
     *     ),
     * 
     * )
     */

    public function store(StoreMasterPremixRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        // dd($data);
        try {
            $premix = MasterPremix::withTrashed()->where('codePremix', $request->codePremix)->first();

            if ($premix) {
                $premix->restore();
                $premix->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete

            MasterPremix::create($data);

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
    /**
     * @OA\Get(
     *     path="/api/V1/premix/{id}", 
     *     summary="Get Premix by ID",
     *     security={
     *        {"bearer": {}}
     *     },
     *     tags={"Premix"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the premix",
     *         @OA\Schema(type="string", example="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success", 
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="uuid"),
     *                 @OA\Property(property="codePremix", type="string", example="code"),
     *                 @OA\Property(property="namePremix", type="string", example="namePremix"),
     *                 @OA\Property(property="unitOfMeasurement", type="string", example="unitOfMeasurement"),
     *                 @OA\Property(property="status", type="string", example="status"),
     *         @OA\Property(
     *         property="group",
     *         type="object",
     *         @OA\Property(property="codePremixGroup", type="string", example="codePremixGroup"),
     *         @OA\Property(property="namePremixGroup", type="string", example="namePremixGroup"),
     *     ),
     *                 @OA\Property(property="created_by", type="string", example="created_by"),

     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */    public function show($id)
    {
        $masterPremix = MasterPremix::with('group')->findOrFail($id);
        // dd($masterPremix);

        return response()->json([
            'data' => new MasterPremixResource($masterPremix),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
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

    /**
     * @OA\Put(
     *     path="/api/V1/premix/{id}",
     *     summary="Update a Premix",
     *     description="Update a premix entry",
     *     operationId="updatePremix",
     *     tags={"Premix"},
     *     security={
     *        {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Premix with ID to be updated",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Premix object that needs to be updated",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"namePremix"},
     *             @OA\Property(property="namePremix", type="string", example="PREMIX-1C"),
     *             @OA\Property(property="unitOfMeasurement", type="string", example="BKS"),
     *             @OA\Property(property="status", type="string", example="Active"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Premix has been changed  ",

     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed Data stored to dbd",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Premix already exists",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Premix already exists"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="codePremix", type="array", items=@OA\Items(type="string"), example={"Premix already exists"})
     *             )
     *         )
     *     ),
     * 
     * )
     */
    public function update(UpdateMasterPremixRequest $request, $id)
    {
        $masterPremix = MasterPremix::with('group')->findOrFail($id);
        $masterPremix['updated_by'] = Auth::id();
        $origin = clone $masterPremix;
        // dd($masterPremix);
        // 
        $masterPremix->update($request->validated());

        try {
            return response()->json([
                'data' => new MasterPremixResource($masterPremix),
                'message' => "Premix with name '$origin->namePremix' has been changed  '$masterPremix->namePremix'",
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

    /**
     * @OA\Delete(
     *     path="/api/V1/premix/{id}",
     *     summary="Delete a Premix",
     *     description="Delete a premix entry",
     *     operationId="deletePremix",
     *     tags={"Premix"},
     *     security={
     *        {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Premix with ID to be updated",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Premix has been deleted",

     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed Premix deleted",
     *     ),
     * )
     */
    public function destroy($id)
    {
        $premix = MasterPremix::find($id);
        $origin = clone $premix;

        // $exists = MasterPremix::where('codePremix', $id)->exists();
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
