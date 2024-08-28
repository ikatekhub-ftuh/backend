<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\searchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\EventController;

use Illuminate\Support\Facades\Route;

//! tambahkan validasi user input di controller (untuk post dan put)
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
Route::post('auth/login', [AuthController::class, 'login']); //done
Route::get('alumni/data', [AlumniController::class, 'getDataToClaim']);

Route::middleware(['auth:sanctum', 'isNotBanned'])->group(function () {
    Route::get('search/{search}', [searchController::class, 'search']); //done
    Route::get('jurusan', [AlumniController::class, 'getJurusan']); //done

    Route::get('berita', [BeritaController::class, 'get']); //done
    Route::get('berita/kategori', [BeritaController::class, 'category_get']); //done
    Route::post('berita/like', [BeritaController::class, 'togglelike']); //done
    Route::get('berita/list-like', [BeritaController::class, 'listLikes']); //done

    Route::get('user', [UserController::class, 'get']); //done
    Route::post('user/update', [UserController::class, 'update']); //done
    Route::post('user/delete', [UserController::class, 'delete']);

    Route::post('auth/logout', [AuthController::class, 'logout']); //done

    Route::get('event', [EventController::class, 'get']); //done
    // Route::get('event/list-peserta', [EventController::class, 'pesertaEvent']); //done
    Route::post('event/register', [EventController::class, 'toggleRegister']);
    //Route::post('event/register', [EventController::class, 'register']); //done
    //Route::post('event/unregister', [EventController::class, 'unregister']); //done


    Route::post('alumni', [AlumniController::class, 'post']);

    Route::middleware(['guestOnly'])->group(function () {
        Route::post('alumni/claim-data', [AlumniController::class, 'claimDataALumniByUserId']);
    });

    Route::middleware(['noGuest'])->group(function () {
        Route::get('alumni', [AlumniController::class, 'get']);
        Route::get('loker', [LokerController::class, 'get']); //done
        Route::get('loker/id/{id}', [LokerController::class, 'getbyId']); //done
        Route::get('event/id/{id}', [EventController::class, 'getbyId']); //done
        Route::get('berita/id/{id}', [BeritaController::class, 'getById']); //done
        Route::put('alumni', [AlumniController::class, 'update']);
    });

    Route::middleware(['isAdmin'])->group(function () {
        Route::get('loker/perusahaan', [LokerController::class, 'get_perusahaan']); //done
        Route::post('user/banned', [UserController::class, 'banUser']); //done
        Route::post('user/unbanned', [UserController::class, 'unBanUser']); //done
        Route::post('berita', [BeritaController::class, 'post']);

        // kebutuhan admin nanti
        // Route::post('loker', [LokerController::class, 'post']);
        // Route::delete('loker', [LokerController::class, 'delete']);
        Route::post('loker/perusahaan', [LokerController::class, 'post_perusahaan']);
        // Route::delete('loker/perusahaan', [LokerController::class, 'delete_perusahaan']);
        // Route::post('event', [EventController::class, 'post']);
        // Route::delete('event', [EventController::class, 'delete']);
        // Route::post('berita', [BeritaController::class, 'post']);
        // Route::delete('berita', [BeritaController::class, 'delete']);
        // Route::post('berita/kategori', [BeritaController::class, 'category_post']);
        // Route::delete('berita/kategori', [BeritaController::class, 'category_delete']);
        // Route::delete('alumni/id/{id_alumni}', [AlumniController::class, 'delete']);
        // Route::post('alumni', [AlumniController::class, 'post']);
        Route::post('alumni/upload', [AlumniController::class, 'uploadData']); //done
    });
});
