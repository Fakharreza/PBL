<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\dataPelatihanModel;
use App\Models\DataSertifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class riwayatGabunganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = auth()->user();

        // Ambil tahun_periode dari tabel pelatihan dan sertifikasi
        $riwayatGabungan = DB::table('periode')
            ->select(
                'periode.tahun_periode',
                DB::raw('COUNT(DISTINCT input_pelatihan.id_input_pelatihan) as total_pelatihan'),
                DB::raw('COUNT(DISTINCT input_sertifikasi.id_input_sertifikasi) as total_sertifikasi')
            )
            ->leftJoin('input_pelatihan', 'periode.id_periode', '=', 'input_pelatihan.id_periode')
            ->leftJoin('input_sertifikasi', 'periode.id_periode', '=', 'input_sertifikasi.id_periode')
            ->where(function ($query) use ($user) {
                $query->where('input_pelatihan.id_pengguna', $user->id_pengguna)
                    ->orWhere('input_sertifikasi.id_pengguna', $user->id_pengguna);
            })
            ->groupBy('periode.tahun_periode')
            ->orderBy('periode.tahun_periode', 'desc')
            ->get();


        // Jika tidak ada data, kembalikan response kosong
        if ($riwayatGabungan->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada data pelatihan atau sertifikasi ditemukan'
            ], 404);
        }

        // Kembalikan response JSON
        return response()->json([
            'data' => $riwayatGabungan
        ], 200);
    }
}
