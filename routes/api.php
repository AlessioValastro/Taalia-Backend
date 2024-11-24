<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventsController;

Route::middleware(['web'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check-session', [AuthController::class, 'checkSession']);
    Route::post('/signup-organizer', [AuthController::class, 'signupOrganizer']);
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::get('get-events/{user_id}', [EventsController::class, 'getEventsList']);
    Route::get('get-all-events', [EventsController::class, 'getAllEventsList']);
});
