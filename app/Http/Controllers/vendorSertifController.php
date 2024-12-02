<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorSertifModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class vendorSertifController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Vendor Sertifikasi',
            'list' => ['Home', 'vendorSertifikasi']
        ];

        $page = (object) [
            'title' => 'Kelola Vendor Sertifikasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'vendorSertifikasi'; // set menu yang sedang aktif

        return view('vendorSertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $vendorSertifikasi = VendorSertifModel::select('id_vendor_sertifikasi', 'nama_vendor', 'alamat', 'kota', 'no_telp', 'alamat_web');
        return DataTables::of($vendorSertifikasi)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($vendorSertifikasi) { // menambahkan kolom aksi
                $btn  = '<button onclick="modalAction(\'' . url('/vendorSertif/' . $vendorSertifikasi->id_vendor_sertifikasi . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendorSertif/' . $vendorSertifikasi->id_vendor_sertifikasi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendorSertif/' . $vendorSertifikasi->id_vendor_sertifikasi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create_ajax()
    {
        return view('vendorSertifikasi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_vendor'  => 'required|string|max:100',
                'alamat'       => 'required|string|max:255',
                'kota'         => 'required|string|max:100',
                'no_telp'      => 'required|string|max:20',
                'alamat_web'   => 'required|url|max:255',
            ];
    
            // Validasi
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),
                ]);
            }
    
            // Simpan data ke database
            VendorSertifModel::create($request->all());
    
            return response()->json([
                'status'    => true,
                'message'   => 'Data Vendor Sertifikasi berhasil disimpan'
            ]);
        }
        return redirect('/');
    }
    

    public function show_ajax(string $id)
    {
        $vendorSertifikasi = VendorSertifModel::find($id);
        return view('vendorSertifikasi.show_ajax', ['vendorSertifikasi' => $vendorSertifikasi]);
    }

    public function edit_ajax(string $id)
    {
        $vendorSertifikasi = VendorSertifModel::find($id);

        return view('vendorSertifikasi.edit_ajax', ['vendorSertifikasi' => $vendorSertifikasi]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_vendor'    => 'required|string|max:100',
                'alamat'         => 'required|string|max:255',
                'kota'           => 'required|string|max:100',
                'no_telp'        => 'required|string|max:20',
                'alamat_web'     => 'required|url|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = VendorSertifModel::find($id);

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

    public function confirm_ajax(String $id)
    {
        $vendorSertifikasi = VendorSertifModel::find($id);
        return view('vendorSertifikasi.confirm_ajax', ['vendorSertifikasi' => $vendorSertifikasi]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $vendorSertifikasi = VendorSertifModel::find($id);

            if ($vendorSertifikasi) {
                $vendorSertifikasi->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
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
}
