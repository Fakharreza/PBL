<?php

namespace App\Http\Controllers;

use App\Models\jenisPenggunaModel;
use App\Models\penggunaModel;
use App\Models\bidangMinatDosenModel;
use App\Models\mataKuliahDosenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $id = session('id_pengguna');
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'profile']
        ];
        $page = (object) [
            'title' => 'Profile Anda'
        ];
        $activeMenu = 'profile'; // set menu yang sedang aktif
        $pengguna = penggunaModel::with('jenisPengguna')->find($id);
        $level = jenisPenggunaModel::all(); // ambil data level untuk filter level
        return view('profile.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'pengguna' => $pengguna, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $pengguna = penggunaModel::with(['jenisPengguna', 'bidangMinat', 'mataKuliah'])->find($id);
    
        $breadcrumb = (object) [
            'title' => 'Edit Profile',
            'list' => ['Home', 'profile']
        ];
    
        $page = (object) [
            'title' => 'Edit Profile'
        ];
    
        $activeMenu = 'profile';
    
        // Ambil data bidang minat dan mata kuliah dari tabel referensi
        $bidangMinat = \App\Models\BidangMinatModel::all(); // Pastikan model ini sudah ada
        $mataKuliah = \App\Models\mataKuliahModel::all();
    
        return view('profile.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'pengguna' => $pengguna,
            'activeMenu' => $activeMenu,
            'bidangMinat' => $bidangMinat, // Kirim data bidang minat ke view
            'mataKuliah' => $mataKuliah,   // Kirim data mata kuliah ke view
        ]);
    }
    
    
    public function update(Request $request, string $id)
    {
        $pengguna = penggunaModel::find($id);
    
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $pengguna->id_pengguna . ',id_pengguna',
            'nip' => 'required|string|unique:pengguna,nip,' . $pengguna->id_pengguna . ',id_pengguna',
            'password' => 'nullable|confirmed',
            'bidang_minat' => 'nullable|array',
            'mata_kuliah' => 'nullable|array',
        ]);
    
        $pengguna->nama_pengguna = $request->nama_pengguna;
        $pengguna->email = $request->email;
        $pengguna->nip = $request->nip;
    
        if ($request->filled('password')) {
            $pengguna->password = bcrypt($request->password);
        }
    
        $pengguna->save();
    
        // Simpan bidang minat
        if ($request->filled('bidang_minat')) {
            bidangMinatDosenModel::where('id_pengguna', $id)->delete(); // Hapus data lama
            foreach ($request->bidang_minat as $bidangMinatId) {
                bidangMinatDosenModel::create([
                    'id_pengguna' => $id,
                    'id_bidang_minat' => $bidangMinatId,
                ]);
            }
        }
    
        // Simpan mata kuliah
        if ($request->filled('mata_kuliah')) {
            mataKuliahDosenModel::where('id_pengguna', $id)->delete(); // Hapus data lama
            foreach ($request->mata_kuliah as $mataKuliahId) {
                mataKuliahDosenModel::create([
                    'id_pengguna' => $id,
                    'id_mata_kuliah' => $mataKuliahId,
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
    
}    