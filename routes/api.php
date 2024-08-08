<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Auth\GoogleController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
// 	Route::apiResource('berita', BeritaController::class);
// 	Route::apiResource('kategori-berita', KategoriBeritaController::class);
// 	Route::apiResource('loker', LokerController::class);
// 	Route::apiResource('event', EventController::class);
// });

//* available param: id, offset, limit 
Route::get('berita', [BeritaController::class, 'get']);
Route::delete('berita', [BeritaController::class, 'delete']);


Route::get('kategori-berita', [KategoriBeritaController::class, 'getAllDataKategoriBerita']);
Route::get('kategori-berita/{id}', [KategoriBeritaController::class, 'getAllDataKategoriBeritaById']);

Route::get('loker',        [LokerController::class, 'getAllDataLoker']);
Route::get('loker/{id}',   [LokerController::class, 'getAllDataLokerById']);

Route::get('event',        [EventController::class, 'getAllDataEvent']);
Route::get('event/{id}',   [EventController::class, 'getAllDataEventById']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('api/auth/google/redirect', [GoogleController::class, 'redirectToGoogle']);
Route::get('api/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::post('auth/login',       [AuthController::class, 'login']);
Route::post('auth/register',    [AuthController::class, 'register']);
Route::post('auth/google',      [AuthController::class, 'handleGoogleLogin']);

Route::get('alumni',            [AlumniController::class, 'getAllDataAlumni']);
Route::get('alumni/{id}',       [AlumniController::class, 'getDataAlumniById']);
Route::post('alumni',           [AlumniController::class, 'addDataAlumni']);
Route::put('alumni/{id}',       [AlumniController::class, 'updateDataAlumniById']);
Route::delete('alumni/{id}',    [AlumniController::class, 'deleteDataAlumniById']);

