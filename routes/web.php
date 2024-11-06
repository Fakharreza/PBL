<?php

use App\Http\Controllers\jenisPenggunaController;
use App\Http\Controllers\penggunaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;



use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::pattern('id', '[0-9]+'); // Parameter {id} harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);
Route::get('/', [WelcomeController::class, 'index']);


// Group route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {

    Route::get('/home', [WelcomeController::class, 'index']);

    Route::group(['prefix' => 'pengguna', 'middleware' => 'authorize:SADM'], function () {
        Route::get('/', [penggunaController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [penggunaController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [penggunaController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [penggunaController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [penggunaController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [penggunaController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [penggunaController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [penggunaController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [penggunaController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [penggunaController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [penggunaController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [penggunaController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [penggunaController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [penggunaController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf',[penggunaController::class,'export_pdf']); // export pdf
    });
    Route::group(['prefix' => 'jenisPengguna', 'middleware' => 'authorize:SADM'], function () {
        Route::get('/', [jenisPenggunaController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [jenisPenggunaController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [jenisPenggunaController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [jenisPenggunaController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [jenisPenggunaController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [jenisPenggunaController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [jenisPenggunaController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [jenisPenggunaController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [jenisPenggunaController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [jenisPenggunaController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [jenisPenggunaController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [jenisPenggunaController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [jenisPenggunaController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [jenisPenggunaController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf',[jenisPenggunaController::class,'export_pdf']); // export pdf
    });

    Route::group(['prefix' => 'profile', 'middleware' => ['authorize:SADM']], function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::get('/{id}/edit', [ProfileController::class, 'edit']);
        Route::put('/{id}', [ProfileController::class, 'update']);
    });
    
});