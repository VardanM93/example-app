<?php

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


Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);



Route::group(['middleware' => ['auth:sanctum']], function(){


    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);


    Route::get('/product/{id}', [\App\Http\Controllers\Api\ProductController::class, 'getItem']);
    Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'getAllItems']);
    Route::post('/product', [\App\Http\Controllers\Api\ProductController::class, 'store']);
    Route::post('/product/{id}', [\App\Http\Controllers\Api\ProductController::class, 'update']);
    Route::delete('/product/{id}', [\App\Http\Controllers\Api\ProductController::class, 'destroy']);



});




