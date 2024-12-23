<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\suratTugasModel;

class SuratTugasController extends Controller
{
    public function index()
    {
        // Ambil semua data surat tugas
        $listSurat = suratTugasModel::all();

        // Jika tidak ada data surat tugas
        if ($listSurat->isEmpty()) {
            return response()->json([
                'message' => 'Data surat tugas tidak ditemukan'
            ], 404);
        }

        // Mengembalikan data surat tugas dalam format JSON
        return response()->json($listSurat, 200);
    }

    // public function downloadSuratTugas($id, Request $request)
    // {
    //     try {
    //         $type = strtolower($request->query('tipe'));

    //         // Logging request
    //         Log::debug('Request download surat tugas', [
    //             'id' => $id,
    //             'type' => $type,
    //             'request_all' => $request->all()
    //         ]);

    //         $user = Auth::user();

    //         // Validasi tipe
    //         if (!in_array($type, ['pelatihan', 'sertifikasi'])) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Tipe harus pelatihan atau sertifikasi'
    //             ], 400);
    //         }

    //         // Query surat tugas dengan validasi otorisasi
    //         $suratTugasQuery = suratTugasModel::query();

    //         if ($type === 'pelatihan') {
    //             $suratTugasQuery->where('id_peserta_pelatihan', $id)
    //                 ->whereHas('pesertaPelatihan', function ($query) use ($user) {
    //                     $query->where('id_pengguna', $user->id_pengguna);
    //                 });
    //         } elseif ($type === 'sertifikasi') {
    //             $suratTugasQuery->where('id_peserta_sertifikasi', $id)
    //                 ->whereHas('pesertaSertifikasi', function ($query) use ($user) {
    //                     $query->where('id_pengguna', $user->id_pengguna);
    //                 });
    //         }

    //         $suratTugas = $suratTugasQuery->first();

    //         // Logging hasil query
    //         Log::debug('Hasil query surat tugas', [
    //             'query' => $suratTugasQuery->toSql(),
    //             'bindings' => $suratTugasQuery->getBindings(),
    //             'result' => $suratTugas
    //         ]);

    //         // Jika surat tugas tidak ditemukan
    //         if (!$suratTugas) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Surat tugas tidak ditemukan'
    //             ], 404);
    //         }

    //         // Ambil nama file dan path file
    //         $fileName = basename($suratTugas->file_surat_tugas);
    //         $filePath = storage_path('app/public/' . $suratTugas->file_surat_tugas);

    //         // Logging lokasi file
    //         Log::info('File download attempt', [
    //             'file_name' => $fileName,
    //             'file_path' => $filePath
    //         ]);

    //         // Cek apakah file ada di server
    //         if (!file_exists($filePath)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'File surat tugas tidak ditemukan'
    //             ], 404);
    //         }

    //         // Download file
    //         return response()->download($filePath, $fileName);
    //     } catch (\Exception $e) {
    //         Log::error('Error saat mendownload surat tugas', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function getSuratTugasByUser()
    // {
    //     $user = Auth::user();

    //     $suratTugas = suratTugasModel::where(function ($query) use ($user) {
    //         $query->whereHas('pesertaPelatihan', function ($q) use ($user) {
    //             $q->where('id_pengguna', $user->id_pengguna);
    //         })->orWhereHas('pesertaSertifikasi', function ($q) use ($user) {
    //             $q->where('id_pengguna', $user->id_pengguna);
    //         });
    //     })->get();

    //     return response()->json($suratTugas, 200);
    // }

    public function getSuratTugasByUser()
{
    $user = Auth::user();
    
    $suratTugas = suratTugasModel::where(function($query) use ($user) {
        $query->whereHas('pesertaPelatihan', function ($q) use ($user) {
            $q->where('id_pengguna', $user->id_pengguna);
        })->orWhereHas('pesertaSertifikasi', function ($q) use ($user) {
            $q->where('id_pengguna', $user->id_pengguna);
        });
    })
    ->select([
        'id_surat_tugas',
        'id_peserta_pelatihan',
        'id_peserta_sertifikasi',
        'nama_surat_tugas',
        'file_surat_tugas'
    ])
    ->with(['pesertaPelatihan', 'pesertaSertifikasi'])
    ->get();

    return response()->json($suratTugas, 200);
}

public function downloadSuratTugas($id, Request $request)
{
    try {
        $type = strtolower($request->query('tipe'));
        $user = Auth::user();

        if (!in_array($type, ['pelatihan', 'sertifikasi'])) {
            return response()->json([
                'status' => false,
                'message' => 'Tipe harus pelatihan atau sertifikasi'
            ], 400);
        }

        $suratTugasQuery = suratTugasModel::where('id_surat_tugas', $id);

        if ($type === 'pelatihan') {
            $suratTugasQuery->whereHas('pesertaPelatihan', function ($query) use ($user) {
                $query->where('id_pengguna', $user->id_pengguna);
            });
        } elseif ($type === 'sertifikasi') {
            $suratTugasQuery->whereHas('pesertaSertifikasi', function ($query) use ($user) {
                $query->where('id_pengguna', $user->id_pengguna);
            });
        }

        $suratTugas = $suratTugasQuery->first();

        if (!$suratTugas) {
            return response()->json([
                'status' => false,
                'message' => 'Surat tugas tidak ditemukan'
            ], 404);
        }

        $filePath = storage_path('app/public/' . $suratTugas->file_surat_tugas);
        $fileName = basename($suratTugas->file_surat_tugas);

        if (!file_exists($filePath)) {
            return response()->json([
                'status' => false,
                'message' => 'File surat tugas tidak ditemukan'
            ], 404);
        }

        return response()->download($filePath, $fileName);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
}
