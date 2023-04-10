<?php

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

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('register', [\App\Http\Controllers\AuthController::class, 'store']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('wallets', [\App\Http\Controllers\WalletController::class, 'index']);
    Route::post('wallets', [\App\Http\Controllers\WalletController::class, 'store']);
    Route::post('payment/top-up', [\App\Http\Controllers\PaymentController::class, 'store']);
    Route::post('payment/withdraw', [\App\Http\Controllers\PaymentController::class, 'store']);
    Route::get('payment/history', [\App\Http\Controllers\PaymentController::class, 'index']);
    Route::get('currencies', [\App\Http\Controllers\CurrencyController::class, 'index']);
});
