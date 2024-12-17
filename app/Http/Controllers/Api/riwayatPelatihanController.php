<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\dataPelatihanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class riwayatPelatihanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = auth()->user();
    
        // Ambil data sertifikasi berdasarkan id_pengguna yang terautentikasi
        $pelatihans = dataPelatihanModel::where('id_pengguna', $user->id_pengguna)->get();
    
        // Jika tidak ada data sertifikasi untuk pengguna ini
        if ($pelatihans->isEmpty()) {
            return response()->json([
                'message' => 'Data sertifikasi tidak ditemukan'
            ], 404);
        }
    
        // Mengembalikan data sertifikasi dalam format JSON
        return response()->json($pelatihans, 200);
    }
}
