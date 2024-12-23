<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\infoPelatihanModel;
use Illuminate\Http\Request;

class infoPelatihanController extends Controller
{
    public function index(Request $request)
    {
    
        // Ambil data sertifikasi berdasarkan id_pengguna yang terautentikasi
        $infoPelatihan = infoPelatihanModel::all();
    
        // Jika tidak ada data sertifikasi untuk pengguna ini
        if ($infoPelatihan->isEmpty()) {
            return response()->json([
                'message' => 'Data sertifikasi tidak ditemukan'
            ], 404);
        }
    
        // Mengembalikan data sertifikasi dalam format JSON
        return response()->json($infoPelatihan, 200);
    }
}
