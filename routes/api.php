<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\EventController;

use Illuminate\Support\Facades\Route;

//! tambahkan validasi user input di controller (untuk post dan put)
// TODO bikin ulang dokumentasi
//* start from alumni

/**
 * Berita Routes
 *
 * GET /berita
 * - Parameters:
 *   - id?: If present, page and limit will be ignored.
 *   - category?: Filter by category.
 *   - limit?: Number of items per page (default 10).
 *   - page?: Page number (default 1).
 * - Note:
 *  - If id is present, only one item will be returned.
 *  - using laravel pagination.
 *  - set limit to -1 to get all items.
 *
 * POST /berita
 * - Parameters:
 *   - judul
 *   - konten
 *   - id_kategori_berita
 *   - penulis
 *   - gambar:file
 *
 * DELETE /berita
 * - Parameters:
 *   - id: ID of the berita to delete.
 * 
 * Storage:
 * - /storage/gambar/berita/
 * 
 * To be Added:
 * - PUT /berita
 */
Route::get('berita', [BeritaController::class, 'get']);
Route::delete('berita', [BeritaController::class, 'delete']);
Route::post('berita', [BeritaController::class, 'post']);

/**
 * Kategori Berita Routes
 *
 * GET /berita/kategori
 * - Parameters:
 *   - id?: If present, will return one item, if not return all.
 *
 * To be Added:
 * - POST /berita/kategori
 * - DELETE /berita/kategori
 * - PUT /berita/kategori
 */
Route::get('berita/kategori', [BeritaController::class, 'category_get']);

/**Event Routes
 * 
 * GET /event
 * - Parameters:
 *   - id?: If present, will return event with the id. else return all event.
 * - Note:
 * 
 * POST /event
 * - Parameters:
 *   - judul
 *   - gambar
 *   - penyelenggara
 *   - konten
 *   - tgl_event
 *   - lokasi_event
 *   - kuota
 * 
 * To be Added:
 *   - PUT /event
 */
Route::get('event', [EventController::class, 'get']);
Route::delete('event', [EventController::class, 'delete']);
Route::post('event', [EventController::class, 'post']);

/**Loker
 * - GET: 
 * - POST: judul, gambar, lokasi, tgl_selesai:date, pengalaman_kerja:0-99, role, konten, perusahaan, gambar:filename, 
 * - DELETE: id
 */
Route::get('loker', [LokerController::class, 'get']);
Route::delete('loker', [LokerController::class, 'delete']);
Route::post('loker', [LokerController::class, 'post']);

Route::get('loker/company', [LokerController::class, 'get_perusahaan']);
Route::post('loker/company', [LokerController::class, 'post_perusahaan']);
// Route::get('loker', [LokerController::class, 'getAllDataLoker']);
// Route::get('loker/{id}', [LokerController::class, 'getAllDataLokerById']);

/**Almuni
 * - GET: id?
 * - POST: nim, nama, tgl_lahir, jurusan, angkatan, kelamin, agama, golongan darah
 * - DELETE: id
 */
// middleware group
Route::middleware(['auth:sanctum', 'isBanned'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::middleware(['isAdmin'])->group(function () {
    });
});

Route::get('alumni', [AlumniController::class, 'get']);
Route::delete('alumni/{id_alumni}', [AlumniController::class, 'delete']);
Route::post('alumni', [AlumniController::class, 'post']);
Route::post('alumni/claim-data', [AlumniController::class, 'claimDataALumniByUserId'])->middleware('auth:sanctum');

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
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::post('user/update-avatar', [UserController::class, 'updateAvatar'])->middleware('auth:sanctum');
Route::post('user/banned', [UserController::class, 'bannedUser'])->middleware(['auth:sanctum', 'isAdmin']);
Route::post('user/unbanned', [UserController::class, 'unBannedUser'])->middleware(['auth:sanctum', 'isAdmin']);
