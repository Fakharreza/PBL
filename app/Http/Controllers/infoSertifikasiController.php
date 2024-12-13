<?php

namespace App\Http\Controllers;

use App\Models\infoSertifikasiModel;
use App\Models\JenisPelatihanModel;
use App\Models\penggunaModel;
use App\Models\PeriodeModel;
use App\Models\pesertaSertifikasiModel;
use App\Models\VendorSertifModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class infoSertifikasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Info Sertifikasi',
            'list' => ['Home', 'Info Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Daftar Info Sertifikasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'infoSertifikasi'; // set menu yang sedang aktif

        return view('infoSertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
    $infoSertifikasi = InfoSertifikasiModel::select(
        'id_info_sertifikasi',
        'id_vendor_sertifikasi',
        'id_jenis_pelatihan_sertifikasi',
        'id_periode',
        'nama_sertifikasi',
        'level_sertifikasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'masa_berlaku'
    );

    return DataTables::of($infoSertifikasi)
        ->addIndexColumn()
        ->addColumn('aksi', function ($infoSertifikasi) {
            $btn  = '<button onclick="modalAction(\'' . url('/infoSertifikasi/' . $infoSertifikasi->id_info_sertifikasi . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/infoSertifikasi/' . $infoSertifikasi->id_info_sertifikasi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/infoSertifikasi/' . $infoSertifikasi->id_info_sertifikasi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            $btn .= '<button onclick="modalAction(\'' . url('/infoSertifikasi/' . $infoSertifikasi->id_info_sertifikasi . '/tambah_peserta') . '\')" class="btn btn-success btn-sm">Tambah Peserta</button>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create_ajax()
    {
        $vendorSertifikasi = VendorSertifModel::all();
        $jenisSertifikasi = JenisPelatihanModel::all();
        $periode = PeriodeModel::all();
        return view('infoSertifikasi.create_ajax')
        ->with('vendorSertifikasi',$vendorSertifikasi)
        ->with('jenisSertifikasi',$jenisSertifikasi)
        ->with('periode',$periode);
        
    }
    public function tambah_peserta(string $id)
    {
        $id_info = $id;
        $infoSertifikasi = infoSertifikasiModel::find($id);

        // Menghitung jumlah pelatihan dari tabel input_pelatihan
        $dosen = penggunaModel::select('pengguna.*')
            ->leftJoin('input_sertifikasi', 'pengguna.id_pengguna', '=', 'input_sertifikasi.id_pengguna')
            ->where('pengguna.id_jenis_pengguna', 3) // Filter untuk hanya dosen
            ->selectRaw('COUNT(input_sertifikasi.id_pengguna) as jumlah_sertifikasi')
            ->groupBy('pengguna.id_pengguna', 'pengguna.nama_pengguna') // Sesuaikan dengan kolom yang digunakan
            ->orderBy('jumlah_sertifikasi', 'asc') // Urutkan dari dosen paling sedikit pelatihan ke paling banyak
            ->get();

        // Mendapatkan peserta yang sudah terdaftar untuk pelatihan ini
        $peserta = pesertaSertifikasiModel::where('id_info_sertifikasi', $id)
            ->pluck('id_pengguna')
            ->toArray();

        return view('infoSertifikasi.tambah_peserta', [
            'info' => $id_info,
            'infoSertifikasi' => $infoSertifikasi,
            'dosen' => $dosen,
            'peserta' => $peserta,
        ]);
    }
    public function store_ajax(Request $request)
    {
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'id_vendor_sertifikasi' => 'required|integer',
            'id_jenis_pelatihan_sertifikasi' => 'required|integer',
            'id_periode'            => 'required|integer',
            'nama_sertifikasi'      => 'required|string|max:100',
            'level_sertifikasi'     => 'required|string|max:100',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date',
            'masa_berlaku'          => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validasi Gagal',
                'msgField'  => $validator->errors(),
            ]);
        }

        InfoSertifikasiModel::create($request->all());

        return response()->json([
            'status'  => true,
            'message' => 'Data Sertifikasi berhasil disimpan'
        ]);
    }
    redirect('/');
    }

    public function store_peserta(Request $request, string $id)
    {
        // Hapus peserta lama
         pesertaSertifikasiModel::where('id_info_sertifikasi', $id)->delete();

        $request->validate([
            'id_pengguna' => 'required|array',
        ]);

        foreach ($request->id_pengguna as $idPengguna) {
            pesertaSertifikasiModel::create([
                'id_info_sertifikasi' => $id,
                'id_pengguna'       => $idPengguna,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Peserta berhasil ditambahkan.'
        ]);
    }

    public function show_ajax(string $id)
    {
        $infoSertifikasi = InfoSertifikasiModel::find($id);
        $vendorSertifikasi = VendorSertifModel::find($infoSertifikasi->id_vendor_sertifikasi);
        $jenisSertifikasi = JenisPelatihanModel::find($infoSertifikasi->id_jenis_pelatihan_sertifikasi);
        $periode = PeriodeModel::find($infoSertifikasi->id_periode);

        return view('infoSertifikasi.show_ajax', [
            'infoSertifikasi' => $infoSertifikasi,
            'vendorSertifikasi' => $vendorSertifikasi,
            'jenisSertifikasi' => $jenisSertifikasi,
            'periode' => $periode
        ]);
    }

    public function edit_ajax(string $id)
    {
        $infoSertifikasi = InfoSertifikasiModel::find($id);
        $vendorSertifikasi = VendorSertifModel::all(); // Sesuai dengan data vendor sertifikasi
        $jenisSertifikasi = JenisPelatihanModel::all();
        $periode = PeriodeModel::all(); // Data periode yang tersedia

        return view('infoSertifikasi.edit_ajax', [
            'infoSertifikasi' => $infoSertifikasi,
            'vendorSertifikasi' => $vendorSertifikasi,
            'jenisSertifikasi' => $jenisSertifikasi,
            'periode' => $periode,
        ]);
    }
    public function update_ajax(Request $request, string $id)
    {
        // Validasi data input
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
               'id_vendor_sertifikasi' => 'required|integer',
               'id_jenis_pelatihan_sertifikasi' => 'required|integer',
                'id_periode'            => 'required|integer',
                'nama_sertifikasi'      => 'required|string|max:100',
                'level_sertifikasi'     => 'required|string|max:100',
                'tanggal_mulai'         => 'required|date',
                'tanggal_selesai'       => 'required|date',
                'masa_berlaku'          => 'required|integer',
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
            $check = infoSertifikasiModel::find($id);
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
        $infoSertifikasi = infoSertifikasiModel::find($id);

        return view('infoSertifikasi.confirm_ajax', ['infoSertifikasi' => $infoSertifikasi]);
    }
    public function delete_ajax(Request $request, $id)
    {
        // Cek apakah request dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $infoSertifikasi = InfoSertifikasiModel::find($id);
            
            if ($infoSertifikasi) {
                $infoSertifikasi->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Sertifikasi berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Sertifikasi tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }
    public function hapus_peserta($id)
    {
        try {
            pesertaSertifikasiModel::where('id_info_sertifikasi', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Semua peserta berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus peserta. ' . $e->getMessage()
            ]);
        }
    }


}
