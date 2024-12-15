@extends('layoutsSuperAdmin.template')

@section('content')
    @php
        use Illuminate\Support\Facades\DB;

        // Ambil jumlah total pengguna
        $totalUsers = DB::table('pengguna')->count();

        // Ambil jumlah level pengguna (jenis pengguna)
        $totalLevels = DB::table('pengguna')->distinct('id_jenis_pengguna')->count('id_jenis_pengguna');

        // Ambil jumlah pengguna berdasarkan role
        $superAdminCount = DB::table('pengguna')->where('id_jenis_pengguna', 1)->count();
        $adminCount = DB::table('pengguna')->where('id_jenis_pengguna', 2)->count();
        $dosenCount = DB::table('pengguna')->where('id_jenis_pengguna', 3)->count();
        $pimpinanCount = DB::table('pengguna')->where('id_jenis_pengguna', 4)->count();

        // Periksa apakah user yang login adalah superadmin
        $isSuperAdmin = auth()->user()->id_jenis_pengguna == 1; // 1 = Superadmin
        $isAdmin = auth()->user()->id_jenis_pengguna == 2; // 2 = Admin
        $isDosen = auth()->user()->id_jenis_pengguna == 3; // 3 = Dosen
        $isPimpinan = auth()->user()->id_jenis_pengguna == 4; // 4 = Pimpinan

        // $userId = auth()->user()->id;

        // Ambil jumlah data terkait pelatihan dan sertifikasi untuk dosen
        $inputPelatihanCount = DB::table('input_pelatihan')
            ->where('id_pengguna', auth()->user()->id_pengguna)
            ->count();
        $inputSertifikasiCount = DB::table('input_sertifikasi')
            ->where('id_pengguna', auth()->user()->id_pengguna)
            ->count();
        $infoPelatihan = DB::table('info_pelatihan')->count();
        $infoSertifikasi = DB::table('info_sertifikasi')->count();

        $totalInputPelatihan = DB::table('input_pelatihan')->count();
        $totalInputSertifikasi = DB::table('input_sertifikasi')->count();

        $pelatihanPerTahun = DB::table('input_pelatihan')
    ->join('periode', 'input_pelatihan.id_periode', '=', 'periode.id_periode')
    ->select(DB::raw('periode.tahun_periode as tahun'), DB::raw('count(*) as jumlah'))
    ->groupBy('periode.tahun_periode')
    ->orderBy('tahun', 'asc')
    ->get();

$sertifikasiPerTahun = DB::table('input_sertifikasi')
    ->join('periode', 'input_sertifikasi.id_periode', '=', 'periode.id_periode')
    ->select(DB::raw('periode.tahun_periode as tahun'), DB::raw('count(*) as jumlah'))
    ->groupBy('periode.tahun_periode')
    ->orderBy('tahun', 'asc')
    ->get();

// Siapkan data untuk chart
$tahunPelatihan = $pelatihanPerTahun->pluck('tahun');
$jumlahPelatihan = $pelatihanPerTahun->pluck('jumlah');

$tahunSertifikasi = $sertifikasiPerTahun->pluck('tahun');
$jumlahSertifikasi = $sertifikasiPerTahun->pluck('jumlah');

// Query untuk mendapatkan jumlah pelatihan per tahun berdasarkan pengguna yang login
$pelatihanPerTahun2 = DB::table('input_pelatihan')
    ->join('periode', 'input_pelatihan.id_periode', '=', 'periode.id_periode')
    ->select(DB::raw('periode.tahun_periode as tahun'), DB::raw('count(*) as jumlah'))
    ->where('id_pengguna', auth()->user()->id_pengguna) // Filter berdasarkan pengguna yang login
    ->groupBy('periode.tahun_periode')
    ->orderBy('tahun', 'asc')
    ->get();

// Tambahkan atribut 'jenis' untuk membedakan data pelatihan
$pelatihanPerTahun2 = $pelatihanPerTahun2->map(function ($item) {
    $item->jenis = 'Pelatihan';
    return $item;
});

// Query untuk mendapatkan jumlah sertifikasi per tahun berdasarkan pengguna yang login
$sertifikasiPerTahun2 = DB::table('input_sertifikasi')
    ->join('periode', 'input_sertifikasi.id_periode', '=', 'periode.id_periode')
    ->select(DB::raw('periode.tahun_periode as tahun'), DB::raw('count(*) as jumlah'))
    ->where('id_pengguna', auth()->user()->id_pengguna) // Filter berdasarkan pengguna yang login
    ->groupBy('periode.tahun_periode')
    ->orderBy('tahun', 'asc')
    ->get();

// Tambahkan atribut 'jenis' untuk membedakan data sertifikasi
$sertifikasiPerTahun2 = $sertifikasiPerTahun2->map(function ($item) {
    $item->jenis = 'Sertifikasi';
    return $item;
});

// Menggabungkan data pelatihan dan sertifikasi dalam satu koleksi
$combinedData = $pelatihanPerTahun2->merge($sertifikasiPerTahun2);

// Siapkan data untuk chart
$tahunData = $combinedData->pluck('tahun')->unique()->sort()->values(); // Ambil tahun unik dan urutkan

// Data pelatihan berdasarkan tahun
$pelatihanData = $tahunData->map(function ($tahun) use ($combinedData) {
    return $combinedData->where('jenis', 'Pelatihan')->where('tahun', $tahun)->sum('jumlah');
});

// Data sertifikasi berdasarkan tahun
$sertifikasiData = $tahunData->map(function ($tahun) use ($combinedData) {
    return $combinedData->where('jenis', 'Sertifikasi')->where('tahun', $tahun)->sum('jumlah');
});


    @endphp

    {{-- Tampilan untuk SuperAdmin --}}
    @if ($isSuperAdmin)
        <div class="row">
            <!-- Box: Total Users -->
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalUsers }}</h3>
                        <p>Jumlah Pengguna</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- Box: Total Levels -->
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalLevels }}</h3>
                        <p>Jumlah Jenis Pengguna</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- Box: Total Dosen -->
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $dosenCount }}</h3>
                        <p>Jumlah Akun Dosen</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-university"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Jumlah Pengguna per Role</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">{{ $totalUsers }}</span>
                            <span>Data Pengguna</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> Updated
                            </span>
                        </p>
                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <canvas id="role-chart" height="300"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                            <i class="fas fa-square text-primary"></i> SuperAdmin
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-square text-success"></i> Admin
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-square text-warning"></i> Dosen
                        </span>
                        <span>
                            <i class="fas fa-square text-danger"></i> Pimpinan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Tampilan untuk Dosen --}}
    @if ($isDosen)
        <div class="row">
            <!-- Box: Jumlah Input Pelatihan -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $inputPelatihanCount }}</h3>
                        <p>Jumlah Input Pelatihan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-albums"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Box: Jumlah Input Sertifikasi -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $inputSertifikasiCount }}</h3>
                        <p>Jumlah Input Sertifikasi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-clipboard"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Box: Jumlah Pelatihan (Warna Hijau) -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $infoPelatihan }}</h3>
                        <p>Jumlah Info Pelatihan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-school"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Box: Jumlah Sertifikasi (Warna Merah) -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $infoSertifikasi }}</h3>
                        <p>Jumlah Info Sertifikasi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-rocket"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Jumlah Pelatihan dan Sertifikasi per Tahun</h3>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="combined-chart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($isPimpinan || $isAdmin)
        <div class="row">

            <div class="col-lg-6 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalInputPelatihan }}</h3>
                        <p>Total Dosen Input Pelatihan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-albums"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <div class="col-lg-6 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalInputSertifikasi }}</h3>
                        <p>Total Dosen Input Sertifikasi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-clipboard"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Jumlah Input Pelatihan per Tahun</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $totalUsers }}</span>
                                <span>Data Pengguna</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> Updated
                                </span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="pelatihan-chart" height="300"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Jumlah Input Sertifikasi per Tahun</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $totalUsers }}</span>
                                <span>Data Pengguna</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> Updated
                                </span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="sertifikasi-chart" height="300"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Log data pengguna per role
        const superAdminCount = {{ $superAdminCount }};
        const adminCount = {{ $adminCount }};
        const dosenCount = {{ $dosenCount }};
        const pimpinanCount = {{ $pimpinanCount }};

        const ctx = document.getElementById('role-chart').getContext('2d');
        const roleChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['SuperAdmin', 'Admin', 'Dosen', 'Pimpinan'],
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: [superAdminCount, adminCount, dosenCount, pimpinanCount],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)', // SuperAdmin
                        'rgba(75, 192, 192, 0.5)', // Admin
                        'rgba(255, 206, 86, 0.5)', // Dosen
                        'rgba(255, 99, 132, 0.5)' // Pimpinan
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)', // SuperAdmin
                        'rgba(75, 192, 192, 1)', // Admin
                        'rgba(255, 206, 86, 1)', // Dosen
                        'rgba(255, 99, 132, 1)' // Pimpinan
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const tahunData = {{ json_encode($tahunData->toArray()) }}; // Tahun data dari tabel periode
        const pelatihanData = {{ json_encode($pelatihanData->toArray()) }}; // Data pelatihan
        const sertifikasiData = {{ json_encode($sertifikasiData->toArray()) }}; // Data sertifikasi

        const ctx = document.getElementById('combined-chart').getContext('2d');
        const combinedChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tahunData, // Tahun dari tabel periode
                datasets: [{
                        label: 'Pelatihan',
                        data: pelatihanData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sertifikasi',
                        data: sertifikasiData,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tahun'
                        }
                    }
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const tahunPelatihan = @json($tahunPelatihan); // Tahun pelatihan
        const jumlahPelatihan = @json($jumlahPelatihan); // Jumlah pelatihan

        const ctx = document.getElementById('pelatihan-chart').getContext('2d');
        const pelatihanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tahunPelatihan, // Tahun dari tabel periode
                datasets: [{
                    label: 'Jumlah Input Pelatihan',
                    data: jumlahPelatihan,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pelatihan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tahun'
                        }
                    }
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const tahunSertifikasi = @json($tahunSertifikasi); // Tahun sertifikasi
        const jumlahSertifikasi = @json($jumlahSertifikasi); // Jumlah sertifikasi

        const ctx = document.getElementById('sertifikasi-chart').getContext('2d');
        const sertifikasiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tahunSertifikasi, // Tahun dari tabel periode
                datasets: [{
                    label: 'Jumlah Input Sertifikasi',
                    data: jumlahSertifikasi,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Sertifikasi'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tahun'
                        }
                    }
                }
            }
        });
    });
</script>
