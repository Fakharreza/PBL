<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\penggunaModel;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_pengguna' => 'required|string',
            'password' => 'required',
        ]);

        // Cari pengguna berdasarkan nama_pengguna
        $user = penggunaModel::where('nama_pengguna', $request->nama_pengguna)->first();

        // Periksa apakah pengguna ada dan password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Berikan respon berhasil login dengan informasi pengguna
        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id_pengguna' => $user->id_pengguna,
                'nama_pengguna' => $user->nama_pengguna,
                'nama' => $user->nama,
                'email' => $user->email,
                'nip' => $user->nip,
                'role' => $user->getRoleName(),
            ],
        ], 200);
    }
}
