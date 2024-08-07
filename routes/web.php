<?php

use App\Http\Controllers\Auth\GoogleController;

Route::get('auth/google/redirect', [GoogleController::class, 'redirectToGoogle']);

Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


