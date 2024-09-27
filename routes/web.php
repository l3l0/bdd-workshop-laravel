<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/create_product', [\App\Http\Controllers\ProductController::class, 'create']);
