<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mataKuliahModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MataKuliahController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Mata Kuliah',
            'list' => ['Home', 'pengguna']
        ];

        $page = (object) [
            'title' => 'Daftar Mata Kuliah yang terdaftar dalam sistem'
        ];

        $activeMenu = 'mataKuliah'; // set menu yang sedang aktif

        // $level = LevelModel::all(); // ambil data level untuk filter level
        return view('mataKuliah.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan data untuk keperluan DataTables
    // public function list()
    // {
    //     $query = mataKuliahModel::query();

    //     return DataTables::of($query)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function($row) {
    //             return '
    //                 <div class="btn-group" role="group">
    //                     <button class="btn btn-warning btn-sm" onclick="editMataKuliah('.$row->id_mata_kuliah.')">
    //                         <i class="fas fa-edit"></i> Edit
    //                     </button>
    //                     <button class="btn btn-danger btn-sm" onclick="deleteMataKuliah('.$row->id_mata_kuliah.')">
    //                         <i class="fas fa-trash"></i> Delete
    //                     </button>
    //                 </div>
    //             ';
    //         })
    //         ->rawColumns(['aksi'])
    //         ->make(true);
    // }
    public function list(Request $request)
    {
        $mataKuliah = mataKuliahModel::select('id_mata_kuliah','nama_mata_kuliah');
        return DataTables::of($mataKuliah)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($mataKuliah) { // menambahkan kojenismataK$mataKuliahom aksi 
                $btn  = '<button onclick="modalAction(\'' . url('/mataKuliah/' . $mataKuliah->id_mata_kuliah . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mataKuliah/' . $mataKuliah->id_mata_kuliah . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mataKuliah/' . $mataKuliah->id_mata_kuliah . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }
    // Menampilkan form create mata kuliah
    public function create_ajax()
    {
        return view('mataKuliah.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_mata_kuliah'    => 'required|string|max:100',

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
            mataKuliahModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    
    public function show_ajax(string $id)
    {
        $mataKuliah = mataKuliahModel::find($id);
        return view('mataKuliah.show_ajax', ['mataKuliah' => $mataKuliah]);
    }
    public function edit_ajax(string $id)
    {
        $mataKuliah = mataKuliahModel::find($id);

        return view('mataKuliah.edit_ajax', ['mataKuliah' => $mataKuliah ]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_mata_kuliah'    => 'required|string|max:100',
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
            $check = mataKuliahModel::find($id);
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
        $mataKuliah = mataKuliahModel::find($id);

        return view('mataKuliah.confirm_ajax', ['mataKuliah' => $mataKuliah]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $mataKuliah = mataKuliahModel::find($id);
            if($mataKuliah){
                $mataKuliah->delete();
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