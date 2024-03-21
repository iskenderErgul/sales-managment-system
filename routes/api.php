<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/getProducts',[ProductController::class,'getAllProducts']);
    Route::post('/getProduct/{id}',[ProductController::class,'getProduct']);
    Route::delete('/deleteProduct/{id}',[ProductController::class,'deleteProduct']);
    Route::delete('/bulkDelete',[ProductController::class,'bulkDelete']);
    Route::post('/addProduct',[ProductController::class,'addProduct']);
    Route::put('/editProduct/{id}',[ProductController::class,'editProduct']);


    Route::get('/getCategory',[CategoryController::class,'getAllProducts']);
    Route::delete('/deleteCategory/{id}',[CategoryController::class,'deleteCategory']);
    Route::put('/editCategory/{id}',[CategoryController::class,'editCategory']);
    Route::post('/addCategory',[CategoryController::class,'addCategory']);

    Route::get('/getOrders',[OrderController::class,'getAllOrders']);


    Route::get('/logout',[LoginController::class,'logout']);


});



Route::post('/login',[LoginController::class,'login']);





