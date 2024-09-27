<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/create_product', [\App\Http\Controllers\ProductController::class, 'create']);
