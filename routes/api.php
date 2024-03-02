<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/products', [ProductController::class, 'showAll']);
Route::get('/show-collection', [ProductController::class, 'showCollection']);
Route::get('/last-product',[ProductController::class,'lastProduct']);
Route::get('/blogs', [BlogController::class, 'showAll']);
Route::get('/product/{id}', [ProductController::class, 'getProduct']);
Route::get('/user',[AuthController::class,'user'])->middleware('auth:sanctum');
Route::get('/phone-contact',[PhoneController::class, 'getAll']);

Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth:sanctum');

Route::prefix('/user')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/add-to-cart?product={id}&quantity={q}', [CartController::class, 'addProduct']);
    Route::get('/cart-user', [CartController::class, 'showAll']);
    Route::get('/home', [HomeController::class, 'index']);
});

Route::prefix('/admin')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/create-product',[ProductController::class,'addProduct']);
    Route::get('/add-product-data',[ProductController::class,'formData']);
    Route::get('/all-user',[AuthController::class,'allUser']);
    Route::get('/dashboard',[AdminController::class, 'dashboard']);
    Route::post('/add-phone-contact',[AdminController::class, 'newPhone']);
    Route::post('/new-post',[BlogController::class,'newPost']);
});
