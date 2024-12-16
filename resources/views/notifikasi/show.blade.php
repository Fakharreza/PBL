@extends('layoutsSuperAdmin.template')

@section('content')
<div class="container">
    <h1>Detail Notifikasi</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pesan</h5>
            <p class="card-text">{{ $notifikasi->pesan }}</p>
            <small class="text-muted">{{ $notifikasi->created_at->diffForHumans() }}</small>

            <a href="{{ route('notifikasi.index') }}" class="btn btn-primary">Kembali ke Daftar Notifikasi</a>
        </div>
    </div>
</div>
@endsection
