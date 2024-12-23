<?php

namespace App\Http\Controllers\API\V1\Master\Premix;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Premix\StoreMasterPremixGroupRequest;
use App\Http\Requests\Master\Premix\UpdateMasterPremixGroupRequest;
use App\Http\Resources\Master\Premix\MasterPremixGroupCollection;
use App\Http\Resources\Master\Premix\MasterPremixGroupResource;
use App\Models\Master\Premix\MasterPremix;
use App\Models\Master\Premix\MasterPremixGroup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;

class MasterPremixGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/V1/premix-group", 
     *     summary="Get list Premix Groups",
     *     security={
     *        {"bearerAuth": {}}
     *     },
     *     tags={"PremixGroup"},
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
     *                 @OA\Property(property="codePremixGroup", type="string", example="code"),
     *                 @OA\Property(property="namePremixGroup", type="string", example="namePremix"),
     *                 @OA\Property(property="status", type="string", example="status"),
     *                 @OA\Property(
     *                     property="created_by",
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="name"),
     *                     @OA\Property(property="email", type="string", example="email")
     *                 )
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
        $query = MasterPremixGroup::query()->orderBy('codePremixGroup', 'asc');

        if (request('namePremixGroup')) {
            $query->where("namePremixGroup", "like", "%" . request("namePremixGroup") . "%");
        }

        $productGroups = $query->paginate(10);

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
            // Cek apakah data dengan `codePremix` sudah ada (termasuk yang terhapus)
            // karena menerapkan soft delete
            $premix = MasterPremixGroup::withTrashed()->where('codePremixGroup', $request->codePremixGroup)->first();

            if ($premix) {
                $premix->restore();
                $premix->update($request->validated());

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'Data restored to dbd'
                ], Response::HTTP_OK);
            }
            // akhir penerapan soft delete
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
        // dd($productGroup);
        $origin = $productGroup;

        $exists = MasterPremix::where('codePremixGroup', $productGroup['codePremixGroup'])->exists();
        // dd($exists);
        if ($exists) {
            return response()->json([
                'message' => "Code Premix Group cannot be deleted because it is linked to a premix",
                'status' => Response::HTTP_FORBIDDEN
            ], Response::HTTP_FORBIDDEN);
        }

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

    public function logs(Request $request)
    {
        $logs = Audit::where('auditable_type', MasterPremixGroup::class)->get();

        if (request('event')) {
            if (request('event') !== 'created' && request('event') !== 'restored' && request('event') !== 'updated' && request('event') !== 'deleted') {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'The sent method is not correct'
                ], Response::HTTP_NOT_FOUND);
            }

            $logs = Audit::where('auditable_type', MasterPremixGroup::class)->where('event', request('event'))->get();
        }

        // Format data log untuk response
        $data = $logs->map(function ($log) {
            return [
                // 'id' => $log->id,
                'event' => $log->event,
                'old_values' => $log->old_values,
                'new_values' => $log->new_values,
                'user_id' => $log->user_id,
                'user_name' => optional($log->user)->name, // Ambil nama user
                'created_at' => $log->created_at,
            ];
        });

        // Return dalam bentuk JSON
        return response()->json([
            'success' => true,
            'logs' => $data,
        ]);
    }
}
