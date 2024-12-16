<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class daftarPelatihanSertifikasiController extends Controller
{
    public function index()
    {
        // Breadcrumb dan Page Title
        $breadcrumb = (object) [
            'title' => 'Daftar Pelatihan Sertifikasi',
            'list' => ['Home', 'Daftar Pelatihan Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Daftar Pelatihan Sertifikasi yang ada dalam sistem'
        ];

        $activeMenu = 'daftarPelatihanSertifikasi';


        // Ambil data pelatihan beserta bidang minat dan mata kuliah
        $pelatihans = DB::table('info_pelatihan')
            ->select(
                'info_pelatihan.id_info_pelatihan',
                'info_pelatihan.nama_pelatihan',
                'info_pelatihan.tanggal_mulai',
                'info_pelatihan.tanggal_selesai'
            )
            ->get()
            ->map(function ($pelatihan) {
                $pelatihan->bidang_minat = DB::table('bidang_minat_pelatihan')
                    ->join('bidang_minat', 'bidang_minat_pelatihan.id_bidang_minat', '=', 'bidang_minat.id_bidang_minat')
                    ->where('bidang_minat_pelatihan.id_info_pelatihan', $pelatihan->id_info_pelatihan)
                    ->pluck('nama_bidang_minat');

                $pelatihan->mata_kuliah = DB::table('mata_kuliah_pelatihan')
                    ->join('mata_kuliah', 'mata_kuliah_pelatihan.id_mata_kuliah', '=', 'mata_kuliah.id_mata_kuliah')
                    ->where('mata_kuliah_pelatihan.id_info_pelatihan', $pelatihan->id_info_pelatihan)
                    ->pluck('nama_mata_kuliah');

                return $pelatihan;
            });

        // Ambil data sertifikasi beserta bidang minat dan mata kuliah
        $sertifikasis = DB::table('info_sertifikasi')
            ->select(
                'info_sertifikasi.id_info_sertifikasi',
                'info_sertifikasi.nama_sertifikasi',
                'info_sertifikasi.tanggal_mulai'
            )
            ->get()
            ->map(function ($sertifikasi) {
                $sertifikasi->bidang_minat = DB::table('bidang_minat_sertifikasi')
                    ->join('bidang_minat', 'bidang_minat_sertifikasi.id_bidang_minat', '=', 'bidang_minat.id_bidang_minat')
                    ->where('bidang_minat_sertifikasi.id_info_sertifikasi', $sertifikasi->id_info_sertifikasi)
                    ->pluck('nama_bidang_minat');

                $sertifikasi->mata_kuliah = DB::table('mata_kuliah_sertifikasi')
                    ->join('mata_kuliah', 'mata_kuliah_sertifikasi.id_mata_kuliah', '=', 'mata_kuliah.id_mata_kuliah')
                    ->where('mata_kuliah_sertifikasi.id_info_sertifikasi', $sertifikasi->id_info_sertifikasi)
                    ->pluck('nama_mata_kuliah');

                return $sertifikasi;
            });

        // Passing data ke Blade
        return view('daftarPelatihanSertifikasi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'pelatihans' => $pelatihans,
            'sertifikasis' => $sertifikasis
        ]);
    }

    public function detailPelatihan($id)
    {
        // Menambahkan breadcrumb pada halaman detail
        $breadcrumb = (object) [
            'title' => 'Detail Pelatihan',
            'list' => ['Home', 'Daftar Pelatihan Sertifikasi', 'Detail Pelatihan']
        ];
    
        // Ambil data pelatihan sesuai ID
        $pelatihan = DB::table('info_pelatihan')
            ->select(
                'nama_pelatihan',
                'lokasi_pelatihan',
                'level_pelatihan',
                'tanggal_mulai',
                'tanggal_selesai',
                'kuota_peserta',
                'biaya'
            )
            ->where('id_info_pelatihan', $id)
            ->first();
    
        if (!$pelatihan) {
            abort(404, 'Pelatihan tidak ditemukan');
        }
    
        // Ambil bidang minat dan mata kuliah terkait pelatihan
        $pelatihan->bidang_minat = DB::table('bidang_minat_pelatihan')
            ->join('bidang_minat', 'bidang_minat_pelatihan.id_bidang_minat', '=', 'bidang_minat.id_bidang_minat')
            ->where('bidang_minat_pelatihan.id_info_pelatihan', $id)
            ->pluck('nama_bidang_minat');
    
        $pelatihan->mata_kuliah = DB::table('mata_kuliah_pelatihan')
            ->join('mata_kuliah', 'mata_kuliah_pelatihan.id_mata_kuliah', '=', 'mata_kuliah.id_mata_kuliah')
            ->where('mata_kuliah_pelatihan.id_info_pelatihan', $id)
            ->pluck('nama_mata_kuliah');
    
        // Passing data ke Blade
        return view('daftarPelatihanSertifikasi.detailPelatihan', compact('pelatihan', 'breadcrumb'));
    }
    
    public function detailSertifikasi($id)
    {
        // Menambahkan breadcrumb pada halaman detail sertifikasi
        $breadcrumb = (object) [
            'title' => 'Detail Sertifikasi',
            'list' => ['Home', 'Daftar Pelatihan Sertifikasi', 'Detail Sertifikasi']
        ];
    
        // Ambil data sertifikasi sesuai ID
        $sertifikasi = DB::table('info_sertifikasi')
            ->select(
                'nama_sertifikasi',
                'level_sertifikasi',
                'tanggal_mulai',
                'tanggal_selesai',
                'kuota_peserta',
                'masa_berlaku'
            )
            ->where('id_info_sertifikasi', $id)
            ->first();
    
        if (!$sertifikasi) {
            abort(404, 'Sertifikasi tidak ditemukan');
        }
    
        // Ambil bidang minat dan mata kuliah terkait sertifikasi
        $sertifikasi->bidang_minat = DB::table('bidang_minat_sertifikasi')
            ->join('bidang_minat', 'bidang_minat_sertifikasi.id_bidang_minat', '=', 'bidang_minat.id_bidang_minat')
            ->where('bidang_minat_sertifikasi.id_info_sertifikasi', $id)
            ->pluck('nama_bidang_minat');
    
        $sertifikasi->mata_kuliah = DB::table('mata_kuliah_sertifikasi')
            ->join('mata_kuliah', 'mata_kuliah_sertifikasi.id_mata_kuliah', '=', 'mata_kuliah.id_mata_kuliah')
            ->where('mata_kuliah_sertifikasi.id_info_sertifikasi', $id)
            ->pluck('nama_mata_kuliah');
    
        // Passing data ke Blade
        return view('daftarPelatihanSertifikasi.detailSertifikasi', compact('sertifikasi', 'breadcrumb'));
    }
    
}
