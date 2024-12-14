<?php

namespace App\Http\Controllers;

use App\Models\BidangMinatModel;
use App\Models\bidangMinatPelatihanModel;
use App\Models\infoPelatihanModel;
use App\Models\JenisPelatihanModel;
use App\Models\mataKuliahModel;
use App\Models\mataKuliahPelatihanModel;
use App\Models\penggunaModel;
use App\Models\PeriodeModel;
use App\Models\pesertaPelatihanModel;
use App\Models\VendorPelatihanModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class infoPelatihanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Info Pelatihan',
            'list' => ['Home', 'Info Pelatihan']
        ];

        $page = (object) [
            'title' => 'Daftar Info Pelatihan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'infoPelatihan'; // set menu yang sedang aktif

        return view('infoPelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
{
    $infoPelatihan = infoPelatihanModel::select(
        'id_info_pelatihan',
        'id_vendor_pelatihan',
        'id_jenis_pelatihan_sertifikasi',
        'id_periode',
        'lokasi_pelatihan',
        'nama_pelatihan',
        'level_pelatihan',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota_peserta',
        'biaya'
    );

    return DataTables::of($infoPelatihan)
        ->addIndexColumn()
        ->addColumn('aksi', function ($infoPelatihan) {
            $btn  = '<button onclick="modalAction(\'' . url('/infoPelatihan/' . $infoPelatihan->id_info_pelatihan . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/infoPelatihan/' . $infoPelatihan->id_info_pelatihan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/infoPelatihan/' . $infoPelatihan->id_info_pelatihan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/infoPelatihan/' . $infoPelatihan->id_info_pelatihan . '/tambah_peserta') . '\')" class="btn btn-success btn-sm">Tambah Peserta</button>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}
    public function create_ajax()
    {
        $vendorPelatihan = VendorPelatihanModel::all();
        $jenisPelatihan = JenisPelatihanModel::all();
        $periode = PeriodeModel::all();
        $bidangMinat = BidangMinatModel::all();
        $mataKuliah = mataKuliahModel::all();
        return view('infoPelatihan.create_ajax')
        ->with('vendorPelatihan',$vendorPelatihan)
        ->with('jenisPelatihan',$jenisPelatihan)
        ->with('periode',$periode)
        ->with('bidangMinat',$bidangMinat)
        ->with('mataKuliah',$mataKuliah);
        
    }
    public function tambah_peserta(string $id)
    {
        $id_info = $id;
        $infoPelatihan = infoPelatihanModel::find($id);
    
        // Pastikan info pelatihan ditemukan
        if (!$infoPelatihan) {
            return redirect()->back()->with('error', 'Info pelatihan tidak ditemukan.');
        }
    
        // Ambil id_bidang_minat dari tabel bidang_minat_pelatihan
        $bidangMinatPelatihan = bidangMinatPelatihanModel::where('id_info_pelatihan', $id)
                                ->pluck('id_bidang_minat')->toArray();
    
        // Ambil id_mata_kuliah dari tabel mata_kuliah_pelatihan
        $mataKuliahPelatihan = mataKuliahPelatihanModel::where('id_info_pelatihan', $id)
                                 ->pluck('id_mata_kuliah')->toArray();
    
        // Menghitung jumlah peserta yang sudah terdaftar
        $jumlahPesertaTerdaftar = pesertaPelatihanModel::where('id_info_pelatihan', $id)->count();
    
        // Mengambil dosen yang sesuai dengan bidang minat ATAU mata kuliah pelatihan
        $dosen = penggunaModel::select('pengguna.id_pengguna', 'pengguna.nama_pengguna')
            ->where('pengguna.id_jenis_pengguna', 3) // Filter hanya dosen
            ->where(function ($query) use ($bidangMinatPelatihan, $mataKuliahPelatihan) {
                if (!empty($bidangMinatPelatihan)) {
                    $query->whereIn('pengguna.id_pengguna', function ($subQuery) use ($bidangMinatPelatihan) {
                        $subQuery->select('id_pengguna')
                            ->from('bidang_minat_dosen')
                            ->whereIn('id_bidang_minat', $bidangMinatPelatihan);
                    });
                }
    
                if (!empty($mataKuliahPelatihan)) {
                    $query->orWhereIn('pengguna.id_pengguna', function ($subQuery) use ($mataKuliahPelatihan) {
                        $subQuery->select('id_pengguna')
                            ->from('mata_kuliah_dosen')
                            ->whereIn('id_mata_kuliah', $mataKuliahPelatihan);
                    });
                }
            })
            ->leftJoin('input_pelatihan', 'pengguna.id_pengguna', '=', 'input_pelatihan.id_pengguna')
            ->selectRaw('pengguna.id_pengguna, pengguna.nama_pengguna, COUNT(input_pelatihan.id_pengguna) as jumlah_pelatihan')
            ->groupBy('pengguna.id_pengguna', 'pengguna.nama_pengguna')
            ->orderBy('jumlah_pelatihan', 'asc')
            ->get();
    
        // Mendapatkan peserta yang sudah terdaftar untuk pelatihan ini
        $peserta = pesertaPelatihanModel::where('id_info_pelatihan', $id)
            ->pluck('id_pengguna')
            ->toArray();
    
        // Kirim status kuota penuh ke view
        $kuotaPenuh = $jumlahPesertaTerdaftar >= $infoPelatihan->kuota_peserta;
    
        return view('infoPelatihan.tambah_peserta', [
            'info' => $id_info,
            'infoPelatihan' => $infoPelatihan,
            'dosen' => $dosen,
            'peserta' => $peserta,
            'kuotaPenuh' => $kuotaPenuh, // Tambahkan ini
        ]);
    }
    



    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_vendor_pelatihan'       => 'required|integer',
                'id_jenis_pelatihan_sertifikasi'        => 'required|integer',
                'id_periode'                => 'required|integer',
                'lokasi_pelatihan'          => 'required|string|max:100',
                'nama_pelatihan'            => 'required|string|max:100',
                'level_pelatihan'           => 'required|string|max:100',
                'tanggal_mulai'             => 'required|date',
                'tanggal_selesai'           => 'required|date',
                'kuota_peserta'             => 'required|integer',
                'biaya'                     => 'required|numeric',
                'id_bidang_minat'           => 'nullable|array',
                'id_mata_kuliah'            => 'nullable|array',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),
                ]);
            }
    
            // Simpan data info pelatihan
            $infoPelatihan = infoPelatihanModel::create($request->all());
    
            // Simpan bidang minat jika ada
            if ($request->has('id_bidang_minat')) {
                foreach ($request->id_bidang_minat as $idBidangMinat) {
                    bidangMinatPelatihanModel::create([
                        'id_info_pelatihan' => $infoPelatihan->id_info_pelatihan,
                        'id_bidang_minat'   => $idBidangMinat,
                    ]);
                }
            }
    
            // Simpan mata kuliah jika ada
            if ($request->has('id_mata_kuliah')) {
                foreach ($request->id_mata_kuliah as $idMataKuliah) {
                    mataKuliahPelatihanModel::create([
                        'id_info_pelatihan' => $infoPelatihan->id_info_pelatihan,
                        'id_mata_kuliah'    => $idMataKuliah,
                    ]);
                }
            }
    
            return response()->json([
                'status'    => true,
                'message'   => 'Data Info berhasil disimpan',
            ]);
        }
        return redirect('/');
    }
    public function store_peserta(Request $request, string $id)
    {
        // Hapus peserta lama
         pesertaPelatihanModel::where('id_info_pelatihan', $id)->delete();

        $request->validate([
            'id_pengguna' => 'required|array',
        ]);

        foreach ($request->id_pengguna as $idPengguna) {
            pesertaPelatihanModel::create([
                'id_info_pelatihan' => $id,
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
        $infoPelatihan = infoPelatihanModel::find($id);
        $vendorPelatihan = VendorPelatihanModel::find($infoPelatihan->id_vendor_pelatihan);
        $jenisPelatihan = JenisPelatihanModel::find($infoPelatihan->id_jenis_pelatihan_sertifikasi);
        $periode = PeriodeModel::find($infoPelatihan->id_periode);
        return view('infoPelatihan.show_ajax', ['infoPelatihan' => $infoPelatihan , 'vendorPelatihan' =>$vendorPelatihan , 'jenisPelatihan' => $jenisPelatihan , 'periode' => $periode]);
    }
    public function edit_ajax(string $id)
{
    $infoPelatihan = infoPelatihanModel::find($id);
    $vendorPelatihan = VendorPelatihanModel::all();
    $jenisPelatihan = JenisPelatihanModel::all();
    $periode = PeriodeModel::all();
    $bidangMinat = BidangMinatModel::all();
    $mataKuliah = mataKuliahModel::all();

    // Select the already associated bidang minat and mata kuliah
    $selectedBidangMinat = bidangMinatPelatihanModel::where('id_info_pelatihan', $id)->pluck('id_bidang_minat')->toArray();
    $selectedMataKuliah = mataKuliahPelatihanModel::where('id_info_pelatihan', $id)->pluck('id_mata_kuliah')->toArray();

    return view('infoPelatihan.edit_ajax', [
        'infoPelatihan' => $infoPelatihan,
        'vendorPelatihan' => $vendorPelatihan,
        'jenisPelatihan' => $jenisPelatihan,
        'periode' => $periode,
        'bidangMinat' => $bidangMinat,
        'mataKuliah' => $mataKuliah,
        'selectedBidangMinat' => $selectedBidangMinat,
        'selectedMataKuliah' => $selectedMataKuliah,
    ]);
}

    


    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_vendor_pelatihan'       => 'required|integer',
                'id_jenis_pelatihan_sertifikasi' => 'required|integer',
                'id_periode'                => 'required|integer',
                'lokasi_pelatihan'          => 'required|string|max:100',
                'nama_pelatihan'            => 'required|string|max:100',
                'level_pelatihan'           => 'required|string|max:100',
                'tanggal_mulai'             => 'required|date',
                'tanggal_selesai'           => 'required|date',
                'kuota_peserta'             => 'required|integer',
                'biaya'                     => 'required|numeric',
                'id_bidang_minat'           => 'nullable|array',
                'id_mata_kuliah'            => 'nullable|array',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            $infoPelatihan = infoPelatihanModel::find($id);
    
            if ($infoPelatihan) {
                $infoPelatihan->update($request->all());
    
                // Update bidang minat
                bidangMinatPelatihanModel::where('id_info_pelatihan', $id)->delete();
                if ($request->has('id_bidang_minat')) {
                    foreach ($request->id_bidang_minat as $idBidangMinat) {
                        bidangMinatPelatihanModel::create([
                            'id_info_pelatihan' => $id,
                            'id_bidang_minat'   => $idBidangMinat,
                        ]);
                    }
                }
    
                // Update mata kuliah
                mataKuliahPelatihanModel::where('id_info_pelatihan', $id)->delete();
                if ($request->has('id_mata_kuliah')) {
                    foreach ($request->id_mata_kuliah as $idMataKuliah) {
                        mataKuliahPelatihanModel::create([
                            'id_info_pelatihan' => $id,
                            'id_mata_kuliah'    => $idMataKuliah,
                        ]);
                    }
                }
    
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
    
        return redirect('/');
    }
    


    
    public function confirm_ajax(String $id){
        $infoPelatihan = infoPelatihanModel::find($id);

        return view('infoPelatihan.confirm_ajax', ['infoPelatihan' => $infoPelatihan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Cek apakah request berasal dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $infoPelatihan = infoPelatihanModel::find($id);
    
            if (!$infoPelatihan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
    
            try {
                // Gunakan transaksi database
                DB::beginTransaction();
    
                // Hapus data terkait di tabel bidang_minat_pelatihan
                DB::table('bidang_minat_pelatihan')->where('id_info_pelatihan', $id)->delete();
    
                // Hapus data terkait di tabel mata_kuliah_pelatihan
                DB::table('mata_kuliah_pelatihan')->where('id_info_pelatihan', $id)->delete();
    
                // Hapus info pelatihan
                $infoPelatihan->delete();
    
                // Commit transaksi
                DB::commit();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Data info pelatihan, bidang minat, dan mata kuliah terkait berhasil dihapus'
                ], 200);
    
            } catch (\Exception $e) {
                // Rollback jika terjadi error
                DB::rollBack();
    
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ], 500);
            }
        }
    
        // Jika bukan request AJAX, redirect ke halaman utama
        return redirect('/');
    }
     
    public function hapus_peserta($id)
    {
        try {
            pesertaPelatihanModel::where('id_info_pelatihan', $id)->delete();

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
