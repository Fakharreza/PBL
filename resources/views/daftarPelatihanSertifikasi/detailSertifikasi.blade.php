@extends('layoutsSuperAdmin.template')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header">
                <h3><strong>{{  $sertifikasi->nama_sertifikasi }}</strong></h3>
            </div>
            <div class="card-body">
                <p><strong>Level Sertifikasi:</strong> {{ $sertifikasi->level_sertifikasi }}</p>
                <p><strong>Tanggal Mulai:</strong> {{ $sertifikasi->tanggal_mulai }}</p>
                <p><strong>Tanggal Selesai:</strong> {{ $sertifikasi->tanggal_selesai }}</p>
                <p><strong>Kuota Peserta:</strong> {{ $sertifikasi->kuota_peserta }}</p>
                <p><strong>Masa Berlaku:</strong> {{ $sertifikasi->masa_berlaku }}</p>
                <p><strong>Bidang Minat:</strong></p>
                <ul>
                    @foreach ($sertifikasi->bidang_minat as $bidang)
                        <li>{{ $bidang }}</li>
                    @endforeach
                </ul>
                <p><strong>Mata Kuliah:</strong></p>
                <ul>
                    @foreach ($sertifikasi->mata_kuliah as $mata)
                        <li>{{ $mata }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
