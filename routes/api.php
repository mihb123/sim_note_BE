<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register')->middleware('throttle:5,1')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('logout');

    Route::prefix('email')->as('verification.')->group(function () {
        Route::get('/verify/{id}/{hash}', 'verifyEmail')
            ->middleware('signed')
            ->name('verify');

        Route::get('/verification-notification', 'sendVerification')
            ->middleware(['auth:sanctum', 'throttle:6,1'])
            ->name('send');
    });    
});