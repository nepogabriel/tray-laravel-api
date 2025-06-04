<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::controller(SellerController::class)->group(function () {
        Route::get('/seller', 'index')->name('seller.index');
        Route::post('/seller', 'create')->name('seller.create');
    });

    Route::controller(SaleController::class)->group(function () {
        Route::get('/sale', 'index')->name('sale.index');
        Route::post('/sale', 'register')->name('sale.register');
        Route::get('/sale/{id}', 'find')->name('sale.find');
    });

    Route::get('/email/{id}', [MailController::class, 'sendEmail']);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me']);
Route::get('/logout', [AuthController::class, 'logout']);
