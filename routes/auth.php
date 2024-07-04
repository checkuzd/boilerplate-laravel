<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

// Route::group(['prefix' => 'admin', 'middleware' => 'guest'], function () {
Route::get('/', AdminController::class)->name('login.check');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendForgotPassword'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'resetForgotPassword'])
    ->name('password.reset');
Route::post('reset-password', [AuthController::class, 'storeForgotPassword'])
    ->name('password.store');
// });
