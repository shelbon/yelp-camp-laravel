<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\RegisteredUserController2;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('signup', [RegisteredUserController::class, 'show'])
                ->name('register');

    Route::post('signup', [RegisteredUserController::class, 'register']);

    Route::get('signin', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('signin', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});
Route::get('/email/verify', [VerifyEmailController::class, 'show'])
    ->name('verification.show')->middleware("signed");
Route::middleware('auth')->group(function () {
    Route::post('/email/verify', [VerifyEmailController::class, 'verify'])
        ->name('verification.verify');
    Route::post('/email/resend', [VerifyEmailController::class, 'resend'])
        ->name('verification.resend');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
