<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notifikasiModel;

class notifikasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil notifikasi berdasarkan peserta yang terkait dengan pengguna
        $notifikasi = notifikasiModel::where(function ($query) use ($user) {
            // Filter untuk peserta pelatihan
            $query->whereHas('pesertaPelatihan', function ($q) use ($user) {
                $q->where('id_pengguna', $user->id_pengguna);
            })
                // Filter untuk peserta sertifikasi
                ->orWhereHas('pesertaSertifikasi', function ($q) use ($user) {
                    $q->where('id_pengguna', $user->id_pengguna);
                });
        })
            // Tambahkan kondisi untuk mengecualikan admin dan pimpinan
            ->where(function ($query) {
                $query->where('role', '!=', 'admin') // Pastikan untuk menyesuaikan dengan kolom yang ada
                    ->where('role', '!=', 'pimpinan'); // Pastikan untuk menyesuaikan dengan kolom yang ada
            })
            ->latest()
            ->get();

        // Hitung jumlah notifikasi yang belum dibaca hanya untuk peserta pelatihan atau sertifikasi yang relevan
        $unreadNotifications = $notifikasi->where('is_read', 0)->count();

        return view('notifikasi.index', compact('notifikasi', 'unreadNotifications'));
    }

    public function show($id)
    {
        $user = auth()->user();

        // Cari notifikasi yang terkait dengan peserta milik pengguna yang login
        $notifikasi = notifikasiModel::where(function ($query) use ($user, $id) {
            $query->whereHas('pesertaPelatihan', function ($q) use ($user) {
                $q->where('id_peserta_pelatihan', $user->id_pengguna);
            })->orWhereHas('pesertaSertifikasi', function ($q) use ($user) {
                $q->where('id_peserta_sertifikasi', $user->id_pengguna);
            });
        })
            ->findOrFail($id);

        // Tandai notifikasi sebagai dibaca
        $notifikasi->update(['is_read' => 1]);

        return view('notifikasi.show', compact('notifikasi'));
    }

    public function markAllAsRead()
    {
        $user = auth()->user();

        // Tandai semua notifikasi yang terkait dengan peserta milik pengguna sebagai dibaca
        notifikasiModel::whereHas('pesertaPelatihan', function ($query) use ($user) {
            $query->where('id_pengguna', $user->id_pengguna);
        })
            ->orWhereHas('pesertaSertifikasi', function ($query) use ($user) {
                $query->where('id_pengguna', $user->id_pengguna);
            })
            ->update(['is_read' => 1]);

        return redirect()->route('notifikasi.index')->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca.');
    }
}
