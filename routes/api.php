<?php

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
