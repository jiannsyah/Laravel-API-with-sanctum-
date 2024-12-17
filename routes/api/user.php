<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\User\UserController;

Route::prefix('V1')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::resource('user', UserController::class);
});
