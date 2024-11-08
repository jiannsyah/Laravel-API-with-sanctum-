<?php

use App\Http\Controllers\API\V1\ArticleController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\Master\RawMaterial\MasterRawMaterialGroupController;
use App\Http\Controllers\API\V1\Master\RawMaterial\MasterRawMaterialTypeController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('unauthenticated', [ArticleController::class, 'unauthenticated'])->name('guest');


Route::prefix('V1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    // 
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware([CheckPermission::class])->group(function () {
            Route::resource('article', ArticleController::class);
            Route::resource('raw-material-type', MasterRawMaterialTypeController::class);
            Route::resource('raw-material-group', MasterRawMaterialGroupController::class);
        });

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
