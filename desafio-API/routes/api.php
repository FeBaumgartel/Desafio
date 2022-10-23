<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'get']);
    Route::get('/{id}', [ProductController::class, 'find']);
    Route::post('/', [ProductController::class, 'create']);
    Route::patch('/{id}', [ProductController::class, 'edit']);
});

Route::prefix('carts')->group(function () {
    Route::get('/', [CartController::class, 'get']);
    Route::get('/{id}', [CartController::class, 'find']);
    Route::post('/', [CartController::class, 'create']);
    Route::post('/{id}', [CartController::class, 'addProduct']);
    Route::post('/{id}/set-distance', [CartController::class, 'setDistance']);
});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'get']);
    Route::get('/{id}', [OrderController::class, 'find']);
    Route::post('/', [OrderController::class, 'create']);
});
