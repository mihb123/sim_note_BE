<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;

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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::get('/notes', [NoteController::class, 'getNotes'])->middleware('throttle:200,1')->name('get-notes');
    Route::post('/notes-update', [NoteController::class, 'updateNote'])->name('update-note');
    Route::post('/notes-create', [NoteController::class, 'createNote'])->name('create-note');
    Route::delete('/notes-delete/{noteId}', [NoteController::class, 'deleteNote'])->name('delete-note');
    Route::get('/notes/{id}', [NoteController::class, 'getNoteById'])->name('get-note-by-id');
    Route::post('/notes-share/{id}', [NoteController::class, 'shareNote'])->name('share-note');
    Route::delete('/notes-unshare/{shareId}', [NoteController::class, 'unshareNote'])->name('unshare-note');
    Route::get('/notes-shared', [NoteController::class, 'getSharedNotes'])->name('shared-notes');
});

Route::get('/alive', function () {
	return response()->json([
	    'status' => 'ok',
	    'env' => config('app.env'),
	    'app_name' => config('app.name'),
	], 200);
});
