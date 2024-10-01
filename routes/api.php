<?php

use App\Http\Controllers\API\V1\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
// Route::get('/greeting', function () {
//     return 'Hello World';
// });

Route::get('/list-articles', ArticleController::class, 'index');
