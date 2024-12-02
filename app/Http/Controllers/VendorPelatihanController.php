<?php

namespace App\Http\Controllers;

use App\Models\VendorPelatihanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VendorPelatihanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Vendor Pelatihan',
            'list' => ['Home', 'vendorPelatihan']
        ];

        $page = (object) [
            'title' => 'Daftar Vendor Pelatihan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'vendorPelatihan'; // set menu yang sedang aktif

        // $level = LevelModel::all(); // ambil data level untuk filter level
        return view('vendorPelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $vendorPelatihan = VendorPelatihanModel::select('id_vendor_pelatihan','nama_vendor', 'alamat','kota','no_telp','alamat_web');
        return DataTables::of($vendorPelatihan)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($vendorPelatihan) { // menambahkan kojenisPenggunaom aksi 
                $btn  = '<button onclick="modalAction(\'' . url('/vendorPelatihan/' . $vendorPelatihan->id_vendor_pelatihan . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendorPelatihan/' . $vendorPelatihan->id_vendor_pelatihan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendorPelatihan/' . $vendorPelatihan->id_vendor_pelatihan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }
    public function create_ajax()
    {
        return view('vendorPelatihan.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_vendor'    => 'required|string|max:100',
                'alamat'         =>'required|string|max:100',
                'kota'           =>'required|string|max:100',
                'no_telp'        =>'required|string|max:100',
                'alamat_web'     =>'required|string|max:100',
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
            VendorPelatihanModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data Vendor berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    public function show_ajax(string $id)
    {
        $vendorPelatihan = VendorPelatihanModel::find($id);
        return view('vendorPelatihan.show_ajax', ['vendorPelatihan' => $vendorPelatihan]);
    }
    public function edit_ajax(string $id)
    {
        $vendorPelatihan = VendorPelatihanModel::find($id);

        return view('vendorPelatihan.edit_ajax', ['vendorPelatihan' => $vendorPelatihan ]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
               'nama_vendor'    => 'required|string|max:100',
                'alamat'         =>'required|string|max:100',
                'kota'           =>'required|string|max:100',
                'no_telp'        =>'required|string|max:100',
                'alamat_web'     =>'required|string|max:100',
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
            $check = VendorPelatihanModel::find($id);
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
        $vendorPelatihan = VendorPelatihanModel::find($id);

        return view('vendorPelatihan.confirm_ajax', ['vendorPelatihan' => $vendorPelatihan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $vendorPelatihan = VendorPelatihanModel::find($id);
            if($vendorPelatihan){
                $vendorPelatihan->delete();
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
