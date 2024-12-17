<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class homeController extends Controller
{
    public function getDataPelatihanSertifikasi($id_pengguna)
    {
        try {
            $data = DB::table('input_pelatihan')
            ->leftJoin('input_sertifikasi', 'input_pelatihan.id_input_pelatihan', '=', 'input_sertifikasi.id_jenis_pelatihan_sertifikasi')
            ->select(
                'input_pelatihan.id_periode',
                DB::raw('COUNT(DISTINCT input_pelatihan.id_input_pelatihan) as total_pelatihan'),  // Menghitung total pelatihan yang diikuti
                DB::raw('COUNT(DISTINCT input_sertifikasi.id_input_sertifikasi) as total_sertifikasi')  // Menghitung total sertifikasi yang diberikan
            )
            ->where('input_pelatihan.id_pengguna', $id_pengguna)  // Filter berdasarkan pengguna
            ->groupBy('input_pelatihan.id_periode')  // Kelompokkan berdasarkan periode
            ->orderBy('input_pelatihan.id_periode', 'desc')  // Urutkan berdasarkan periode
            ->get();
        
          

            // Cek jika data ditemukan
            if ($data->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pelatihan dan sertifikasi tidak ditemukan.',
                ], 404);
            }

            // Mengembalikan response dengan data
            return response()->json([
                'success' => true,
                'message' => 'Data pelatihan dan sertifikasi ditemukan.',
                'data' => $data,
            ], 200);

        } catch (\Exception $e) {
            // Menangani error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
