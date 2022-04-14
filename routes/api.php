<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\LoginController;
use \App\Http\Controllers\Api\CategoriesController;
use \App\Http\Controllers\Api\ProductsController;
use \App\Http\Controllers\Api\ProductsStockController;

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
