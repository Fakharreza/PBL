<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PeriodeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Periode',
            'list' => ['Home', 'periode']
        ];

        $page = (object) [
            'title' => 'Kelola Periode yang terdaftar dalam sistem'
        ];

        $activeMenu = 'periode'; // set menu yang sedang aktif

        return view('periode.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $periode = PeriodeModel::select('id_periode', 'tahun_periode');
        return DataTables::of($periode)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($periode) { // menambahkan kolom aksi
                $btn  = '<button onclick="modalAction(\'' . url('/periode/' . $periode->id_periode . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/periode/' . $periode->id_periode . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/periode/' . $periode->id_periode . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create_ajax()
    {
        return view('periode.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tahun_periode'  => 'required|string|max:30',
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
            PeriodeModel::create($request->all());
    
            return response()->json([
                'status'    => true,
                'message'   => 'Data Periode berhasil disimpan'
            ]);
        }
        return redirect('/');
    }
    

    public function show_ajax(string $id)
    {
        $periode = PeriodeModel::find($id);
        return view('periode.show_ajax', ['periode' => $periode]);
    }

    public function edit_ajax(string $id)
    {
        $periode = PeriodeModel::find($id);

        return view('periode.edit_ajax', ['periode' => $periode]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tahun_periode'  => 'required|string|max:30',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = PeriodeModel::find($id);

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
        $periode = PeriodeModel::find($id);
        return view('periode.confirm_ajax', ['periode' => $periode]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $periode = PeriodeModel::find($id);

            if ($periode) {
                $periode->delete();
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
