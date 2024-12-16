<?php

use App\Http\Controllers\jenisPenggunaController;
use App\Http\Controllers\JenisPelatihanController;
use App\Http\Controllers\penggunaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidangMinatController;
use App\Http\Controllers\daftarPelatihanSertifikasiController;
use App\Http\Controllers\suratTugasController;
use App\Http\Controllers\VendorPelatihanController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dataPelatihanController;
use App\Http\Controllers\DataSertifikasiController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\vendorSertifController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\infoPelatihanController;
use App\Http\Controllers\infoSertifikasiController;
use App\Http\Controllers\statistikSertifikasiController;
use App\Http\Controllers\accPesertaController;
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

Route::get('/', [AuthController::class, 'login']);
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);


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
        Route::get('/export_pdf', [penggunaController::class, 'export_pdf']); // export pdf
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
        Route::get('/export_pdf', [jenisPenggunaController::class, 'export_pdf']); // export pdf
    });

    Route::group(['prefix' => 'profile', 'middleware' => ['authorize:SADM,ADM,DSN,PMN']], function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::get('/{id}/edit', [ProfileController::class, 'edit']);
        Route::put('/{id}', [ProfileController::class, 'update']);
    });

    Route::group(['prefix' => 'jenisPelatihan', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [JenisPelatihanController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [JenisPelatihanController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [JenisPelatihanController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [JenisPelatihanController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [JenisPelatihanController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [JenisPelatihanController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [JenisPelatihanController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [JenisPelatihanController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [JenisPelatihanController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [JenisPelatihanController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [JenisPelatihanController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [JenisPelatihanController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [JenisPelatihanController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [JenisPelatihanController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [JenisPelatihanController::class, 'export_pdf']); // export pdf
    });

    Route::group(['prefix' => 'dataPelatihan', 'middleware' => ['authorize:DSN']], function () {
        Route::get('/', [dataPelatihanController::class, 'index']); // Menampilkan halaman awal data pelatihan dan sertifikasi
        Route::post('/list', [dataPelatihanController::class, 'list']); // Menampilkan data dalam bentuk JSON untuk DataTables
        Route::get('/create', [dataPelatihanController::class, 'create']); // Menampilkan form tambah data
        Route::post('/', [dataPelatihanController::class, 'store']); // Menyimpan data baru
        Route::get('/create_ajax', [dataPelatihanController::class, 'create_ajax']); // Menampilkan form tambah data via AJAX
        Route::post('/ajax', [dataPelatihanController::class, 'store_ajax']); // Menyimpan data baru via AJAX
        Route::get('/{id}/edit_ajax', [dataPelatihanController::class, 'edit_ajax']); // Menampilkan form edit data via AJAX
        Route::put('/{id}/update_ajax', [dataPelatihanController::class, 'update_ajax']); // Menyimpan perubahan data via AJAX
        Route::get('/{id}/delete_ajax', [dataPelatihanController::class, 'confirm_ajax']); // Menampilkan konfirmasi hapus data via AJAX
        Route::delete('/{id}/delete_ajax', [dataPelatihanController::class, 'delete_ajax']); // Menghapus data via AJAX
        Route::get('/{id}/show_ajax', [dataPelatihanController::class, 'show_ajax']); // Menampilkan detail data via AJAX
        Route::get('/import', [dataPelatihanController::class, 'import']); // Menampilkan form upload file untuk import
        Route::post('/import_ajax', [dataPelatihanController::class, 'import_ajax']); // Mengimpor data dari file Excel via AJAX
        Route::get('/export_excel', [dataPelatihanController::class, 'export_excel']); // Mengekspor data ke Excel
        Route::get('/export_pdf', [dataPelatihanController::class, 'export_pdf']); // Mengekspor data ke PDF
    });

    Route::group(['prefix' => 'vendorPelatihan', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [VendorPelatihanController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [VendorPelatihanController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [VendorPelatihanController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [VendorPelatihanController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [VendorPelatihanController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [VendorPelatihanController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [VendorPelatihanController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [VendorPelatihanController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [VendorPelatihanController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [VendorPelatihanController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [VendorPelatihanController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [VendorPelatihanController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [VendorPelatihanController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [VendorPelatihanController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [VendorPelatihanController::class, 'export_pdf']); // export pdf
    });

    Route::group(['prefix' => 'vendorSertif', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [vendorSertifController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [vendorSertifController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [vendorSertifController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [vendorSertifController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [vendorSertifController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [vendorSertifController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [vendorSertifController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [vendorSertifController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [vendorSertifController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [vendorSertifController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [vendorSertifController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [vendorSertifController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [vendorSertifController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [vendorSertifController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [vendorSertifController::class, 'export_pdf']); // export pdf
    });

    Route::group(['prefix' => 'mataKuliah', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [MataKuliahController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [MataKuliahController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [MataKuliahController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [MataKuliahController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [MataKuliahController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [MataKuliahController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [MataKuliahController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [MataKuliahController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [MataKuliahController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [MataKuliahController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [MataKuliahController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [MataKuliahController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [MataKuliahController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [MataKuliahController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [MataKuliahController::class, 'export_pdf']); // export pdf
    });
    Route::group(['prefix' => 'bidangMinat', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [BidangMinatController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [BidangMinatController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [BidangMinatController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [BidangMinatController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [BidangMinatController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [BidangMinatController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [BidangMinatController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [BidangMinatController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [BidangMinatController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [BidangMinatController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [BidangMinatController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [BidangMinatController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [BidangMinatController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [BidangMinatController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [BidangMinatController::class, 'export_pdf']); // export pdf
    });

    Route::group(['prefix' => 'periode', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [PeriodeController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [PeriodeController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [PeriodeController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [PeriodeController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [PeriodeController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [PeriodeController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [PeriodeController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [PeriodeController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [PeriodeController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [PeriodeController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [PeriodeController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [PeriodeController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [PeriodeController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [PeriodeController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [PeriodeController::class, 'export_pdf']); // export pdf
    });
    Route::group(['prefix' => 'infoPelatihan', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [infoPelatihanController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [infoPelatihanController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [infoPelatihanController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [infoPelatihanController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [infoPelatihanController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::get('/{id}/tambah_peserta', [infoPelatihanController::class, 'tambah_peserta']);
        Route::post('/{id}/store_peserta', [infoPelatihanController::class, 'store_peserta']);
        Route::delete('/{id}/hapus_peserta', [infoPelatihanController::class, 'hapus_peserta']);
        Route::post('/ajax', [infoPelatihanController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [infoPelatihanController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [infoPelatihanController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [infoPelatihanController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [infoPelatihanController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [infoPelatihanController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [infoPelatihanController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [infoPelatihanController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [infoPelatihanController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [infoPelatihanController::class, 'export_pdf']); // export pdf
    });

    Route::group(['prefix' => 'infoSertifikasi', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [infoSertifikasiController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [infoSertifikasiController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [infoSertifikasiController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [infoSertifikasiController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [infoSertifikasiController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::get('/{id}/tambah_peserta', [infoSertifikasiController::class, 'tambah_peserta']);
        Route::post('/{id}/store_peserta', [infoSertifikasiController::class, 'store_peserta']);
        Route::delete('/{id}/hapus_peserta', [infoSertifikasiController::class, 'hapus_peserta']);
        Route::post('/ajax', [infoSertifikasiController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [infoSertifikasiController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [infoSertifikasiController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [infoSertifikasiController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [infoSertifikasiController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [infoSertifikasiController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [infoSertifikasiController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [infoSertifikasiController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [infoSertifikasiController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [infoSertifikasiController::class, 'export_pdf']); // export pdf
    });

    Route::group(['prefix' => 'dataSertifikasi', 'middleware' => ['authorize:DSN']], function () {
        Route::get('/', [DataSertifikasiController::class, 'index']);  // Menampilkan halaman awal Stok
        Route::post('/list', [DataSertifikasiController::class, 'list']);  // Menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [DataSertifikasiController::class, 'create']);  // Menampilkan form tambah Stok
        Route::post('/', [DataSertifikasiController::class, 'store']);  // Menyimpan data Stok
        Route::get('/create_ajax', [DataSertifikasiController::class, 'create_ajax']);  // Menampilkan form tambah supplier ajax
        Route::post('/ajax', [DataSertifikasiController::class, 'store_ajax']);  // Menyimpan data supplier baru ajax
        Route::get('/{id}/edit_ajax', [DataSertifikasiController::class, 'edit_ajax']);  // Menampilkan form edit supplier ajax
        Route::put('/{id}/update_ajax', [DataSertifikasiController::class, 'update_ajax']);  // Menyimpan perubahan data barang ajax
        Route::get('/{id}/delete_ajax', [DataSertifikasiController::class, 'confirm_ajax']);  // Menampilkan form konfirmasi delete supplier ajax
        Route::delete('/{id}/delete_ajax', [DataSertifikasiController::class, 'delete_ajax']);  // Menghapus data supplier ajax
        Route::get('/{id}/show_ajax', [DataSertifikasiController::class, 'show_ajax']);  // Menampilkan detail supplier
        Route::get('/import', [DataSertifikasiController::class, 'import']);  // Ajax form upload excel
        Route::post('/import_ajax', [DataSertifikasiController::class, 'import_ajax']);  // Ajax import excel
        Route::get('/export_excel', [DataSertifikasiController::class, 'export_excel']);      // export excel
        Route::get('/export_pdf', [DataSertifikasiController::class, 'export_pdf']); // export pdf
    });
    Route::group(['prefix' => 'daftarPelatihanSertifikasi', 'middleware' => ['authorize:ADM,DSN,PMN']], function () {
        Route::get('/', [daftarPelatihanSertifikasiController::class, 'index']); // Halaman awal
        Route::get('/list', [daftarPelatihanSertifikasiController::class, 'list']); // List pelatihan dan sertifikasi

        // Route detail pelatihan
        Route::get('/pelatihan/{id}/detail', [daftarPelatihanSertifikasiController::class, 'detailPelatihan'])->name('pelatihan.detail');

        // Route detail sertifikasi
        Route::get('/sertifikasi/{id}/detail', [daftarPelatihanSertifikasiController::class, 'detailSertifikasi'])->name('sertifikasi.detail');
    });

    Route::group(['prefix' => 'accPeserta', 'middleware' => ['authorize:PMN']], function () {
        Route::get('/', [accPesertaController::class, 'index']);
        Route::post('/list', [accPesertaController::class, 'list']);
        Route::get('/{id}/tampil_peserta', [accPesertaController::class, 'tampilPeserta']);
        Route::get('/{id}/ubah_peserta', [accPesertaController::class, 'ubahPeserta']);
        Route::post('/pelatihan/{id}/store_peserta', [accPesertaController::class, 'store_peserta_pelatihan']);
        Route::post('/sertifikasi/{id}/store_peserta', [accPesertaController::class, 'store_peserta_sertifikasi']);
        Route::post('/{id}/ubah_status', [accPesertaController::class, 'ubahStatus']);
    });

    Route::group(['prefix' => 'suratTugas', 'middleware' => ['authorize:ADM,DSN,PMN']], function() {
        Route::get('/', [suratTugasController::class, 'index'])->name('suratTugas.index');
        Route::post('/list', [suratTugasController::class, 'list']);
        Route::get('/{jenis}/{id}/export_pdf', [suratTugasController::class, 'export_pdf']);
        Route::get('/{jenis}/{id}/upload_form', [suratTugasController::class, 'upload_form']);
        Route::post('/{jenis}/{id}/upload_surat', [suratTugasController::class, 'upload_surat'])->name('suratTugas.upload');
    });
});
