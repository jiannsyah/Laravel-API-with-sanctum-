<?php

use Illuminate\Support\Facades\Route;


Route::get('/api/documentation', function () {
    return view('swagger');
});
