<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Authentication routes
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

// Categories routes

Route::get('/all_categories',[CategoryController::class,'index']);
Route::get('all_category_products/{cat}',[CategoryController::class,'getProducts']);
Route::get('/category/{id}',[CategoryController::class,'getOne']);
Route::post('/update_category/{id}',[CategoryController::class,'update']);
Route::post('/create_category',[CategoryController::class,'create']);
Route::delete('/delete_category/{id}',[CategoryController::class,'delete']);


// Product routes

Route::get('/all_products',[ProductController::class,'index']);
Route::get('/product/{id}',[ProductController::class,'getOne']);
Route::post('/update_product/{id}',[ProductController::class,'update']);
Route::post('/create_product',[ProductController::class,'create']);
Route::delete('/delete_product/{id}',[ProductController::class,'delete']);
// Order routes

Route::post('/createOrder',[OrdersController::class,'createOrder']);
