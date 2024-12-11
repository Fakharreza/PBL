<?php

namespace App\Http\Controllers;

use App\Models\infoPelatihanModel;
use App\Models\JenisPelatihanModel;
use App\Models\penggunaModel;
use App\Models\PeriodeModel;
use App\Models\pesertaPelatihanModel;
use App\Models\VendorPelatihanModel;
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
        return view('infoPelatihan.create_ajax')
        ->with('vendorPelatihan',$vendorPelatihan)
        ->with('jenisPelatihan',$jenisPelatihan)
        ->with('periode',$periode);
        
    }
    public function tambah_peserta(string $id)
    {
        $id_info = $id;
        $infoPelatihan = infoPelatihanModel::find($id);

        // Menghitung jumlah pelatihan dari tabel input_pelatihan
        $dosen = penggunaModel::select('pengguna.*')
            ->leftJoin('input_pelatihan', 'pengguna.id_pengguna', '=', 'input_pelatihan.id_pengguna')
            ->where('pengguna.id_jenis_pengguna', 3) // Filter untuk hanya dosen
            ->selectRaw('COUNT(input_pelatihan.id_pengguna) as jumlah_pelatihan')
            ->groupBy('pengguna.id_pengguna', 'pengguna.nama_pengguna') // Sesuaikan dengan kolom yang digunakan
            ->orderBy('jumlah_pelatihan', 'asc') // Urutkan dari dosen paling sedikit pelatihan ke paling banyak
            ->get();

        // Mendapatkan peserta yang sudah terdaftar untuk pelatihan ini
        $peserta = pesertaPelatihanModel::where('id_info_pelatihan', $id)
            ->pluck('id_pengguna')
            ->toArray();

        return view('infoPelatihan.tambah_peserta', [
            'info' => $id_info,
            'infoPelatihan' => $infoPelatihan,
            'dosen' => $dosen,
            'peserta' => $peserta,
        ]);
    }



    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_vendor_pelatihan'       => 'required|integer',
                'id_jenis_pelatihan'       => 'required|integer',
                'id_periode'       => 'required|integer',
                'lokasi_pelatihan'    => 'required|string|max:100',
                'nama_pelatihan'    => 'required|string|max:100',
                'level_pelatihan'    => 'required|string|max:100',
                'tanggal_mulai'    => 'required|date',
                'tanggal_selesai'    => 'required|date',
                'kuota_peserta'    => 'required|integer',
                'biaya'    => 'required|numeric',

            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false, // response status, false: error/gagal, true: berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(), // pesan error validasi
                ]);
            }
            infoPelatihanModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data Info berhasil disimpan'
            ]);
        }
        redirect('/');
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
    
        return view('infoPelatihan.edit_ajax', [
            'infoPelatihan' => $infoPelatihan,
            'vendorPelatihan' => $vendorPelatihan,
            'jenisPelatihan' => $jenisPelatihan,
            'periode' => $periode,
        ]);
    }
    


    public function update_ajax(Request $request, string $id)
    {
        // Validasi data input
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_vendor_pelatihan' => 'required|integer',
                'id_jenis_pelatihan_sertifikasi'  => 'required|integer',
                'id_periode'          => 'required|integer',
                'lokasi_pelatihan'    => 'required|string|max:100',
                'nama_pelatihan'      => 'required|string|max:100',
                'level_pelatihan'    => 'required|string|max:100',
                'tanggal_mulai'       => 'required|date',
                'tanggal_selesai'     => 'required|date',
                'kuota_peserta'       => 'required|integer',
                'biaya'               => 'required|numeric',
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
            $check = infoPelatihanModel::find($id);
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
        $infoPelatihan = infoPelatihanModel::find($id);

        return view('infoPelatihan.confirm_ajax', ['infoPelatihan' => $infoPelatihan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $infoPelatihan = infoPelatihanModel::find($id);
            if($infoPelatihan){
                $infoPelatihan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
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
