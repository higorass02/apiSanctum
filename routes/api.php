<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\LoginController;
use \App\Http\Controllers\Api\Store\CategoriesController;
use \App\Http\Controllers\Api\Salao\ClienteController;
use \App\Http\Controllers\Api\Salao\ServicesController;
use \App\Http\Controllers\Api\Salao\SchedulingController;
use \App\Http\Controllers\Api\Store\ProductsController;
use \App\Http\Controllers\Api\Store\ProductsStockController;
use \App\Http\Controllers\Api\Store\ProductsPhotoController;
use \App\Http\Controllers\Api\Store\ProductsSalesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', [AuthController::class, 'register']);

Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function(Request $request) {
        return auth()->user();
    });

    Route::post('auth/logout', [AuthController::class, 'logout']);
});

Route::post('login',[LoginController::class,'authenticate']);

Route::prefix('/store')->group(function () {
    Route::prefix('/categories')->group(function () {
        Route::get('',[CategoriesController::class, 'index']);
        Route::post('',[CategoriesController::class, 'store']);
        Route::patch('/{id}',[CategoriesController::class, 'update']);
        Route::get('/{id}',[CategoriesController::class, 'show']);
        Route::delete('/{id}',[CategoriesController::class, 'disable']);
        Route::post('/{id}/enable',[CategoriesController::class, 'enable']);
    });
    
    Route::prefix('/products')->group(function () {
        Route::get('',[ProductsController::class, 'index']);
        Route::post('',[ProductsController::class, 'store']);
        Route::patch('/{id}',[ProductsController::class, 'update']);
        Route::get('/{id}',[ProductsController::class, 'show']);
        Route::delete('/{id}',[ProductsController::class, 'disable']);
        Route::post('/{id}/enable',[ProductsController::class, 'enable']);
    });
    
    Route::prefix('/products-stock')->group(function () {
        Route::get('',[ProductsStockController::class, 'index']);
        Route::post('',[ProductsStockController::class, 'store']);
        Route::patch('/{id}',[ProductsStockController::class, 'update']);
        Route::get('/{id}',[ProductsStockController::class, 'show']);
        Route::delete('/{id}',[ProductsStockController::class, 'delete']);
        Route::get('/for-product/{id}',[ProductsStockController::class, 'showStockForProduct']);
    });
    
    Route::prefix('/products-photo')->group(function () {
        Route::get('',[ProductsPhotoController::class, 'index']);
        Route::post('',[ProductsPhotoController::class, 'store']);
        Route::patch('/{id}',[ProductsPhotoController::class, 'update']);
        Route::get('/{id}',[ProductsPhotoController::class, 'show']);
        Route::delete('/{id}',[ProductsPhotoController::class, 'delete']);
        Route::get('/for-product/{id}',[ProductsPhotoController::class, 'showPhotoForProduct']);
    });
    
    Route::prefix('/products-sales')->group(function () {
        Route::get('',[ProductsSalesController::class, 'index']);
        Route::post('',[ProductsSalesController::class, 'store']);
        Route::patch('/{id}',[ProductsSalesController::class, 'update']);
        Route::get('/{id}',[ProductsSalesController::class, 'show']);
        Route::delete('/{id}',[ProductsSalesController::class, 'delete']);
        Route::get('/for-product/{id}',[ProductsSalesController::class, 'showSaleForProduct']);
    });
});

Route::prefix('/salao')->group(function () {
    Route::prefix('/clientes')->group(function () {
        Route::get('',[ClienteController::class, 'index']);
        Route::post('',[ClienteController::class, 'store']);
        Route::patch('/{id}',[ClienteController::class, 'update']);
        Route::get('/{id}',[ClienteController::class, 'show']);
        Route::delete('/{id}',[ClienteController::class, 'disable']);
        Route::post('/{id}/enable',[ClienteController::class, 'enable']);
        Route::post('/suggestion',[ClienteController::class, 'cLienteSuggestion']);
    });
    Route::prefix('/services')->group(function () {
        Route::get('',[ServicesController::class, 'index']);
        Route::post('',[ServicesController::class, 'store']);
        Route::patch('/{id}',[ServicesController::class, 'update']);
        Route::get('/{id}',[ServicesController::class, 'show']);
        Route::delete('/{id}',[ServicesController::class, 'disable']);
        Route::post('/{id}/enable',[ServicesController::class, 'enable']);
    });
    Route::prefix('/scheduling')->group(function () {
        Route::get('',[SchedulingController::class, 'index']);
        Route::post('',[SchedulingController::class, 'store']);
        Route::patch('/{id}',[SchedulingController::class, 'update']);
        Route::get('/{id}',[SchedulingController::class, 'show']);
        Route::delete('/{id}',[SchedulingController::class, 'disable']);
        Route::post('/{id}/enable',[SchedulingController::class, 'enable']);
    });
});