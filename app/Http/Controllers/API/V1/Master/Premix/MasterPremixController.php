<?php

namespace App\Http\Controllers\API\V1\Master\Premix;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Premix\StoreMasterPremixRequest;
use App\Http\Requests\Master\Premix\UpdateMasterPremixRequest;
use App\Http\Resources\Master\Premix\MasterPremixCollection;
use App\Http\Resources\Master\Premix\MasterPremixResource;
use App\Models\MasterPremix;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterPremixController extends Controller
{
    /**
     * Display a listing of the resource.
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
    public function store(StoreMasterPremixRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        // dd($data);
        try {
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
    public function show($id)
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
                'message' => "Premix type with name '$origin->namePremix' has been changed  '$masterPremix->namePremix'",
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
        // $user = Auth::user();
        // if (strtoupper($user['name']) === strtoupper('jian')) {
        //     // dd($user['name']);
        //     // # code...
        //     $premix = MasterPremix::withTrashed()->find($id);
        //     $origin = clone $premix;
        //     $premix->forceDelete();
        // } else {
        //     $premix = MasterPremix::find($id);
        //     $origin = clone $premix;
        //     $premix->delete();
        // }
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
