<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AlumniController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// Route::get('berita', [BeritaController::class, 'getAll']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::get('api/auth/google/redirect', [GoogleController::class, 'redirectToGoogle']);
// Route::get('api/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Route::get('api/alumni',            [AlumniController::class, 'getAllDataAlumni']);
// Route::get('api/alumni/{id}',       [AlumniController::class, 'getDataAlumniById']);
// Route::post('api/alumni',           [AlumniController::class, 'addDataAlumni']);
// Route::put('api/alumni/{id}',       [AlumniController::class, 'aupdateDataAlumniById']);
// Route::delete('api/alumni/{id}',    [AlumniController::class, 'deleteDataAlumniById']);


Route::get('/auth/redirect', function () {
    // return response()->json(['id' => 'id']);
    return Socialite::driver('google')->redirect();
});
 
Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();
    dd($user);
 
    // $user->token
});