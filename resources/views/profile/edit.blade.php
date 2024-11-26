@extends('layoutsSuperAdmin.template')

@section('content')
<div class="container mt-5 p-4 bg-white rounded shadow-sm" style="max-width: 600px;">
    <!-- Judul Halaman -->
    <div class="bg-primary text-white p-2 rounded-top text-center">
        <h5 class="mb-0">Edit Profile</h5>
    </div>

    <!-- Card Form -->
    <div class="card p-4 border-0">
        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Edit Profile -->
        <form method="POST" action="{{ url('/profile/'. $pengguna->id_pengguna) }}">
            @csrf
            @method('PUT')
            
            <!-- Input Nama Pengguna -->
            <div class="form-group mb-3">
                <label for="nama_pengguna" class="font-weight-bold">Nama Pengguna</label>
                <input type="text" name="nama_pengguna" class="form-control @error('nama_pengguna') is-invalid @enderror" 
                       value="{{ old('nama_pengguna', $pengguna->nama_pengguna) }}">
                @error('nama_pengguna')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Email -->
            <div class="form-group mb-3">
                <label for="email" class="font-weight-bold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $pengguna->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input NIP -->
            <div class="form-group mb-3">
                <label for="nip" class="font-weight-bold">NIP</label>
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" 
                       value="{{ old('nip', $pengguna->nip) }}">
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Password Baru -->
            <div class="form-group mb-3">
                <label for="password" class="font-weight-bold">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Konfirmasi Password Baru -->
            <div class="form-group mb-3">
                <label for="password_confirmation" class="font-weight-bold">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <!-- Tombol Simpan dan Batal -->
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary w-50 mr-2">Simpan Perubahan</button>
                <a href="{{ url('profile') }}" class="btn btn-secondary w-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<style>
    .bg-primary {
        background-color: #7797CD; /* Warna biru header */
        color: white;
        font-weight: bold;
    }

    .form-group label {
        font-size: 14px;
        color: #555;
    }

    .form-control {
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #2d85e2;
        border: none;
    }

    .btn-secondary {
        background-color: #d1d1d1;
        border: none;
    }
</style>
@endpush
