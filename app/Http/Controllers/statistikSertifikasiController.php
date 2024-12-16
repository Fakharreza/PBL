<?php

namespace App\Http\Controllers;

use App\Models\dataPelatihanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class statistikSertifikasiController extends Controller
{
    public function index()
    {
        // Query untuk mendapatkan jumlah sertifikasi per tahun
        $sertifikasiPerTahun = DB::table('input_sertifikasi')
            ->join('periode', 'input_sertifikasi.id_periode', '=', 'periode.id_periode')
            ->select(DB::raw('periode.tahun_periode as tahun'), DB::raw('count(*) as jumlah'))
            ->groupBy('periode.tahun_periode')
            ->orderBy('tahun', 'asc')
            ->get();

        // Prepare data for sertifikasi chart
        $sertifikasiTahunData = $sertifikasiPerTahun->pluck('tahun')->unique()->sort()->values();
        $sertifikasiJumlahData = $sertifikasiTahunData->map(function ($tahun) use ($sertifikasiPerTahun) {
            return $sertifikasiPerTahun->where('tahun', $tahun)->sum('jumlah');
        });

        // Query untuk mendapatkan list pengguna, sertifikasi, dan periodenya
        $listDosen = DB::table('input_sertifikasi')
            ->join('pengguna', 'input_sertifikasi.id_pengguna', '=', 'pengguna.id_pengguna')
            ->join('periode', 'input_sertifikasi.id_periode', '=', 'periode.id_periode')
            ->select(
                'input_sertifikasi.id_input_sertifikasi',
                'pengguna.nama as nama_pengguna',
                'input_sertifikasi.nama_sertifikasi',
                'periode.tahun_periode'
            )
            ->orderBy('periode.tahun_periode', 'asc')
            ->get();

        // Query untuk mendapatkan list pelatihan
        $listPelatihan = DB::table('input_pelatihan')
            ->join('pengguna', 'input_pelatihan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->join('periode', 'input_pelatihan.id_periode', '=', 'periode.id_periode')
            ->join('jenis_pelatihan_sertifikasi', 'input_pelatihan.id_jenis_pelatihan_sertifikasi', '=', 'jenis_pelatihan_sertifikasi.id_jenis_pelatihan_sertifikasi')
            ->select(
                'input_pelatihan.id_input_pelatihan',
                'pengguna.nama as nama_pengguna',
                'input_pelatihan.nama_pelatihan',
                'input_pelatihan.lokasi_pelatihan',
                'input_pelatihan.waktu_pelatihan',
                'periode.tahun_periode'
            )
            ->orderBy('periode.tahun_periode', 'asc')
            ->get();

        // Prepare data for pelatihan chart
        $pelatihanTahunData = $listPelatihan->pluck('tahun_periode')->unique()->sort()->values();
        $pelatihanJumlahData = $pelatihanTahunData->map(function ($tahun) use ($listPelatihan) {
            return $listPelatihan->where('tahun_periode', $tahun)->count();
        });

        $breadcrumb = (object) [
            'title' => 'Statistik',
            'list' => ['Home', 'Statistik Sertifikasi']
        ];

        $activeMenu = 'dashboard';

        // Mengirim data ke view
        return view('statistikSertifikasi.index', compact(
            'sertifikasiTahunData',
            'sertifikasiJumlahData',
            'breadcrumb',
            'activeMenu',
            'listDosen',
            'listPelatihan',
            'pelatihanTahunData',
            'pelatihanJumlahData'
        ));
    }

    public function showAjax($id)
    {
        // Ambil detail sertifikasi berdasarkan ID
        $detail = DB::table('input_sertifikasi')
            ->join('pengguna', 'input_sertifikasi.id_pengguna', '=', 'pengguna.id_pengguna')
            ->select(
                'input_sertifikasi.id_input_sertifikasi',
                'pengguna.nama as nama_pengguna',
                'input_sertifikasi.nama_sertifikasi',
                'input_sertifikasi.lokasi_sertifikasi',
                'input_sertifikasi.waktu_sertifikasi',
                'input_sertifikasi.no_sertifikat',
                'input_sertifikasi.masa_berlaku'
            )
            ->where('input_sertifikasi.id_input_sertifikasi', $id)
            ->first();

        return view('statistikSertifikasi.show_ajax', ['detail' => $detail]);
    }

    public function getDetailPelatihan($id)
    {
        // Mengambil data pelatihan berdasarkan ID menggunakan query builder
        $detail = DB::table('input_pelatihan')
            ->join('pengguna', 'input_pelatihan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->join('periode', 'input_pelatihan.id_periode', '=', 'periode.id_periode')
            ->join('jenis_pelatihan_sertifikasi', 'input_pelatihan.id_jenis_pelatihan_sertifikasi', '=', 'jenis_pelatihan_sertifikasi.id_jenis_pelatihan_sertifikasi')
            ->select(
                'input_pelatihan.id_input_pelatihan',
                'pengguna.nama as nama_pengguna',
                'input_pelatihan.nama_pelatihan',
                'input_pelatihan.lokasi_pelatihan',
                'input_pelatihan.waktu_pelatihan',
                'input_pelatihan.bukti_pelatihan',
                'periode.tahun_periode',
                'input_pelatihan.created_at',
                'input_pelatihan.updated_at'
            )
            ->where('input_pelatihan.id_input_pelatihan', $id)
            ->first();

        // Jika data pelatihan tidak ditemukan, tampilkan error
        if (!$detail) {
            return response()->json(['error' => 'Pelatihan tidak ditemukan.'], 404);
        }

        // Jika ditemukan, tampilkan detail pelatihan
        return view('statistikSertifikasi.detailPelatihan', ['detail' => $detail]);
    }
}

