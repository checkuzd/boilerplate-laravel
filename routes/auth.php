<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], function () {
    Route::get('/', AdminController::class)->name('login.check');
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('password.request');
    Route::post('forgot-password', [ResetPasswordController::class, 'sendForgotPassword'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'resetForgotPassword'])
        ->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'createNewPassword'])
        ->name('password.store');
});
