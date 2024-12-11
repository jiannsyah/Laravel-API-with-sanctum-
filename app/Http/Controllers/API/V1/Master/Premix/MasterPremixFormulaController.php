<?php

namespace App\Http\Controllers\API\V1\Master\Premix;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Premix\StoreMasterPremixFormulaRequest;
use App\Http\Requests\Master\Premix\UpdateMasterPremixFormulaRequest;
use App\Http\Resources\Master\Premix\MasterPremixFormulaResource;
use App\Models\MasterPremixFormula;
use Illuminate\Http\Response;


class MasterPremixFormulaController extends Controller
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
    public function store(StoreMasterPremixFormulaRequest $request)
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $masterPremixFormula = MasterPremixFormula::findOrFail($id);
        // dd($masterPremixFormula);

        return response()->json([
            'data' => new MasterPremixFormulaResource($masterPremixFormula),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterPremixFormula $masterPremixFormula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterPremixFormulaRequest $request, MasterPremixFormula $masterPremixFormula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterPremixFormula $masterPremixFormula)
    {
        //
    }
}
