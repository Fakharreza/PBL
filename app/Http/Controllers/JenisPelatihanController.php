<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPelatihanModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisPelatihanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Jenis Pelatihan',
            'list' => ['Home', 'jenisPelatihan']
        ];

        $page = (object) [
            'title' => 'Daftar Jenis Pelatihan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'jenisPelatihan'; // set menu yang sedang aktif

        return view('jenisPelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
        $jenisPelatihan = JenisPelatihanModel::select('id_jenis_pelatihan','nama_jenis_pelatihan');
        return DataTables::of($jenisPelatihan)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($jenisPelatihan) { // menambahkan kojenisPelatihanom aksi 
                $btn  = '<button onclick="modalAction(\'' . url('/jenisPelatihan/' . $jenisPelatihan->id_jenis_pelatihan . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenisPelatihan/' . $jenisPelatihan->id_jenis_pelatihan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenisPelatihan/' . $jenisPelatihan->id_jenis_pelatihan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }
    public function create_ajax()
    {
        return view('jenisPelatihan.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_jenis_pelatihan'    => 'required|string|max:100',
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
            JenisPelatihanModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data level berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    public function show_ajax(string $id)
    {
        $jenisPelatihan = JenisPelatihanModel::find($id);
        return view('jenisPelatihan.show_ajax', ['jenisPelatihan' => $jenisPelatihan]);
    }
    public function edit_ajax(string $id)
    {
        $jenisPelatihan = JenisPelatihanModel::find($id);

        return view('jenisPelatihan.edit_ajax', ['jenisPelatihan' => $jenisPelatihan ]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_jenis_pelatihan'    => 'required|string|max:100',
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
            $check = JenisPelatihanModel::find($id);
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
        $jenisPelatihan = JenisPelatihanModel::find($id);

        return view('jenisPelatihan.confirm_ajax', ['jenisPelatihan' => $jenisPelatihan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $jenisPelatihan = jenisPelatihanModel::find($id);
            if($jenisPelatihan){
                $jenisPelatihan->delete();
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
