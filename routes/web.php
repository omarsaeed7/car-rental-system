<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/cars', [CarController::class, 'getCars']);
// Route::get('/cars-with-image', [CarController::class, 'showWithImage']);
Route::post('/cars', [CarController::class, 'storeCar']);
Route::get('/cars/{search}', [CarController::class, 'viewSingleCar']);
Route::put('/cars/{id}', [CarController::class, 'updateCar']);
Route::delete('/cars/{id}', [CarController::class, 'destroyCar']);

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/user/{id}',[OrderController::class,'getUserOrders']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::put('/orders/{orderId}/pay',[OrderController::class, 'updatePayment']);