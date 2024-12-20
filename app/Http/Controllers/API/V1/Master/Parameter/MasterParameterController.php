<?php

namespace App\Http\Controllers\API\V1\Master\Parameter;

use App\Events\ParamsProcessed;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Parameter\StoreMasterParameterRequest;
use App\Http\Requests\Master\Parameter\UpdateMasterParameterRequest;
use App\Http\Resources\Master\Parameter\MasterParameterResource;
use App\Models\Master\Parameter\MasterParameter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Models\Audit;

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

    public function logs(Request $request)
    {
        $logs = Audit::where('auditable_type', MasterParameter::class)->get();

        if (request('event')) {
            if (request('event') !== 'created' && request('event') !== 'restored' && request('event') !== 'updated' && request('event') !== 'deleted') {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'The sent method is not correct'
                ], Response::HTTP_NOT_FOUND);
            }

            $logs = Audit::where('auditable_type', MasterParameter::class)->where('event', request('event'))->get();
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
