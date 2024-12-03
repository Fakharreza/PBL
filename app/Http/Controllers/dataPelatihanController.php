<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dataPelatihanModel;
use App\Models\JenisPelatihanModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataPelatihanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Pelatihan',
            'list' => ['Home', 'Data Pelatihan']
        ];

        $page = (object) [
            'title' => 'Daftar Data Pelatihan Dosen yang terdaftar dalam sistem'
        ];

        $activeMenu = 'dataPelatihan';

        return view('dataPelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $dataPelatihan = dataPelatihanModel::select('id_pelatihan', 'nama_pelatihan', 'id_jenis_pelatihan', 'waktu_pelatihan', 'biaya', 'lokasi_pelatihan')
        -> with ('jenisPelatihan');
        return DataTables::of($dataPelatihan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($dataPelatihan) {
                $btn  = '<button onclick="modalAction(\'' . url('/dataPelatihan/' . $dataPelatihan->id_pelatihan . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dataPelatihan/' . $dataPelatihan->id_pelatihan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dataPelatihan/' . $dataPelatihan->id_pelatihan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $jenisPelatihan = JenisPelatihanModel::all();
        $dataPelatihan = dataPelatihanModel::all();
        return view('dataPelatihan.create_ajax')
            ->with('jenisPelatihan', $jenisPelatihan)
            ->with('dataPelatihan', $dataPelatihan);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelatihan'    => 'required|string|max:150',
                'jenis_pelatihan'   => 'required|string|max:100',
                'waktu_pelatihan'   => 'required|date',
                'biaya'             => 'required|numeric',
                'lokasi_pelatihan'  => 'required|string|max:200',
                'bukti_pelatihan'   => 'required|mimes:pdf|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),
                ]);
            }

            $data = $request->all();

            // if ($request->hasFile('bukti_pelatihan')) {
            //     $file = $request->file('bukti_pelatihan');
            //     $filename = time() . '_' . $file->getClientOriginalName();
            //     $file->storeAs('public/bukti_pelatihan', $filename);
            //     $data['bukti_pelatihan'] = $filename;
            // }

            dataPelatihanModel::create($data);

            return response()->json([
                'status'    => true,
                'message'   => 'Data berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $dataPelatihan = dataPelatihanModel::find($id);

        return view('dataPelatihan.show_ajax', ['dataPelatihan' => $dataPelatihan]);
    }

    public function edit_ajax(string $id)
    {
        $dataPelatihan = dataPelatihanModel::find($id);

        return view('dataPelatihan.edit_ajax', ['dataPelatihan' => $dataPelatihan]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelatihan'    => 'required|string|max:150',
                'jenis_pelatihan'   => 'required|string|max:100',
                'waktu_pelatihan'   => 'required|date',
                'biaya'             => 'required|numeric',
                'lokasi_pelatihan'  => 'required|string|max:200',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $dataPelatihan = dataPelatihanModel::find($id);

            if ($dataPelatihan) {
                $data = $request->all();

                if ($request->hasFile('bukti_pelatihan')) {
                    $file = $request->file('bukti_pelatihan');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/bukti_pelatihan', $filename);
                    $data['bukti_pelatihan'] = $filename;
                }

                $dataPelatihan->update($data);

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

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $dataPelatihan = dataPelatihanModel::find($id);

            if ($dataPelatihan) {
                $dataPelatihan->delete();

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
