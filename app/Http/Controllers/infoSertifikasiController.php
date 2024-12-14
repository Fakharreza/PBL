<?php

namespace App\Http\Controllers;

use App\Models\BidangMinatModel;
use App\Models\bidangMinatSertifikasiModel;
use App\Models\infoSertifikasiModel;
use App\Models\JenisPelatihanModel;
use App\Models\mataKuliahModel;
use App\Models\mataKuliahSertifikasiModel;
use App\Models\penggunaModel;
use App\Models\PeriodeModel;
use App\Models\pesertaSertifikasiModel;
use App\Models\VendorSertifModel;
use DB;
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
        $bidangMinat = BidangMinatModel::all();
        $mataKuliah = mataKuliahModel::all();
        return view('infoSertifikasi.create_ajax')
        ->with('vendorSertifikasi',$vendorSertifikasi)
        ->with('jenisSertifikasi',$jenisSertifikasi)
        ->with('periode',$periode)
        ->with('bidangMinat',$bidangMinat)
        ->with('mataKuliah',$mataKuliah);
        
    }
    public function tambah_peserta(string $id)
{
    $id_info = $id;
    $infoSertifikasi = infoSertifikasiModel::find($id);

    // Pastikan info sertifikasi ditemukan
    if (!$infoSertifikasi) {
        return redirect()->back()->with('error', 'Info sertifikasi tidak ditemukan.');
    }

    // Ambil id_bidang_minat dari tabel bidang_minat_sertifikasi (asumsi nama tabelnya)
    $bidangMinatSertifikasi = bidangMinatSertifikasiModel::where('id_info_sertifikasi', $id)
                                ->pluck('id_bidang_minat')->toArray();

    // Ambil id_mata_kuliah dari tabel mata_kuliah_sertifikasi (asumsi nama tabelnya)
    $mataKuliahSertifikasi = mataKuliahSertifikasiModel::where('id_info_sertifikasi', $id)
                                 ->pluck('id_mata_kuliah')->toArray();

    // Menghitung jumlah peserta yang sudah terdaftar
    $jumlahPesertaTerdaftar = pesertaSertifikasiModel::where('id_info_sertifikasi', $id)->count();

    // Mengambil dosen yang sesuai dengan bidang minat ATAU mata kuliah sertifikasi
    $dosen = penggunaModel::select('pengguna.id_pengguna', 'pengguna.nama_pengguna')
        ->where('pengguna.id_jenis_pengguna', 3) // Filter hanya dosen
        ->where(function ($query) use ($bidangMinatSertifikasi, $mataKuliahSertifikasi) {
            if (!empty($bidangMinatSertifikasi)) {
                $query->whereIn('pengguna.id_pengguna', function ($subQuery) use ($bidangMinatSertifikasi) {
                    $subQuery->select('id_pengguna')
                        ->from('bidang_minat_dosen')  // Gantilah dengan nama tabel yang sesuai
                        ->whereIn('id_bidang_minat', $bidangMinatSertifikasi);
                });
            }

            if (!empty($mataKuliahSertifikasi)) {
                $query->orWhereIn('pengguna.id_pengguna', function ($subQuery) use ($mataKuliahSertifikasi) {
                    $subQuery->select('id_pengguna')
                        ->from('mata_kuliah_dosen')  // Gantilah dengan nama tabel yang sesuai
                        ->whereIn('id_mata_kuliah', $mataKuliahSertifikasi);
                });
            }
        })
        ->leftJoin('input_sertifikasi', 'pengguna.id_pengguna', '=', 'input_sertifikasi.id_pengguna')
        ->selectRaw('pengguna.id_pengguna, pengguna.nama_pengguna, COUNT(input_sertifikasi.id_pengguna) as jumlah_sertifikasi')
        ->groupBy('pengguna.id_pengguna', 'pengguna.nama_pengguna')
        ->orderBy('jumlah_sertifikasi', 'asc')
        ->get();

    // Mendapatkan peserta yang sudah terdaftar untuk sertifikasi ini
    $peserta = pesertaSertifikasiModel::where('id_info_sertifikasi', $id)
        ->pluck('id_pengguna')
        ->toArray();

    // Kirim status kuota penuh ke view
    $kuotaPenuh = $jumlahPesertaTerdaftar >= $infoSertifikasi->kuota_peserta;

    return view('infoSertifikasi.tambah_peserta', [
        'info' => $id_info,
        'infoSertifikasi' => $infoSertifikasi,
        'dosen' => $dosen,
        'peserta' => $peserta,
        'kuotaPenuh' => $kuotaPenuh, // Menyertakan informasi apakah kuota penuh
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
            'kuota_peserta'             => 'required|integer',
            'masa_berlaku'          => 'required|integer',
            'id_bidang_minat'           => 'nullable|array',
            'id_mata_kuliah'            => 'nullable|array',
        ];

       
            // Simpan data info sertifikasi
            $infoSertifikasi = infoSertifikasiModel::create($request->all());
    
            // Simpan bidang minat jika ada
            if ($request->has('id_bidang_minat')) {
                foreach ($request->id_bidang_minat as $idBidangMinat) {
                    bidangMinatSertifikasiModel::create([
                        'id_info_sertifikasi' => $infoSertifikasi->id_info_sertifikasi,
                        'id_bidang_minat'   => $idBidangMinat,
                    ]);
                }
            }
    
            // Simpan mata kuliah jika ada
            if ($request->has('id_mata_kuliah')) {
                foreach ($request->id_mata_kuliah as $idMataKuliah) {
                    mataKuliahSertifikasiModel::create([
                        'id_info_sertifikasi' => $infoSertifikasi->id_info_sertifikasi,
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
        $bidangMinat = BidangMinatModel::all();
        $mataKuliah = mataKuliahModel::all();

         // Select the already associated bidang minat and mata kuliah
        $selectedBidangMinat = bidangMinatSertifikasiModel::where('id_info_sertifikasi', $id)->pluck('id_bidang_minat')->toArray();
        $selectedMataKuliah = mataKuliahSertifikasiModel::where('id_info_sertifikasi', $id)->pluck('id_mata_kuliah')->toArray();

        return view('infoSertifikasi.edit_ajax', [
            'infoSertifikasi' => $infoSertifikasi,
            'vendorSertifikasi' => $vendorSertifikasi,
            'jenisSertifikasi' => $jenisSertifikasi,
            'periode' => $periode,
            'bidangMinat' => $bidangMinat,
            'mataKuliah' => $mataKuliah,
            'selectedBidangMinat' => $selectedBidangMinat,
            'selectedMataKuliah' => $selectedMataKuliah,
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
            'kuota_peserta'         => 'required|integer',
            'masa_berlaku'          => 'required|integer',
            'id_bidang_minat'       => 'nullable|array',
            'id_mata_kuliah'        => 'nullable|array',
        ];

        // Validasi input dari request
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        // Cari data sertifikasi yang akan diupdate
        $infoSertifikasi = infoSertifikasiModel::find($id);

        // Jika data ditemukan, lakukan update
        if ($infoSertifikasi) {
            // Update data informasi sertifikasi
            $infoSertifikasi->update($request->only([
                'id_vendor_sertifikasi',
                'id_jenis_pelatihan_sertifikasi',
                'id_periode',
                'nama_sertifikasi',
                'level_sertifikasi',
                'tanggal_mulai',
                'tanggal_selesai',
                'kuota_peserta',
                'masa_berlaku'
            ]));

            // Update bidang minat
            bidangMinatSertifikasiModel::where('id_info_sertifikasi', $id)->delete();
            if ($request->has('id_bidang_minat')) {
                foreach ($request->id_bidang_minat as $idBidangMinat) {
                    bidangMinatSertifikasiModel::create([
                        'id_info_sertifikasi' => $id,
                        'id_bidang_minat'     => $idBidangMinat,
                    ]);
                }
            }

            // Update mata kuliah
            mataKuliahSertifikasiModel::where('id_info_sertifikasi', $id)->delete();
            if ($request->has('id_mata_kuliah')) {
                foreach ($request->id_mata_kuliah as $idMataKuliah) {
                    mataKuliahSertifikasiModel::create([
                        'id_info_sertifikasi' => $id,
                        'id_mata_kuliah'      => $idMataKuliah,
                    ]);
                }
            }

            // Kirimkan respon sukses setelah update berhasil
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
            ]);
        } else {
            // Jika data tidak ditemukan, kirimkan pesan error
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }
    }

    // Jika bukan request AJAX, redirect ke halaman beranda
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
            $infoSertifikasi = infoSertifikasiModel::find($id);
    
            if (!$infoSertifikasi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
    
            try {
                // Gunakan transaksi database
                DB::beginTransaction();
    
                // Hapus data terkait di tabel bidang_minat_sertifikasi
                DB::table('bidang_minat_sertifikasi')->where('id_info_sertifikasi', $id)->delete();
    
                // Hapus data terkait di tabel mata_kuliah_sertifikasi
                DB::table('mata_kuliah_sertifikasi')->where('id_info_sertifikasi', $id)->delete();
    
                // Hapus info sertifikasi
                $infoSertifikasi->delete();
    
                // Commit transaksi
                DB::commit();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Data info sertifikasi, bidang minat, dan mata kuliah terkait berhasil dihapus'
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
