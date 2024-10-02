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
Route::prefix('V1')->group(function () {
    // Route::get('/list-article', [ArticleController::class, 'index']);
    // Route::post('/store-article', [ArticleController::class, 'store']);
    // Route::get('/read-article/{id}', [ArticleController::class, 'show']);
    Route::resource('article', ArticleController::class);
});
