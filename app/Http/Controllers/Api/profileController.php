<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\penggunaModel;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 401);
        }

        // Ambil data profil berdasarkan id_pengguna
        $profile = penggunaModel::where('id_pengguna', $user->id_pengguna)->first();

        // Jika tidak ada data profil untuk pengguna ini
        if (!$profile) {
            return response()->json(['message' => 'Data profile tidak ditemukan'], 404);
        }

        // Mengembalikan data profil dalam format JSON
        return response()->json([
            'nama_pengguna' => $profile->nama_pengguna,
            'nama' => $profile->nama,
            'email' => $profile->email,
            'nip' => $profile->nip,
        ], 200);
    }
}
