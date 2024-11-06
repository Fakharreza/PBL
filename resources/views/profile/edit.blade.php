@extends('layoutsSuperAdmin.template')

@section('content')
<div class="container mt-3 p-3 bg-light rounded">
    <h4>Edit Profile</h4>
    <div class="card p-4">
        <!-- Tampilkan pesan sukses jika ada -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form untuk Edit Profile -->
        <form method="POST" action="{{ url('/profile/'. $pengguna->id_pengguna) }}" class="formhorizontal">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-3">
                <label for="nama_pengguna">Nama Pengguna</label>
                <input type="text" name="nama_pengguna" class="form-control @error('nama_pengguna') is-invalid @enderror" 
                       value="{{ old('nama_pengguna', $pengguna->nama_pengguna) }}">
                @error('nama_pengguna')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $pengguna->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="nip">NIP</label>
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" 
                       value="{{ old('nip', $pengguna->nip) }}">
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ url('profile') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection