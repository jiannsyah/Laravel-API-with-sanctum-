<?php

use App\Http\Controllers\API\V1\ArticleController;
use App\Http\Controllers\API\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::prefix('V1')->group(function () {
    Route::resource('article', ArticleController::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
