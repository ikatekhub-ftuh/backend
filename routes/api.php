<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\EventController;

use Illuminate\Support\Facades\Route;

//! tambahkan validasi user input di controller (untuk post dan put)
// TODO implement guestcheck middleware
// TODO on berita, return whether user has liked or not
// * check berita search
// * check alumni search
// * frontend: maybe add file compression to webp

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
    /**
     * Endpoint : /berita (GET)
     * Request  : id_kategori_berita, limit (items per page), page
     * Response : message, request, data
     */
    Route::get('berita', [BeritaController::class, 'get']);
    Route::post('user/update-avatar', [UserController::class, 'updateAvatar']);
    //! tentukan mau pakai id atau slug
    Route::get('berita/{id_berita}', [BeritaController::class, 'getById']);
    Route::get('berita/slug/{slug}', [BeritaController::class, 'getBySlug']);

    Route::get('berita/kategori', [BeritaController::class, 'category_get']);
    Route::get('user', [UserController::class, 'get']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('alumni/claim-data', [AlumniController::class, 'claimDataALumniByUserId']);
    Route::post('alumni', [AlumniController::class, 'post']);


    Route::middleware(['guestOnly'])->group(function () {});

    Route::middleware(['noGuest'])->group(function () {
        Route::get('event', [EventController::class, 'get']);
        Route::get('loker', [LokerController::class, 'get']);
        Route::get('loker/perusahaan', [LokerController::class, 'get_perusahaan']);
        Route::get('alumni', [AlumniController::class, 'get']);
    });

    Route::middleware(['isAdmin'])->group(function () {
        Route::post('user/banned', [UserController::class, 'bannedUser']);
        Route::post('user/unbanned', [UserController::class, 'unBannedUser']);
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
        Route::delete('alumni/{id_alumni}', [AlumniController::class, 'delete']);
    });
});
