@extends('layoutsSuperAdmin.template')

@section('content')
    <div class="container-fluid mt-4"> <!-- Mengubah container menjadi container-fluid -->
        <div class="card">
            <div class="card-header">
                <h3><strong>{{ $pelatihan->nama_pelatihan }}</strong></h3>
            </div>
            <div class="card-body">
                <p><strong>Lokasi Pelatihan:</strong> {{ $pelatihan->lokasi_pelatihan }}</p>
                <p><strong>Level Pelatihan:</strong> {{ $pelatihan->level_pelatihan }}</p>
                <p><strong>Tanggal Mulai:</strong> {{ $pelatihan->tanggal_mulai }}</p>
                <p><strong>Tanggal Selesai:</strong> {{ $pelatihan->tanggal_selesai }}</p>
                <p><strong>Kuota Peserta:</strong> {{ $pelatihan->kuota_peserta }}</p>
                <p><strong>Biaya:</strong> {{ $pelatihan->biaya }}</p>
                <p><strong>Bidang Minat:</strong></p>
                <ul>
                    @foreach ($pelatihan->bidang_minat as $bidang)
                        <li>{{ $bidang }}</li>
                    @endforeach
                </ul>
                <p><strong>Mata Kuliah:</strong></p>
                <ul>
                    @foreach ($pelatihan->mata_kuliah as $mata)
                        <li>{{ $mata }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
