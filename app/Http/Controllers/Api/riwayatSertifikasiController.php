<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataSertifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class riwayatSertifikasiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = auth()->user();
    
        // Ambil data sertifikasi berdasarkan id_pengguna yang terautentikasi
        $sertifikasis = DataSertifikasiModel::where('id_pengguna', $user->id_pengguna)->get();
    
        // Jika tidak ada data sertifikasi untuk pengguna ini
        if ($sertifikasis->isEmpty()) {
            return response()->json([
                'message' => 'Data sertifikasi tidak ditemukan'
            ], 404);
        }
    
        // Mengembalikan data sertifikasi dalam format JSON
        return response()->json($sertifikasis, 200);
    }
}
