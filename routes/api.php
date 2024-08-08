<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use Illuminate\Support\Facades\Route;

Route::get('berita', [BeritaController::class, 'getAll']);

// Route::get('auth/google/redirect', [GoogleController::class, 'redirectToGoogle']);
// Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::post('auth/login',       [AuthController::class, 'login']);
Route::post('auth/register',    [AuthController::class, 'register']);
Route::post('auth/google',      [AuthController::class, 'handleGoogleLogin']);

Route::get('alumni',            [AlumniController::class, 'getAllDataAlumni']);
Route::get('alumni/{id}',       [AlumniController::class, 'getDataAlumniById']);
Route::post('alumni',           [AlumniController::class, 'addDataAlumni']);
Route::put('alumni/{id}',       [AlumniController::class, 'updateDataAlumniById']);
Route::delete('alumni/{id}',    [AlumniController::class, 'deleteDataAlumniById']);
