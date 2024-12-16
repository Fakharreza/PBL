@extends('layoutsSuperAdmin.template')

@section('content')
    <div class="container-fluid mt-4"> <!-- Mengubah container menjadi container-fluid -->
        <!-- Box Pelatihan -->
        <div class="card card-outline card-primary mb-4">
            <div class="card-header">
                <h3 class="card-title">Daftar Pelatihan</h3>
            </div>
            <div class="card-body">
                @forelse ($pelatihans as $pelatihan)
                    <div class="mb-3 p-3 border rounded bg-light">
                        <h5 class="mb-1">{{ $pelatihan->nama_pelatihan }}</h5>
                        <p>
                            <strong>Tanggal:</strong> {{ $pelatihan->tanggal_mulai }} - {{ $pelatihan->tanggal_selesai }}
                        </p>
                        <p>
                            <strong>Bidang Minat:</strong>
                        </p>
                        <ul>
                            @foreach ($pelatihan->bidang_minat as $bidang)
                                <li>{{ $bidang }}</li>
                            @endforeach
                        </ul>
                        <p>
                            <strong>Mata Kuliah:</strong>
                        </p>
                        <ul>
                            @foreach ($pelatihan->mata_kuliah as $mata)
                                <li>{{ $mata }}</li>
                            @endforeach
                        </ul>
                        <!-- Tombol Lihat Detail -->
                        <a href="{{ route('pelatihan.detail', $pelatihan->id_info_pelatihan) }}" class="btn btn-primary btn-sm mt-2">Lihat Detail</a>
                    </div>
                @empty
                    <p class="text-center">Tidak ada data pelatihan.</p>
                @endforelse
            </div>
        </div>

        <!-- Box Sertifikasi -->
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Daftar Sertifikasi</h3>
            </div>
            <div class="card-body">
                @forelse ($sertifikasis as $sertifikasi)
                    <div class="mb-3 p-3 border rounded bg-light">
                        <h5 class="mb-1">{{ $sertifikasi->nama_sertifikasi }}</h5>
                        <p>
                            <strong>Tanggal Mulai:</strong> {{ $sertifikasi->tanggal_mulai }}
                        </p>
                        <p>
                            <strong>Bidang Minat:</strong>
                        </p>
                        <ul>
                            @foreach ($sertifikasi->bidang_minat as $bidang)
                                <li>{{ $bidang }}</li>
                            @endforeach
                        </ul>
                        <p>
                            <strong>Mata Kuliah:</strong>
                        </p>
                        <ul>
                            @foreach ($sertifikasi->mata_kuliah as $mata)
                                <li>{{ $mata }}</li>
                            @endforeach
                        </ul>
                        <!-- Tombol Lihat Detail -->
                        <a href="{{ route('sertifikasi.detail', $sertifikasi->id_info_sertifikasi) }}" class="btn btn-success btn-sm mt-2">Lihat Detail</a>
                    </div>
                @empty
                    <p class="text-center">Tidak ada data sertifikasi.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
