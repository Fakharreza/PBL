<?php

namespace App\Http\Controllers;

use App\Models\BidangMinatModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BidangMinatController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Bidang Minat',
            'list' => ['Home', 'bidangMinat']
        ];

        $page = (object) [
            'title' => 'Daftar Bidang Minat yang terdaftar dalam sistem'
        ];

        $activeMenu = 'bidangMinat'; // set menu yang sedang aktif

        return view('bidangMinat.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
        $bidangMinat = BidangMinatModel::select('id_bidang_minat','nama_bidang_minat');
        return DataTables::of($bidangMinat)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($bidangMinat) { 
                $btn  = '<button onclick="modalAction(\'' . url('/bidangMinat/' . $bidangMinat->id_bidang_minat . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/bidangMinat/' . $bidangMinat->id_bidang_minat . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/bidangMinat/' . $bidangMinat->id_bidang_minat . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }
    public function create_ajax()
    {
        return view('bidangMinat.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_bidang_minat'    => 'required|string|max:100',
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
            BidangMinatModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data level berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    public function show_ajax(string $id)
    {
        $bidangMinat = BidangMinatModel::find($id);
        return view('bidangMinat.show_ajax', ['bidangMinat' => $bidangMinat]);
    }
    public function edit_ajax(string $id)
    {
        $bidangMinat = BidangMinatModel::find($id);

        return view('bidangMinat.edit_ajax', ['bidangMinat' => $bidangMinat ]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_bidang_minat'    => 'required|string|max:100',
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
            $check = BidangMinatModel::find($id);
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
        $bidangMinat = BidangMinatModel::find($id);

        return view('bidangMinat.confirm_ajax', ['bidangMinat' => $bidangMinat]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $bidangMinat = BidangMinatModel::find($id);
            if($bidangMinat){
                $bidangMinat->delete();
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
