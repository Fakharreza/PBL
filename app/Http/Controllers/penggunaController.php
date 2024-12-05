<?php

namespace App\Http\Controllers;

use App\Models\jenisPenggunaModel;
use App\Models\penggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class penggunaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'pengguna']
        ];

        $page = (object) [
            'title' => 'Daftar Pengguna yang terdaftar dalam sistem'
        ];

        $activeMenu = 'pengguna'; // set menu yang sedang aktif

        // $level = LevelModel::all(); // ambil data level untuk filter level
        return view('pengguna.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $pengguna = penggunaModel::select('id_pengguna','id_jenis_pengguna','nama_pengguna', 'email' , 'nip' , 'password')
        -> with('jenisPengguna');
        return DataTables::of($pengguna)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($pengguna) { // menambahkan kojenisPenggunaom aksi 
                $btn  = '<button onclick="modalAction(\'' . url('/pengguna/' . $pengguna->id_pengguna . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pengguna/' . $pengguna->id_pengguna . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pengguna/' . $pengguna->id_pengguna . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }
    public function create_ajax()
    {
        $jenisPengguna = jenisPenggunaModel::all();
        $pengguna = penggunaModel::all();
        return view('pengguna.create_ajax')
        ->with('pengguna',$pengguna)
        ->with('jenisPengguna',$jenisPengguna);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_jenis_pengguna'    => 'required|integer',
                'nama_pengguna'    => 'required|string|max:100',
                'email'    => 'required|string|max:100',
                'nip'    => 'required|integer',
                'password'    => 'required|min:5',
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
                'message'   => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    public function show_ajax(string $id)
    {
        $pengguna = penggunaModel::find($id);
        $jenisPengguna = jenisPenggunaModel::find($pengguna->id_jenis_pengguna);
        return view('pengguna.show_ajax', ['pengguna' => $pengguna , 'jenisPengguna'=> $jenisPengguna]);
    }
    public function edit_ajax(string $id)
    {
        $pengguna = penggunaModel::find($id);
        $jenisPengguna = jenisPenggunaModel::all();

        return view('pengguna.edit_ajax', ['pengguna' => $pengguna , 'jenisPengguna' => $jenisPengguna]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_jenis_pengguna'    => 'required|integer',
                'nama_pengguna'    => 'required|string|max:100',
                'email'    => 'required|string|max:100',
                'nip'    => 'required|integer',
                'password'    => 'required|min:5',
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
            $check = penggunaModel::find($id);
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
        $pengguna = penggunaModel::find($id);

        return view('pengguna.confirm_ajax', ['pengguna' => $pengguna]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $pengguna = penggunaModel::find($id);
            if($pengguna){
                $pengguna->delete();
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