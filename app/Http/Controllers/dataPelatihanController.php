<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dataPelatihanModel;
use App\Models\JenisPelatihanModel;
use App\Models\PeriodeModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class dataPelatihanController extends Controller
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

        return view('dataPelatihan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $user = Auth::user();

        $dataPelatihan = dataPelatihanModel::where('id_pengguna', $user->id_pengguna)
            ->with('jenisPelatihan', 'periode', 'pengguna')
            ->select('id_input_pelatihan', 'nama_pelatihan', 'id_jenis_pelatihan_sertifikasi', 'id_periode', 'waktu_pelatihan', 'lokasi_pelatihan', 'bukti_pelatihan')
            ->get();

        return DataTables::of($dataPelatihan)
            ->addIndexColumn()
            ->addColumn('jenis_pelatihan_sertifikasi', function ($dataPelatihan) {
                return $dataPelatihan->jenisPelatihan->nama_jenis_pelatihan_sertifikasi ?? '-';
            })
            ->addColumn('nama_pengguna', function ($dataPelatihan) {
                return $dataPelatihan->pengguna->nama_pengguna ?? '-';
            })
            ->addColumn('periode', function ($dataPelatihan) {
                return $dataPelatihan->periode->tahun_periode ?? '-';
            })
            ->addColumn('bukti_pelatihan', function ($dataPelatihan) {
                if ($dataPelatihan->bukti_pelatihan) {
                    return '<a href="' . asset('storage/bukti_pelatihan/' . $dataPelatihan->bukti_pelatihan) . '" target="_blank">Lihat PDF</a>';
                }
                return '-';
            })
            ->addColumn('aksi', function ($dataPelatihan) {
                $btn  = '<button onclick="modalAction(\'' . url('/dataPelatihan/' . $dataPelatihan->id_input_pelatihan . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dataPelatihan/' . $dataPelatihan->id_input_pelatihan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dataPelatihan/' . $dataPelatihan->id_input_pelatihan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['bukti_pelatihan', 'aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $jenisPelatihan = JenisPelatihanModel::all();
        $periode = PeriodeModel::all();
        return view('dataPelatihan.create_ajax', compact('jenisPelatihan', 'periode'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelatihan'    => 'required|string|max:150',
                'id_jenis_pelatihan_sertifikasi' => 'required|exists:jenis_pelatihan_sertifikasi,id_jenis_pelatihan_sertifikasi',
                'id_periode'        => 'required|exists:periode,id_periode',
                'waktu_pelatihan'   => 'required|date',
                'lokasi_pelatihan'  => 'required|string|max:200',
                'bukti_pelatihan'   => 'nullable|mimes:pdf|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),
                ]);
            }

            $data = $request->only(['nama_pelatihan', 'id_jenis_pelatihan_sertifikasi', 'id_periode', 'waktu_pelatihan', 'lokasi_pelatihan']);
            $data['id_pengguna'] = auth()->id();

            if ($request->hasFile('bukti_pelatihan')) {
                $file = $request->file('bukti_pelatihan');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/bukti_pelatihan', $filename);
                $data['bukti_pelatihan'] = $filename;
            } else {
                $data['bukti_pelatihan'] = null;
            }

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
        $jenisPelatihan = JenisPelatihanModel::all();
        $periode = PeriodeModel::all();

        return view('dataPelatihan.edit_ajax', compact('dataPelatihan', 'jenisPelatihan', 'periode'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelatihan'    => 'required|string|max:150',
                'id_jenis_pelatihan_sertifikasi' => 'required|exists:jenis_pelatihan_sertifikasi,id_jenis_pelatihan_sertifikasi',
                'id_periode'        => 'required|exists:periode,id_periode',
                'waktu_pelatihan'   => 'required|date',
                'lokasi_pelatihan'  => 'required|string|max:200',
                'bukti_pelatihan'   => 'nullable|mimes:pdf|max:2048',
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
                $data = $request->only(['nama_pelatihan', 'id_jenis_pelatihan_sertifikasi', 'id_periode', 'waktu_pelatihan', 'lokasi_pelatihan']);

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

    public function confirm_ajax(string $id)
    {
        $dataPelatihan = dataPelatihanModel::find($id);

        if ($dataPelatihan) {
            return view('dataPelatihan.confirm_ajax', ['dataPelatihan' => $dataPelatihan]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
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
