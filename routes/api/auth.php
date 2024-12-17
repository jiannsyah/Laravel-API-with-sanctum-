<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;

Route::prefix('V1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
