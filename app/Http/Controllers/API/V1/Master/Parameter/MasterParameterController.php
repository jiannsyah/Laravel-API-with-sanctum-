<?php

namespace App\Http\Controllers\API\V1\Master\Parameter;

use App\Events\ParamsProcessed;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Parameter\StoreMasterParameterRequest;
use App\Http\Requests\Master\Parameter\UpdateMasterParameterRequest;
use App\Http\Resources\Master\Parameter\MasterParameterResource;
use App\Models\Master\Parameter\MasterParameter;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MasterParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function store(StoreMasterParameterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterParameter $masterParameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterParameter $masterParameter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterParameterRequest $request, $id)
    {
        $masterParameter = MasterParameter::first();
        $masterParameter['updated_by'] = Auth::id();
        // dd($masterParameter);
        // 
        $masterParameter->update($request->validated());

        try {
            return response()->json([
                // 'data' => new MasterParameterResource($masterParameter),
                'message' => "Sucessfully updated data to db",
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);

            event(new ParamsProcessed());
        } catch (Exception $e) {
            Log::error('Error updated data :' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed Data updated to db'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterParameter $masterParameter)
    {
        //
    }
}
