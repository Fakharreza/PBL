<?php

namespace App\Http\Controllers;

use App\Models\infoPelatihanModel;
use App\Models\infoSertifikasiModel;
use App\Models\pesertaPelatihanModel;
use App\Models\pesertaSertifikasiModel;
use App\Models\suratTugasModel;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class suratTugasController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Surat Tugas',
            'list' => ['Home', 'suratTugas']
        ];

        $page = (object) [
            'title' => 'Daftar Surat Tugas'
        ];

        $activeMenu = 'suratTugas'; // set menu yang sedang aktif

        return view('suratTugas.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
{
    // Get the authenticated user and load the jenisPengguna relation
    $user = auth()->user()->load('jenisPengguna');
    $role = $user->jenisPengguna->nama_jenis_pengguna;

    // Debugging untuk memastikan data role berhasil terambil
    \Log::info('Role pengguna: ' . $role);

    // Query untuk pelatihan dengan join ke surat_tugas
    $infoPelatihan = infoPelatihanModel::join('peserta_pelatihan', 'info_pelatihan.id_info_pelatihan', '=', 'peserta_pelatihan.id_info_pelatihan')
        ->leftJoin('surat_tugas', 'peserta_pelatihan.id_peserta_pelatihan', '=', 'surat_tugas.id_peserta_pelatihan')
        ->select(
            'info_pelatihan.id_info_pelatihan AS id',
            'info_pelatihan.nama_pelatihan AS nama',
            \DB::raw("'Pelatihan' AS jenis"),
            'surat_tugas.file_surat_tugas' // Tambahkan kolom ini untuk pengecekan
        )
        ->where('peserta_pelatihan.status_acc', 'setuju');

    if ($role == 'Dosen') {
        $infoPelatihan = $infoPelatihan->where('peserta_pelatihan.id_pengguna', $user->id_pengguna);
    }

    $infoPelatihan = $infoPelatihan->groupBy('info_pelatihan.id_info_pelatihan', 'info_pelatihan.nama_pelatihan', 'surat_tugas.file_surat_tugas');

    // Query untuk sertifikasi dengan join ke surat_tugas
    $infoSertifikasi = infoSertifikasiModel::join('peserta_sertifikasi', 'info_sertifikasi.id_info_sertifikasi', '=', 'peserta_sertifikasi.id_info_sertifikasi')
        ->leftJoin('surat_tugas', 'peserta_sertifikasi.id_peserta_sertifikasi', '=', 'surat_tugas.id_peserta_sertifikasi')
        ->select(
            'info_sertifikasi.id_info_sertifikasi AS id',
            'info_sertifikasi.nama_sertifikasi AS nama',
            \DB::raw("'Sertifikasi' AS jenis"),
            'surat_tugas.file_surat_tugas' // Tambahkan kolom ini untuk pengecekan
        )
        ->where('peserta_sertifikasi.status_acc', 'setuju');

    if ($role == 'Dosen') {
        $infoSertifikasi = $infoSertifikasi->where('peserta_sertifikasi.id_pengguna', $user->id_pengguna);
    }

    $infoSertifikasi = $infoSertifikasi->groupBy('info_sertifikasi.id_info_sertifikasi', 'info_sertifikasi.nama_sertifikasi', 'surat_tugas.file_surat_tugas');

    // Gabungkan kedua query menggunakan UNION
    $data = $infoPelatihan->union($infoSertifikasi);

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($row) use ($role) {
            $btn = '';

            // Jika pengguna adalah Admin, mereka bisa mengupload dan mendownload PDF
            if ($role == 'Admin') {
                $btn .= '<a href="' . url('/suratTugas/' . $row->jenis . '/' . $row->id . '/export_pdf') . '" target="_blank" class="btn btn-primary btn-sm">Download PDF</a>';
                $btn .= '<button onclick="openUploadForm(\'' . $row->jenis . '\', ' . $row->id . ')" class="btn btn-success btn-sm">Upload Surat Tugas</button>';
            }

            // Jika pengguna adalah Dosen, mereka bisa mendownload Surat Tugas yang sudah ditandatangani
            if ($role == 'Dosen') {
                if (!empty($row->file_surat_tugas)) {
                    $btn .= '<a href="' . url('storage/' . $row->file_surat_tugas) . '" class="btn btn-info btn-sm" target="_blank">Download Signed Surat Tugas</a>';
                } else {
                    $btn .= '<button class="btn btn-warning btn-sm" disabled>Waiting for Signature</button>';
                }
            }

            // Jika pengguna adalah Pimpinan, mereka hanya bisa mendownload template
            if ($role == 'Pimpinan') {
                $btn .= '<a href="' . url('/suratTugas/' . $row->jenis . '/' . $row->id . '/export_pdf') . '" target="_blank" class="btn btn-primary btn-sm">Download PDF</a>';
            }

            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}

    




    public function export_pdf($jenis, $id)
    {
        // Tentukan model dan relasi berdasarkan jenis
        $model = $jenis == 'Pelatihan' 
            ? pesertaPelatihanModel::with(['infoPelatihan.vendorPelatihan', 'infoPelatihan.periode', 'pengguna'])
            : pesertaSertifikasiModel::with(['infoSertifikasi.vendorSertifikasi', 'infoSertifikasi.periode', 'pengguna']);
    
        // Ambil data peserta berdasarkan id dan status
        $data = $model->where($jenis == 'Pelatihan' ? 'id_info_pelatihan' : 'id_info_sertifikasi', $id)
            ->where('status_acc', 'setuju')
            ->get();
    
        // Jika data tidak ditemukan
        if ($data->isEmpty()) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    
        // Ambil informasi kegiatan
        $info = $jenis == 'Pelatihan' ? $data->first()->infoPelatihan : $data->first()->infoSertifikasi;
        $nama_kegiatan = $info->nama_pelatihan ?? $info->nama_sertifikasi;
        $vendor = $info->vendorPelatihan->nama_vendor ?? $info->vendorSertifikasi->nama_vendor;
        $tanggal_mulai = $info->tanggal_mulai;
        $tanggal_selesai = $info->tanggal_selesai;
        $periode = $info->periode->nama_periode;
    
        // Buat nomor surat acak
        $nomor_surat = '26545/PK/' . rand(1000, 9999) . '/PA.00/' . rand(1000, 9999);
    
        // Siapkan data untuk view PDF
        $pdfData = [
            'nomor_surat' => $nomor_surat,
            'nama_kegiatan' => $nama_kegiatan,
            'jenis' => $jenis,
            'vendor' => $vendor,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'periode' => $periode,
            'peserta' => $data,
        ];
    
        // Load view PDF
        $pdf = Pdf::loadView('suratTugas.template_pdf', $pdfData);
        $pdf->setPaper('a4', 'portrait');
    
        // Return PDF stream
        return $pdf->stream('Surat_Tugas_' . $jenis . '_' . date('Ymd_His') . '.pdf');
    }
    
    public function upload_form($jenis, $id)
{
    // Menentukan jenis (pelatihan atau sertifikasi) dan mendapatkan data peserta terkait
    if ($jenis == 'Pelatihan') {
        $data = pesertaPelatihanModel::where('id_info_pelatihan', $id)
            ->where('status_acc', 'setuju')
            ->firstOrFail(); // Mengambil peserta berdasarkan id_info_pelatihan
        $nama_surat_tugas = $data->infoPelatihan->nama_pelatihan;
    } else if ($jenis == 'Sertifikasi') {
        $data = pesertaSertifikasiModel::where('id_info_sertifikasi', $id)
            ->where('status_acc', 'setuju')
            ->firstOrFail(); // Mengambil peserta berdasarkan id_info_sertifikasi
        $nama_surat_tugas = $data->infoSertifikasi->nama_sertifikasi;
    }

    return view('suratTugas.upload_form', ['jenis' => $jenis, 'id' => $id, 'nama_surat_tugas' => $nama_surat_tugas]);
}
public function upload_surat(Request $request, $jenis, $id)
{
    $validated = $request->validate([
        'file_surat_tugas' => 'required|mimes:pdf|max:2048',
    ]);

    if ($jenis == 'Pelatihan') {
        $pesertaPelatihan = pesertaPelatihanModel::where('id_info_pelatihan', $id)
            ->where('status_acc', 'setuju')
            ->get();
        $nama_surat_tugas = $pesertaPelatihan->first()->infoPelatihan->nama_pelatihan;
    } else {
        $pesertaSertifikasi = pesertaSertifikasiModel::where('id_info_sertifikasi', $id)
            ->where('status_acc', 'setuju')
            ->get();
        $nama_surat_tugas = $pesertaSertifikasi->first()->infoSertifikasi->nama_sertifikasi;
    }

    if ($request->hasFile('file_surat_tugas')) {
        $file = $request->file('file_surat_tugas');
        $filename = 'surat_tugas_' . $nama_surat_tugas . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('surat_tugas', $filename, 'public');

        // Save the Surat Tugas for each participant
        if ($jenis == 'Pelatihan') {
            foreach ($pesertaPelatihan as $peserta) {
                $suratTugasModel = new suratTugasModel();
                $suratTugasModel->id_peserta_pelatihan = $peserta->id_peserta_pelatihan;
                $suratTugasModel->nama_surat_tugas = $nama_surat_tugas;
                $suratTugasModel->file_surat_tugas = $path;
                $suratTugasModel->save();
            }
        } else {
            foreach ($pesertaSertifikasi as $peserta) {
                $suratTugasModel = new suratTugasModel();
                $suratTugasModel->id_peserta_sertifikasi = $peserta->id_peserta_sertifikasi;
                $suratTugasModel->nama_surat_tugas = $nama_surat_tugas;
                $suratTugasModel->file_surat_tugas = $path;
                $suratTugasModel->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Surat Tugas berhasil diupload']);
    }

    return response()->json(['success' => false, 'message' => 'Gagal mengupload surat tugas']);
}


}
