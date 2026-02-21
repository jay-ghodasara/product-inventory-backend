<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function() {
    Route::get('products', [ProductController::class,'index']);
    Route::get('products/{id}', [ProductController::class,'showProduct']);
    Route::post('products', [ProductController::class,'store']);
    Route::put('products/{id}', [ProductController::class,'update']);
    Route::post('products/{id}/stock', [ProductController::class,'updateStock'])->where('id', '[0-9]+');;
    Route::get('products/low-stock', [ProductController::class,'getProductWithMinimumLevel']);
});

