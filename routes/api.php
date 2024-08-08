<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Auth\GoogleController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('berita',        [BeritaController::class, 'getAllDataBerita']);
Route::get('berita/{id}',   [BeritaController::class, 'getAllDataBeritaById']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('api/auth/google/redirect', [GoogleController::class, 'redirectToGoogle']);
Route::get('api/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
