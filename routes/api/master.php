<?php

use App\Http\Controllers\API\V1\Master\Account\MasterBalanceSheetAccountController;
use App\Http\Controllers\API\V1\Master\Account\MasterGeneralLedgerAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Master\General\MasterCustomerController;
use App\Http\Controllers\API\V1\Master\General\MasterSalesmanController;
use App\Http\Controllers\API\V1\Master\General\MasterSupplierController;
use App\Http\Controllers\API\V1\Master\Parameter\MasterParameterController;
use App\Http\Controllers\API\V1\Master\Premix\MasterPremixController;
use App\Http\Controllers\API\V1\Master\Premix\MasterPremixFormulaController;
use App\Http\Controllers\API\V1\Master\Premix\MasterPremixGroupController;
use App\Http\Controllers\API\V1\Master\Product\MasterProductController;
use App\Http\Controllers\API\V1\Master\Product\MasterProductGroupController;
use App\Http\Controllers\API\V1\Master\RawMaterial\MasterRawMaterialController;
use App\Http\Controllers\API\V1\Master\RawMaterial\MasterRawMaterialGroupController;
use App\Http\Controllers\API\V1\Master\RawMaterial\MasterRawMaterialTypeController;
use App\Models\Master\Parameter\MasterParameter;

Route::prefix('V1')->middleware('auth:sanctum')->group(function () {
    Route::resource('raw-material-type', MasterRawMaterialTypeController::class);
    Route::resource('raw-material-group', MasterRawMaterialGroupController::class);
    Route::resource('raw-material', MasterRawMaterialController::class);

    Route::resource('product-group', MasterProductGroupController::class);
    Route::resource('product', MasterProductController::class);

    Route::resource('premix-group', MasterPremixGroupController::class);
    Route::resource('premix-formula', MasterPremixFormulaController::class);
    Route::resource('premix', MasterPremixController::class);

    Route::resource('customer', MasterCustomerController::class);
    Route::resource('supplier', MasterSupplierController::class);
    Route::resource('salesman', MasterSalesmanController::class);

    Route::resource('balance-sheet-account', MasterBalanceSheetAccountController::class);
    Route::resource('general-ledger-account', MasterGeneralLedgerAccountController::class);
    // Route::get('general-ledger-account/logs', [MasterGeneralLedgerAccountController::class, 'logs'])->name('general-ledger-account.logs');

    Route::resource('parameter', MasterParameterController::class);
});
