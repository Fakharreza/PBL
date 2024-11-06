<?php

namespace App\Http\Controllers;

use App\Models\jenisPenggunaModel;
use App\Models\penggunaModel;
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

    // Menampilkan halaman edit profil
    // public function edit($id)
    // {
    //     $pengguna = penggunaModel::findOrFail($id);
    //     return view('profile.edit', compact('pengguna'));
    // }
    public function edit(string $id)
    {
        $pengguna = penggunaModel::find($id);
    
        $breadcrumb = (object) [
            'title' => 'Edit Profile',
            'list' => ['Home', 'profile']
        ];
    
        $page = (object) [
            'title' => 'Edit Profile'
        ];
    
        $activeMenu = 'profile';
    
        return view('profile.edit', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'pengguna' => $pengguna, // Mengganti 'profile' dengan 'pengguna'
            'activeMenu' => $activeMenu
        ]);
    }
    
    public function update(Request $request, string $id)
    {
        $pengguna = penggunaModel::find($id);
    
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,'.$pengguna->id_pengguna.',id_pengguna',
            'nip' => 'required|string|unique:pengguna,nip,'.$pengguna->id_pengguna.',id_pengguna',
            'password' => 'nullable|confirmed|min:8',
        ]);
    
        $pengguna->nama_pengguna = $request->nama_pengguna;
        $pengguna->email = $request->email;
        $pengguna->nip = $request->nip;
    
        // Jika password diisi, maka ubah passwordnya
        if ($request->filled('password')) {
            $pengguna->password = bcrypt($request->password);
        }
    
        $pengguna->save();
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}    