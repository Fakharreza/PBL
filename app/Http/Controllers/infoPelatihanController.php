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
        $infoPelatihan = infoPelatihanModel::select('id_info_pelatihan','id_vendor_pelatihan','id_jenis_pelatihan','id_periode','lokasi_pelatihan','nama_pelatihan','tanggal_mulai','tanggal_selesai','kuota_peserta','biaya');
        return DataTables::of($infoPelatihan)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($infoPelatihan) { // menambahkan kojenisPelatihanom aksi 
                $btn  = '<button onclick="modalAction(\'' . url('/infoPelatihan/' . $infoPelatihan->id_info_pelatihan . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/infoPelatihan/' . $infoPelatihan->id_info_pelatihan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/infoPelatihan/' . $infoPelatihan->id_info_pelatihan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
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
    public function show_ajax(string $id)
    {
        $infoPelatihan = infoPelatihanModel::find($id);
        $vendorPelatihan = VendorPelatihanModel::find($infoPelatihan->id_vendor_pelatihan);
        $jenisPelatihan = JenisPelatihanModel::find($infoPelatihan->id_jenis_pelatihan);
        $periode = PeriodeModel::find($infoPelatihan->id_periode);
        return view('infoPelatihan.show_ajax', ['infoPelatihan' => $infoPelatihan , 'vendorPelatihan' =>$vendorPelatihan , 'jenisPelatihan' => $jenisPelatihan , 'periode' => $periode]);
    }
    public function edit_ajax(string $id)
    {
        $infoPelatihan = infoPelatihanModel::find($id);
        $vendorPelatihan = VendorPelatihanModel::all();
        $jenisPelatihan = JenisPelatihanModel::all();
        $periode = PeriodeModel::all();
        
        // Ambil pengguna yang memiliki id_jenis_pengguna = 3 (dosen)
        $dosen = penggunaModel::where('id_jenis_pengguna', 3)->get();
        
        $peserta = pesertaPelatihanModel::where('id_info_pelatihan', $id)
            ->pluck('id_pengguna')
            ->toArray();
    
        return view('infoPelatihan.edit_ajax', [
            'infoPelatihan' => $infoPelatihan,
            'vendorPelatihan' => $vendorPelatihan,
            'jenisPelatihan' => $jenisPelatihan,
            'periode' => $periode,
            'dosen' => $dosen,
            'peserta' => $peserta,
        ]);
    }
    


public function update_ajax(Request $request, string $id)
{
    // Validasi data input
    $request->validate([
        'id_vendor_pelatihan' => 'required|integer',
        'id_jenis_pelatihan'  => 'required|integer',
        'id_periode'          => 'required|integer',
        'id_pengguna'         => 'required|array', // Validasi array pengguna
        'lokasi_pelatihan'    => 'required|string|max:100',
        'nama_pelatihan'      => 'required|string|max:100',
        'tanggal_mulai'       => 'required|date',
        'tanggal_selesai'     => 'required|date',
        'kuota_peserta'       => 'required|integer',
        'biaya'               => 'required|numeric',
    ]);

    // Update info pelatihan
    $infoPelatihan = infoPelatihanModel::find($id);
    $infoPelatihan->update([
        'id_vendor_pelatihan' => $request->id_vendor_pelatihan,
        'id_jenis_pelatihan'  => $request->id_jenis_pelatihan,
        'id_periode'          => $request->id_periode,
        'lokasi_pelatihan'    => $request->lokasi_pelatihan,
        'nama_pelatihan'      => $request->nama_pelatihan,
        'tanggal_mulai'       => $request->tanggal_mulai,
        'tanggal_selesai'     => $request->tanggal_selesai,
        'kuota_peserta'       => $request->kuota_peserta,
        'biaya'               => $request->biaya,
    ]);

    // Hapus peserta lama
    pesertaPelatihanModel::where('id_info_pelatihan', $id)->delete();

    // Tambahkan peserta baru
    $idPenggunaList = $request->id_pengguna;
    foreach ($idPenggunaList as $idPengguna) {
        // Pastikan pengguna adalah dosen (id_jenis_pengguna = 3)
        $pengguna = penggunaModel::where('id_pengguna', $idPengguna)
            ->where('id_jenis_pengguna', 3)
            ->first();

        if ($pengguna) {
            pesertaPelatihanModel::create([
                'id_info_pelatihan' => $id,
                'id_pengguna'       => $idPengguna,
            ]);
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil diperbarui dan peserta pelatihan disimpan.'
    ]);
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
}
