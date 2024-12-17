<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\Master\General\MasterCustomerController;
use App\Http\Controllers\API\V1\Master\General\MasterSalesmanController;
use App\Http\Controllers\API\V1\Master\General\MasterSupplierController;
use App\Http\Controllers\API\V1\Master\Premix\MasterPremixController;
use App\Http\Controllers\API\V1\Master\Premix\MasterPremixFormulaController;
use App\Http\Controllers\API\V1\Master\Premix\MasterPremixGroupController;
use App\Http\Controllers\API\V1\Master\Product\MasterProductController;
use App\Http\Controllers\API\V1\Master\Product\MasterProductGroupController;
use App\Http\Controllers\API\V1\Master\RawMaterial\MasterRawMaterialController;
use App\Http\Controllers\API\V1\Master\RawMaterial\MasterRawMaterialGroupController;
use App\Http\Controllers\API\V1\Master\RawMaterial\MasterRawMaterialTypeController;
use App\Http\Controllers\API\V1\User\UserController;
use Illuminate\Support\Facades\Route;


// use L5Swagger\L5SwaggerServiceProvider;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('unauthenticated', [ArticleController::class, 'unauthenticated'])->name('guest');



Route::prefix('V1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    // Route::post('register', [AuthController::class, 'register']);
    Route::get('/api/documentation', function () {
        return view('swagger');
    });

    Route::middleware('auth:sanctum')->group(function () {
        // 
        Route::resource('raw-material-type', MasterRawMaterialTypeController::class);
        Route::resource('raw-material-group', MasterRawMaterialGroupController::class);
        Route::resource('raw-material', MasterRawMaterialController::class);
        // 
        Route::resource('product-group', MasterProductGroupController::class);
        Route::resource('product', MasterProductController::class);
        // 
        Route::resource('premix-group', MasterPremixGroupController::class);
        Route::resource('premix-formula', MasterPremixFormulaController::class);
        Route::resource('premix', MasterPremixController::class);
        // 
        Route::resource('customer', MasterCustomerController::class);
        Route::resource('supplier', MasterSupplierController::class);
        Route::resource('salesman', MasterSalesmanController::class);
        // 
        Route::middleware(['role:admin'])->group(function () {
            Route::resource('user', UserController::class);
        });
        // 
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
