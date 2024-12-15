<?php

namespace App\Http\Controllers;

use App\Models\bidangMinatPelatihanModel;
use App\Models\bidangMinatSertifikasiModel;
use App\Models\infoPelatihanModel;
use App\Models\infoSertifikasiModel;
use App\Models\mataKuliahPelatihanModel;
use App\Models\mataKuliahSertifikasiModel;
use App\Models\penggunaModel;
use App\Models\pesertaPelatihanModel;
use App\Models\pesertaSertifikasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class accPesertaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Acc Peserta',
            'list' => ['Home', 'Acc Peserta']
        ];

        $page = (object) [
            'title' => 'Acc Peserta yang terdaftar'
        ];

        $activeMenu = 'accPeserta'; // Set active menu

        return view('accPeserta.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        // Get data from the infoPelatihan table with participants
        $infoPelatihan = infoPelatihanModel::join('peserta_pelatihan', 'info_pelatihan.id_info_pelatihan', '=', 'peserta_pelatihan.id_info_pelatihan')
            ->select('info_pelatihan.id_info_pelatihan AS id', 'info_pelatihan.nama_pelatihan AS nama', \DB::raw("'Pelatihan' AS jenis"))
            ->when($request->status === 'belum_disetujui', function ($query) {
                return $query->whereNull('peserta_pelatihan.status_acc');
            })
            ->when($request->status === 'disetujui', function ($query) {
                return $query->where('peserta_pelatihan.status_acc', 'setuju');
            })
            ->when($request->status === 'ditolak', function ($query) {
                return $query->where('peserta_pelatihan.status_acc', 'ditolak');
            })
            ->groupBy('info_pelatihan.id_info_pelatihan', 'info_pelatihan.nama_pelatihan');

        // Get data from the infoSertifikasi table with participants
        $infoSertifikasi = infoSertifikasiModel::join('peserta_sertifikasi', 'info_sertifikasi.id_info_sertifikasi', '=', 'peserta_sertifikasi.id_info_sertifikasi')
            ->select('info_sertifikasi.id_info_sertifikasi AS id', 'info_sertifikasi.nama_sertifikasi AS nama', \DB::raw("'Sertifikasi' AS jenis"))
            ->when($request->status === 'belum_disetujui', function ($query) {
                return $query->whereNull('peserta_sertifikasi.status_acc');
            })
            ->when($request->status === 'disetujui', function ($query) {
                return $query->where('peserta_sertifikasi.status_acc', 'setuju');
            })
            ->when($request->status === 'ditolak', function ($query) {
                return $query->where('peserta_sertifikasi.status_acc', 'ditolak');
            })
            ->groupBy('info_sertifikasi.id_info_sertifikasi', 'info_sertifikasi.nama_sertifikasi');

        // Combine both queries using UNION
        $data = $infoPelatihan->union($infoSertifikasi);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) use ($request) {
                $btn = '<button onclick="modalAction(\'' . url('/accPeserta/' . $row->id . '/tampil_peserta') . '\')" class="btn btn-success btn-sm">Lihat Peserta</button>';

                // Tombol "Ubah Peserta" hanya muncul jika status = 'belum_disetujui'
                if ($request->status === 'belum_disetujui') {
                    $btn .= ' <button onclick="modalAction(\'' . url('/accPeserta/' . $row->id . '/ubah_peserta?jenis=' . $row->jenis) . '\')" class="btn btn-warning btn-sm">Ubah Peserta</button>';
                }

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    public function tampilPeserta($id)
    {
        $pesertaPelatihan = pesertaPelatihanModel::where('id_info_pelatihan', $id)
            ->with('pengguna')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'pelatihan';
                return $item;
            });

        $pesertaSertifikasi = pesertaSertifikasiModel::where('id_info_sertifikasi', $id)
            ->with('pengguna')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'sertifikasi';
                return $item;
            });

        $peserta = $pesertaPelatihan->merge($pesertaSertifikasi);
        $jenis = $pesertaPelatihan->isNotEmpty() ? 'pelatihan' : 'sertifikasi';

        return view('accPeserta.modal_peserta', compact('peserta', 'id', 'jenis'));
    }

    public function ubahPeserta(string $id)
    {
        // Get info based on training or certification type
        $infoPelatihan = infoPelatihanModel::find($id);
        $infoSertifikasi = infoSertifikasiModel::find($id);

        if ($infoPelatihan) {
            $info = $infoPelatihan;
            $jenis = 'pelatihan';

            // Get fields related to training
            $bidangMinat = bidangMinatPelatihanModel::where('id_info_pelatihan', $id)->pluck('id_bidang_minat')->toArray();
            $mataKuliah = mataKuliahPelatihanModel::where('id_info_pelatihan', $id)->pluck('id_mata_kuliah')->toArray();
            $jumlahPesertaTerdaftar = pesertaPelatihanModel::where('id_info_pelatihan', $id)->count();

            // Get relevant lecturers (dosen)
            $dosen = penggunaModel::select('pengguna.id_pengguna', 'pengguna.nama_pengguna')
                ->where('pengguna.id_jenis_pengguna', 3) // Filter only lecturers
                ->where(function ($query) use ($bidangMinat, $mataKuliah) {
                    if (!empty($bidangMinat)) {
                        $query->whereIn('pengguna.id_pengguna', function ($subQuery) use ($bidangMinat) {
                            $subQuery->select('id_pengguna')->from('bidang_minat_dosen')->whereIn('id_bidang_minat', $bidangMinat);
                        });
                    }
                    if (!empty($mataKuliah)) {
                        $query->orWhereIn('pengguna.id_pengguna', function ($subQuery) use ($mataKuliah) {
                            $subQuery->select('id_pengguna')->from('mata_kuliah_dosen')->whereIn('id_mata_kuliah', $mataKuliah);
                        });
                    }
                })
                ->leftJoin('input_pelatihan', 'pengguna.id_pengguna', '=', 'input_pelatihan.id_pengguna')
                ->selectRaw('pengguna.id_pengguna, pengguna.nama_pengguna, COUNT(input_pelatihan.id_pengguna) as jumlah_pelatihan')
                ->groupBy('pengguna.id_pengguna', 'pengguna.nama_pengguna')
                ->orderBy('jumlah_pelatihan', 'asc')
                ->get();

            // Get participants
            $peserta = pesertaPelatihanModel::where('id_info_pelatihan', $id)->pluck('id_pengguna')->toArray();
        } elseif ($infoSertifikasi) {
            $info = $infoSertifikasi;
            $jenis = 'sertifikasi';

            // Get fields related to certification
            $bidangMinat = bidangMinatSertifikasiModel::where('id_info_sertifikasi', $id)->pluck('id_bidang_minat')->toArray();
            $mataKuliah = mataKuliahSertifikasiModel::where('id_info_sertifikasi', $id)->pluck('id_mata_kuliah')->toArray();
            $jumlahPesertaTerdaftar = pesertaSertifikasiModel::where('id_info_sertifikasi', $id)->count();

            // Get relevant lecturers (dosen)
            $dosen = penggunaModel::select('pengguna.id_pengguna', 'pengguna.nama_pengguna')
                ->where('pengguna.id_jenis_pengguna', 3) // Filter only lecturers
                ->where(function ($query) use ($bidangMinat, $mataKuliah) {
                    if (!empty($bidangMinat)) {
                        $query->whereIn('pengguna.id_pengguna', function ($subQuery) use ($bidangMinat) {
                            $subQuery->select('id_pengguna')->from('bidang_minat_dosen')->whereIn('id_bidang_minat', $bidangMinat);
                        });
                    }
                    if (!empty($mataKuliah)) {
                        $query->orWhereIn('pengguna.id_pengguna', function ($subQuery) use ($mataKuliah) {
                            $subQuery->select('id_pengguna')->from('mata_kuliah_dosen')->whereIn('id_mata_kuliah', $mataKuliah);
                        });
                    }
                })
                ->leftJoin('input_sertifikasi', 'pengguna.id_pengguna', '=', 'input_sertifikasi.id_pengguna')
                ->selectRaw('pengguna.id_pengguna, pengguna.nama_pengguna, COUNT(input_sertifikasi.id_pengguna) as jumlah_sertifikasi')
                ->groupBy('pengguna.id_pengguna', 'pengguna.nama_pengguna')
                ->orderBy('jumlah_sertifikasi', 'asc')
                ->get();

            // Get participants
            $peserta = pesertaSertifikasiModel::where('id_info_sertifikasi', $id)->pluck('id_pengguna')->toArray();
        } else {
            return redirect()->back()->with('error', 'Info pelatihan atau sertifikasi tidak ditemukan.');
        }

        $kuotaPenuh = $jumlahPesertaTerdaftar >= $info->kuota_peserta;

        return view('accPeserta.edit_form', compact('info', 'jenis', 'dosen', 'peserta', 'kuotaPenuh', 'infoPelatihan', 'infoSertifikasi'));
    }

    public function store_peserta_pelatihan(Request $request, string $id)
    {
        // Hapus peserta lama
        pesertaPelatihanModel::where('id_info_pelatihan', $id)->delete();

        // Validasi input
        $request->validate([
            'id_pengguna' => 'required|array',
        ]);

        // Menambahkan peserta baru
        foreach ($request->id_pengguna as $idPengguna) {
            pesertaPelatihanModel::create([
                'id_info_pelatihan' => $id,
                'id_pengguna' => $idPengguna,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Peserta pelatihan berhasil ditambahkan.'
        ]);
    }

    public function store_peserta_sertifikasi(Request $request, string $id)
    {
        // Hapus peserta lama
        pesertaSertifikasiModel::where('id_info_sertifikasi', $id)->delete();

        // Validasi input
        $request->validate([
            'id_pengguna' => 'required|array',
        ]);

        // Menambahkan peserta baru
        foreach ($request->id_pengguna as $idPengguna) {
            pesertaSertifikasiModel::create([
                'id_info_sertifikasi' => $id,
                'id_pengguna' => $idPengguna,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Peserta sertifikasi berhasil ditambahkan.'
        ]);
    }

    public function ubahStatus(Request $request, $id)
    {
        $jenis = $request->jenis;
        $status = $request->status;

        // Tentukan model peserta berdasarkan jenis
        $modelPeserta = $jenis === 'pelatihan' ? pesertaPelatihanModel::class : pesertaSertifikasiModel::class;

        // Validasi status
        if (!in_array($status, ['setuju', 'ditolak'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid.'
            ]);
        }

        // Perbarui status peserta
        $peserta = $modelPeserta::where($jenis === 'pelatihan' ? 'id_info_pelatihan' : 'id_info_sertifikasi', $id)
            ->update(['status_acc' => $status]);

        if ($peserta) {
            return response()->json([
                'success' => true,
                'message' => 'Status peserta berhasil diperbarui.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status peserta.'
            ]);
        }
    }


}
