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
    Route::get('get-events/{user_id}/{user_type}', [EventsController::class, 'getEventsList']);
    Route::get('get-all-events', [EventsController::class, 'getAllEventsList']);
    Route::post('new-event', [EventsController::class, 'newEvent']);
    Route::get('get-event/{event_id}', [EventsController::class, 'getEvent']);
});
