<?php

use App\Http\Controllers\API\V1\Logs\LogsController;
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

Route::prefix('V1/logs')->middleware('auth:sanctum')->group(function () {
    Route::get('customer', [MasterCustomerController::class, 'logs'])->name('logs.customer');
    Route::get('supplier', [MasterSupplierController::class, 'logs'])->name('logs.supplier');
    Route::get('salesman', [MasterSalesmanController::class, 'logs'])->name('logs.salesman');
    // 
    Route::get('premix', [MasterPremixController::class, 'logs'])->name('logs.premix');
    Route::get('premix-formula', [MasterPremixFormulaController::class, 'logs'])->name('logs.premix-formula');
    Route::get('premix-group', [MasterPremixGroupController::class, 'logs'])->name('logs.premix-group');
    // 
    Route::get('product-group', [MasterProductGroupController::class, 'logs'])->name('logs.product-group');
    Route::get('product', [MasterProductController::class, 'logs'])->name('logs.product');
    // 
    Route::get('raw-material', [MasterRawMaterialController::class, 'logs'])->name('logs.raw-material');
    Route::get('raw-material-type', [MasterRawMaterialTypeController::class, 'logs'])->name('logs.raw-material-type');
    Route::get('raw-material-group', [MasterRawMaterialGroupController::class, 'logs'])->name('logs.raw-material-group');
    // 
    Route::get('general-ledger-account', [MasterGeneralLedgerAccountController::class, 'logs'])->name('logs.general-ledger-acccount');
    Route::get('balance-sheet-account', [MasterBalanceSheetAccountController::class, 'logs'])->name('logs.balance-sheet-acccount');
});
