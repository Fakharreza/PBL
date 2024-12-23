<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\infoSertifikasiModel;
use Illuminate\Http\Request;

class infoSertifikasiController extends Controller
{
    public function index(Request $request)
    {
    
        // Ambil data sertifikasi berdasarkan id_pengguna yang terautentikasi
        $infoSertif = infoSertifikasiModel::all();
    
        // Jika tidak ada data sertifikasi untuk pengguna ini
        if ($infoSertif->isEmpty()) {
            return response()->json([
                'message' => 'Data sertifikasi tidak ditemukan'
            ], 404);
        }
    
        // Mengembalikan data sertifikasi dalam format JSON
        return response()->json($infoSertif, 200);
    }
}
