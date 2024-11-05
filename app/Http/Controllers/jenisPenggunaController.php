<?php

namespace App\Http\Controllers;

use App\Models\jenisPenggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class jenisPenggunaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Jenis Pengguna',
            'list' => ['Home', 'jenisPengguna']
        ];

        $page = (object) [
            'title' => 'Daftar Jenis Pengguna yang terdaftar dalam sistem'
        ];

        $activeMenu = 'jenisPengguna'; // set menu yang sedang aktif

        // $level = LevelModel::all(); // ambil data level untuk filter level
        return view('jenisPengguna.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $jenisPengguna = jenisPenggunaModel::select('id_jenis_pengguna','kode_jenis_pengguna', 'nama_jenis_pengguna');
        return DataTables::of($jenisPengguna)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($jenisPengguna) { // menambahkan kojenisPenggunaom aksi 
                $btn  = '<button onclick="modalAction(\'' . url('/jenisPengguna/' . $jenisPengguna->id_jenis_pengguna . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenisPengguna/' . $jenisPengguna->id_jenis_pengguna . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenisPengguna/' . $jenisPengguna->id_jenis_pengguna . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }
    public function create_ajax()
    {
        return view('jenisPengguna.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_jenis_pengguna'    => 'required|string|min:3|unique:jenis_pengguna,kode_jenis_pengguna',
                'nama_jenis_pengguna'    => 'required|string|max:100',
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
            jenisPenggunaModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data level berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    public function show_ajax(string $id)
    {
        $jenisPengguna = jenisPenggunaModel::find($id);
        return view('jenisPengguna.show_ajax', ['jenisPengguna' => $jenisPengguna]);
    }
    public function edit_ajax(string $id)
    {
        $jenisPengguna = jenisPenggunaModel::find($id);

        return view('jenisPengguna.edit_ajax', ['jenisPengguna' => $jenisPengguna ]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
               'kode_jenis_pengguna'    => 'required|string|min:3|unique:jenis_pengguna,kode_jenis_pengguna',
               'nama_jenis_pengguna'    => 'required|string|max:100',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = jenisPenggunaModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function confirm_ajax(String $id){
        $jenisPengguna = jenisPenggunaModel::find($id);

        return view('jenisPengguna.confirm_ajax', ['jenisPengguna' => $jenisPengguna]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $jenisPengguna = jenisPenggunaModel::find($id);
            if($jenisPengguna){
                $jenisPengguna->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}