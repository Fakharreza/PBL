<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\homeController;
use App\Http\Controllers\Api\infoController;
use App\Http\Controllers\Api\infoPelatihanController;
use App\Http\Controllers\Api\infoSertifikasiController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\profileController;
use App\Http\Controllers\Api\riwayatGabunganController;
use App\Http\Controllers\Api\riwayatPelatihanController;
use App\Http\Controllers\Api\riwayatSertifikasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [LoginController::class, '__invoke'])->name('login');

Route::middleware('auth:api')->group(function() {
    // Menampilkan semua sertifikasi pengguna yang terautentikasi
    Route::get('sertifikasi', [riwayatSertifikasiController::class, 'index']);
    Route::get('pelatihan', [riwayatPelatihanController::class, 'index']);
    Route::get('/riwayat/gabungan', [riwayatGabunganController::class, 'index']);
    Route::get('profile', [profileController::class, 'index']);
});


Route::get('infoSertif', [infoSertifikasiController::class, 'index']);
Route::get('infoPelatihan', [infoPelatihanController::class, 'index']);

Route::get('info', [infoController::class, 'index']);
