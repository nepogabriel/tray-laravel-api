<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(SellerController::class)->group(function () {
    Route::get('/seller', 'index')->name('seller.index');
    Route::post('/seller', 'create')->name('seller.create');
});

Route::controller(SaleController::class)->group(function () {
    Route::get('/sale', 'index')->name('sale.index');
    Route::post('/sale', 'register')->name('sale.register');
    Route::get('/sale/{id}', 'find')->name('sale.find');
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/email/{id}', [MailController::class, 'sendEmail']);
