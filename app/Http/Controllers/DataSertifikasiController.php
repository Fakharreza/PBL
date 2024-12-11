<?php

namespace App\Http\Controllers;

use App\Models\DataSertifikasiModel;
use App\Models\JenisPelatihanModel;
use App\Models\penggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DataSertifikasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Sertifikasi',
            'list' => ['Home', 'Data Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Data Sertifikasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'dataSertifikasi';

        // $level = LevelModel::all(); // ambil data level untuk filter level
        return view('dataSertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
        $dataSertifikasi = DataSertifikasiModel::select('id_input_sertifikasi', 'id_jenis_pelatihan_sertifikasi', 'id_pengguna', 'nama_sertifikasi', 'no_sertifikat', 'lokasi_sertifikasi', 'waktu_sertifikasi', 'bukti_sertifikasi', 'masa_berlaku')
            ->with('pengguna');
        $user = Auth::user(); // Mengambil data user yang login

        // Ambil hanya data yang sesuai dengan ID pengguna yang login
        $dataSertifikasi = DataSertifikasiModel::where('id_pengguna', $user->id_pengguna)
            ->with('jenisPelatihan')
            ->get();

        return DataTables::of($dataSertifikasi)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('jenis_pelatihan_sertifikasi', function ($dataSertifikasi) {
                return $dataSertifikasi->jenisPelatihan->nama_jenis_pelatihan_sertifikasi ?? '-';
            })
            ->addColumn('bukti_sertifikasi', function ($dataSertifikasi) {
                if ($dataSertifikasi->bukti_sertifikasi) {
                    // Membuat link untuk menampilkan PDF
                    return '<a href="' . asset('storage/sertifikasi/' . $dataSertifikasi->bukti_sertifikasi) . '" target="_blank">Lihat PDF</a>';
                }
                return '-';
            })
            ->addColumn('aksi', function ($dataSertifikasi) { // menambahkan kolom aksi 
                $btn  = '<button onclick="modalAction(\'' . url('/dataSertifikasi/' . $dataSertifikasi->id_input_sertifikasi . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dataSertifikasi/' . $dataSertifikasi->id_input_sertifikasi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dataSertifikasi/' . $dataSertifikasi->id_input_sertifikasi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['bukti_sertifikasi', 'aksi']) // memberitahu bahwa kolom ini berisi HTML
            ->make(true);
    }

    public function create_ajax()
    {
        $pengguna = penggunaModel::all();
        $jenisPelatihan = JenisPelatihanModel::all();
        $dataSertifikasi = DataSertifikasiModel::all();

        return view('dataSertifikasi.create_ajax', compact('dataSertifikasi', 'pengguna', 'jenisPelatihan'));
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_sertifikasi'     => 'required|string|max:100',
                'id_jenis_pelatihan_sertifikasi' => 'required|exists:jenis_pelatihan_sertifikasi,id_jenis_pelatihan_sertifikasi',
                'no_sertifikat'        => 'required|integer',
                'lokasi_sertifikasi'   => 'required|string|max:50',
                'waktu_sertifikasi'    => 'required|date',
                'masa_berlaku'         => 'required|date',
                'bukti_sertifikasi'    => 'required|file|mimes:pdf|max:2048', // Validasi file PDF
            ];

            // Gunakan Validator untuk validasi
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),
                ]);
            }

            $data = $request->only(['nama_sertifikasi', 'id_jenis_pelatihan_sertifikasi', 'no_sertifikat', 'lokasi_sertifikasi', 'waktu_sertifikasi', 'masa_berlaku', 'bukti_sertifikasi']);
            $data['id_pengguna'] = auth()->id();

            if ($request->hasFile('bukti_sertifikasi')) {
                $file = $request->file('bukti_sertifikasi');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/sertifikasi', $filename);
                $data['bukti_sertifikasi'] = $filename;
            } else {
                $data['bukti_sertifikasi'] = null;
            }

            DataSertifikasiModel::create($data);

            return response()->json([
                'status'    => true,
                'message'   => 'Data berhasil disimpan'
            ]);
        }

        redirect('/');
    }


    public function show_ajax(string $id)
    {
        $dataSertifikasi = DataSertifikasiModel::find($id);
        return view('dataSertifikasi.show_ajax', ['dataSertifikasi' => $dataSertifikasi]);
    }
    public function edit_ajax(string $id)
    {
        $dataSertifikasi = DataSertifikasiModel::find($id);
        $pengguna = penggunaModel::all();
        $jenisPelatihan = JenisPelatihanModel::all();

        return view('dataSertifikasi.edit_ajax', compact('dataSertifikasi', 'pengguna', 'jenisPelatihan'));
    }
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_sertifikasi'     => 'required|string|max:100',
                'id_jenis_pelatihan_sertifikasi' => 'required|exists:jenis_pelatihan_sertifikasi,id_jenis_pelatihan_sertifikasi',
                'no_sertifikat'        => 'required|integer',
                'lokasi_sertifikasi'   => 'required|string|max:50',
                'waktu_sertifikasi'    => 'required|date',
                'masa_berlaku'         => 'required|date',
                'bukti_sertifikasi'    => 'nullable|file|mimes:pdf|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Cari data sertifikasi berdasarkan ID
            $dataSertifikasi = DataSertifikasiModel::find($id);
            if ($dataSertifikasi) {
                $data = $request->only(['nama_sertifikasi', 'id_jenis_pelatihan_sertifikasi', 'no_sertifikat', 'lokasi_sertifikasi', 'waktu_sertifikasi', 'masa_berlaku', 'bukti_sertifikasi']);

                // Jika ada file bukti_pelatihan, simpan file tersebut
                if ($request->hasFile('bukti_sertifikasi')) {
                    $file = $request->file('bukti_sertifikasi');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/sertifikasi', $filename);
                    $data['bukti_sertifikasi'] = $filename;
                }

                $dataSertifikasi->update($data);

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
        $dataSertifikasi = DataSertifikasiModel::find($id);

        return view('dataSertifikasi.confirm_ajax', ['dataSertifikasi' => $dataSertifikasi]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $dataSertifikasi = DataSertifikasiModel::find($id);
            if ($dataSertifikasi) {
                $dataSertifikasi->delete();
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
