@extends('layoutsSuperAdmin.template')

@section('content')
<div class="container">
    <h1>Notifikasi</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($notifikasi->isEmpty())
        <p>Tidak ada notifikasi.</p>
    @else
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('notifikasi.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Tandai Semua Dibaca</button>
            </form>
        </div>
        <ul class="list-group">
            @foreach ($notifikasi as $notif)
                <li class="list-group-item {{ $notif->is_read ? 'text-muted' : '' }}">
                    <a href="{{ route('notifikasi.show', $notif->id_notifikasi) }}">
                        {{ $notif->pesan }}
                        <small class="float-end">{{ $notif->created_at->diffForHumans() }}</small>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
