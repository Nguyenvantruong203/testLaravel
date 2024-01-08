<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatusController;

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

Route::get('/user/{id}', [UserController::class, 'show']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}/edit', [UserController::class, 'edit']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);
Route::get('/getUser', [UserController::class, 'getUser'])->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Route::controller(AuthController::class)->group(function(){
//     Route::post('login', 'login');
//     Route::post('register', 'register');
// });

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/create', [ProductController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);


Route::get('/home', [HomeController::class, 'showHome']);
Route::get('/home/{id}', [HomeController::class, 'detail']);

// Route::post('/cart', [CartController::class, 'addToCart']);
// Route::get('/cart', [CartController::class, 'showCart']);
// Route::delete('cart/{id}', [CartController::class, 'destroy']);

Route::get('/department', [DepartmentController::class, 'index']);
Route::get('/department/create', [DepartmentController::class, 'create']);
Route::post('/department', [DepartmentController::class, 'store']);
Route::get('/department/{id}/edit', [DepartmentController::class, 'edit']);
Route::put('/department/{id}', [DepartmentController::class, 'update']);
Route::delete('department/{id}', [DepartmentController::class, 'destroy']);


Route::get('/status', [StatusController::class, 'index']);
Route::get('/status/create', [StatusController::class, 'create']);
Route::post('/status', [StatusController::class, 'store']);
Route::get('/status/{id}/edit', [StatusController::class, 'edit']);
Route::put('/status/{id}', [StatusController::class, 'update']);
Route::delete('status/{id}', [StatusController::class, 'destroy']);
