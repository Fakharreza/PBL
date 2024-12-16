@extends('layoutsSuperAdmin.template')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Tab Navigation -->
        <ul class="nav nav-pills" id="tabNavigation">
            <li class="nav-item">
                <a class="nav-link active" id="sertifikasi-tab" data-bs-toggle="pill" href="#sertifikasi">Sertifikasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pelatihan-tab" data-bs-toggle="pill" href="#pelatihan">Pelatihan</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4">
            <!-- Sertifikasi Tab Content -->
            <div class="tab-pane fade show active" id="sertifikasi">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-bar"></i> Statistik Sertifikasi</h5>
                    </div>
                    <div class="card-body">
                        <div style="height: 400px;">
                            <canvas id="sertifikasi-chart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5><i class="fas fa-table"></i> List Pengguna dan Sertifikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Sertifikasi</th>
                                        <th>Periode</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listDosen as $index => $dosen)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $dosen->nama_pengguna }}</td>
                                            <td>{{ $dosen->nama_sertifikasi }}</td>
                                            <td>{{ $dosen->tahun_periode }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm"
                                                    onclick="showDetail('{{ route('statistikSertifikasi.show', $dosen->id_input_sertifikasi) }}')">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pelatihan Tab Content -->
            <div class="tab-pane fade" id="pelatihan">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-bar"></i> Statistik Pelatihan</h5>
                    </div>
                    <div class="card-body">
                        <div style="height: 400px;">
                            <canvas id="pelatihan-chart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5><i class="fas fa-table"></i> List Pengguna dan Pelatihan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Pelatihan</th>
                                        <th>Periode</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listPelatihan as $index => $pelatihan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pelatihan->nama_pengguna }}</td>
                                            <td>{{ $pelatihan->nama_pelatihan }}</td>
                                            <td>{{ $pelatihan->tahun_periode }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm"
                                                    onclick="showDetail('{{ route('statistikSertifikasi.detailPelatihan', $pelatihan->id_input_pelatihan) }}')">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Bootstrap Bundle JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            function showDetail(url) {
                // Ambil konten modal dari server melalui AJAX
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal mengambil data');
                        }
                        return response.text(); // Respons HTML
                    })
                    .then(html => {
                        // Hapus modal lama jika ada
                        const existingModal = document.getElementById('dynamicModal');
                        if (existingModal) {
                            existingModal.remove();
                        }

                        // Tambahkan modal baru ke body
                        const modalDiv = document.createElement('div');
                        modalDiv.id = 'dynamicModal';
                        modalDiv.innerHTML = html;
                        document.body.appendChild(modalDiv);

                        // Tampilkan modal baru
                        const modal = new bootstrap.Modal(modalDiv.querySelector('.modal'));
                        modal.show();

                        // Menambahkan event listener pada tombol close
                        modalDiv.querySelector('.btn-close').addEventListener('click', function() {
                            modal.hide(); // Menyembunyikan modal saat tombol close ditekan
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat detail. Silakan coba lagi.');
                    });
            }

            function showDetailPelatihan(id) {
                fetch(`/statistikSertifikasi/detail/${id}`)
                    .then(response => response.text())
                    .then(html => {
                        // Temukan kontainer modal atau buat baru
                        const modalContainer = document.getElementById('modalContainer');

                        if (!modalContainer) {
                            const newModalContainer = document.createElement('div');
                            newModalContainer.id = 'modalContainer';
                            document.body.appendChild(newModalContainer);
                        }

                        // Memasukkan HTML ke dalam kontainer modal
                        document.getElementById('modalContainer').innerHTML = html;

                        // Tampilkan modal
                        const modal = new bootstrap.Modal(document.getElementById('detailPelatihanModal'));
                        modal.show();

                        // Menambahkan event listener pada tombol close
                        modalDiv.querySelector('.btn-close').addEventListener('click', function() {
                            modal.hide(); // Menyembunyikan modal saat tombol close ditekan
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching detail:', error);
                        alert('Gagal memuat detail pelatihan. Silakan coba lagi.');
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const sertifikasiTahunData = @json($sertifikasiTahunData);
                const sertifikasiJumlahData = @json($sertifikasiJumlahData);
                const pelatihanTahunData = @json($pelatihanTahunData);
                const pelatihanJumlahData = @json($pelatihanJumlahData);

                // Sertifikasi Chart
                const sertifikasiCtx = document.getElementById('sertifikasi-chart').getContext('2d');
                const sertifikasiChart = new Chart(sertifikasiCtx, {
                    type: 'bar',
                    data: {
                        labels: sertifikasiTahunData,
                        datasets: [{
                            label: 'Jumlah Sertifikasi',
                            data: sertifikasiJumlahData,
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

                // Pelatihan Chart
                const pelatihanCtx = document.getElementById('pelatihan-chart').getContext('2d');
                const pelatihanChart = new Chart(pelatihanCtx, {
                    type: 'bar',
                    data: {
                        labels: pelatihanTahunData,
                        datasets: [{
                            label: 'Jumlah Pelatihan',
                            data: pelatihanJumlahData,
                            backgroundColor: 'rgba(255, 159, 64, 0.5)',
                            borderColor: 'rgba(255, 159, 64, 1)',
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
        </script>
    </div>
@endsection
