<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\infoPelatihanModel;
use App\Models\infoSertifikasiModel;
use Illuminate\Http\Request;

class infoController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type'); // Ambil parameter 'type'

        // Validasi parameter 'type'
        if (!in_array($type, ['pelatihan', 'sertifikasi'])) {
            return response()->json([
                'message' => 'Parameter type harus pelatihan atau sertifikasi'
            ], 400);
        }

        // Ambil data berdasarkan type
        if ($type === 'pelatihan') {
            $data = infoPelatihanModel::all();
        } else {
            $data = infoSertifikasiModel::all();
        }

        // Cek apakah data kosong
        if ($data->isEmpty()) {
            return response()->json([
                'message' => "Data $type tidak ditemukan"
            ], 404);
        }

        return response()->json($data, 200);
    }
}
