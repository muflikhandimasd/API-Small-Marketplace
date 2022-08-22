<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MyCartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ! PRODUCT
Route::post('create-product', [ProductController::class, 'createProduct']);
Route::post('get-products', [ProductController::class, 'getDataProduct']);
Route::post('add-to-cart', [ProductController::class, 'addToCart']);

// ! CART
Route::post('get-cart', [MyCartController::class, 'index']);

// ! CATEGORY
Route::post('create-category', [CategoryController::class, 'create']);
Route::post('get-all-category', [CategoryController::class, 'index']);
