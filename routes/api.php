<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Auth\GoogleController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//! tambahkan validasi user input di controller (untuk post dan put)
// TODO bikin ulang dokumentasi
// TODO implement guestcheck middleware
// TODO on berita, return whether user has liked or not
//* start from alumni

/**Auth
 * Endpoint : /auth/login (POST)
 * Request  : email, password, confirm_password (body)
 * Response : token
 * 
 * Endpoint : /auth/login (POST)
 * Request  : email, password (body)
 * Response : token
 * 
 * Endpoint : /auth/google (POST)
 * Request  : idtoken (body), ket: token_id dari google auth
 * Response : token
 * 
 */
Route::post('auth/google', [AuthController::class, 'handleGoogleLogin']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum', 'isNotBanned'])->group(function () {
    Route::get('berita', [BeritaController::class, 'get']);

    Route::get('user', [UserController::class, 'get']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    
    Route::get('berita/kategori', [BeritaController::class, 'category_get']);

    Route::get('event', [EventController::class, 'get']);

    Route::get('loker', [LokerController::class, 'get']);
    Route::get('loker/company', [LokerController::class, 'get_perusahaan']);
    
    Route::get('alumni', [AlumniController::class, 'get']);
    Route::post('alumni/claim-data', [AlumniController::class, 'claimDataALumniByUserId']);
    
    Route::middleware(['isAdmin'])->group(function () {
        Route::post('loker', [LokerController::class, 'post']);
        Route::delete('loker', [LokerController::class, 'delete']);
        Route::post('loker/company', [LokerController::class, 'post_perusahaan']);
        Route::delete('loker/company', [LokerController::class, 'delete_perusahaan']);
        
        Route::post('event', [EventController::class, 'post']);
        Route::delete('event', [EventController::class, 'delete']);
        
        Route::post('berita', [BeritaController::class, 'post']);
        Route::delete('berita', [BeritaController::class, 'delete']);
        Route::post('berita/kategori', [BeritaController::class, 'category_post']);
        Route::delete('berita/kategori', [BeritaController::class, 'category_delete']); 

        //! why use url parameter instead of request body?
        Route::delete('alumni/{id_alumni}', [AlumniController::class, 'delete']);
        Route::post('alumni', [AlumniController::class, 'post']);
    });    

});    
