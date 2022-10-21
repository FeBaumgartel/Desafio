<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('product')->group(function () {
    Route::get('/', 'ProductController@get');
    Route::get('/{id}', 'ProductController@find');
    Route::post('/', 'ProductController@create');
    Route::patch('/{id}', 'ProductController@edit');
});
Route::prefix('cart')->group(function () {
    Route::get('/', 'CartController@get');
    Route::get('/{id}', 'CartController@find');
    Route::post('/', 'CartController@create');
    Route::post('/{id}', 'CartController@addProduct');
});
Route::prefix('order')->group(function () {
    Route::get('/', 'OrderController@get');
    Route::get('/{id}', 'OrderController@find');
    Route::post('/', 'OrderController@create');
});
