<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::prefix('/cars')->group(function () {
    Route::get('/', [CarController::class, 'getCars'])->name('cars.index');
    Route::post('/', [CarController::class, 'storeCar']);
    Route::get('/{id}', [CarController::class, 'getCarById']);
    Route::put('/{id}', [CarController::class, 'updateCar']);
    Route::delete('/{id}', [CarController::class, 'destroyCar']);
    Route::put('/maintainance/{id}' , [CarController::class , 'updateMaintainance']);
});

Route::prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/user/{id}', [OrderController::class, 'getUserOrders']);
    Route::put('/{orderId}/pay', [OrderController::class, 'updatePayment']);
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::put('/{id}', [OrderController::class, 'update']);
    Route::delete('/{id}', [OrderController::class, 'destroy']);
});
