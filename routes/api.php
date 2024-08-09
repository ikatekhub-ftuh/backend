<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Auth\GoogleController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
 *   - judul: Title of the berita.
 *   - konten: Content of the berita.
 *   - id_kategori_berita: Category ID of the berita.
 *   - penulis: Author of the berita.
 *   - file: Image file.
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
 *   - id?: If present, will return one item.
 *
 * To be Added:
 * - POST /berita/kategori
 * - DELETE /berita/kategori
 * - PUT /berita/kategori
 */
//  test middleware: 
// app/Http/Middleware/logcatmiddleware.php
// registered in bootstrap/app.php
// logged in storage/logs/laravel.log
Route::middleware(['logcat:thisisparam,param2'])->group(function () {
    Route::get('berita/kategori', [BeritaController::class, 'category_get']);
});

/**Event
 * - GET: id?, limit?, offset?
 * - POST: judul, konten, perusahaan, file:gambar
 * - DELETE: id
*/
Route::get('event', [EventController::class, 'get']);
Route::delete('event', [EventController::class, 'delete']);
Route::post('event', [EventController::class, 'post']);
Route::get('loker', [LokerController::class, 'getAllDataLoker']);
Route::get('loker/{id}', [LokerController::class, 'getAllDataLokerById']);

/**Almuni
 * - GET: id?
 * - POST: nim, nama, tgl_lahir, jurusan, angkatan, kelamin, agama, golongan darah
 * - DELETE: id
*/
Route::get('alumni', [AlumniController::class, 'get']);
Route::delete('alumni', [AlumniController::class, 'delete']);
Route::post('alumni', [AlumniController::class, 'post']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::get('api/auth/google/redirect', [GoogleController::class, 'redirectToGoogle']);
// Route::get('api/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/google', [AuthController::class, 'handleGoogleLogin']);

