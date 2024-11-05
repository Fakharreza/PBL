<?php

namespace App\Http\Controllers;

use App\Models\jenisPenggunaModel;
use App\Models\penggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home 
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('nama_pengguna', 'password');

            if (Auth::attempt($credentials)) {
                session(['id_pengguna' => Auth::user()->id_pengguna]);
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/home')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function register()
    {
        $jenisPengguna = jenisPenggunaModel::select('id_jenis_pengguna', 'nama_jenis_pengguna')->get();

        return view('auth.register')
            ->with('jenisPengguna', $jenisPengguna);
    }

    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_jenis_pengguna'  => 'required|integer',
                'nama_pengguna'  => 'required|string|min:3|unique:pengguna,nama_pengguna',
                'email'      => 'required|string|max:100',
                'password'  => 'required|min:6'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false, // response status, false: error/gagal, true: berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(), // pesan error validasi
                ]);
            }
            penggunaModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan',
                'redirect' => url('login')
            ]);
        }
        return redirect('login');
    }
}