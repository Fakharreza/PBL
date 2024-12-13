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

            <!-- Input Nama -->
            <div class="form-group mb-3">
                <label for="nama" class="font-weight-bold">Nama</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                       value="{{ old('nama', $pengguna->nama) }}">
                @error('nama')
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

            <!-- Input Username -->
            <div class="form-group mb-3">
                <label for="nama_pengguna" class="font-weight-bold">Username</label>
                <input type="text" name="nama_pengguna" class="form-control @error('nama_pengguna') is-invalid @enderror" 
                       value="{{ old('nama_pengguna', $pengguna->nama_pengguna) }}">
                @error('nama_pengguna')
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

            <!-- Tambahkan Form Bidang Minat dan Mata Kuliah untuk Dosen -->
            @if ($pengguna->jenisPengguna->nama_jenis_pengguna == 'Dosen')
                <!-- Input Bidang Minat -->
                <div class="form-group mb-3">
                    <label for="bidang_minat" class="font-weight-bold">Bidang Minat</label>
                    <div>
                        @foreach ($bidangMinat as $minat)
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    name="bidang_minat[]" 
                                    value="{{ $minat->id_bidang_minat }}" 
                                    class="form-check-input"
                                    id="bidangMinat{{ $minat->id_bidang_minat }}"
                                    @if($pengguna->bidangMinat->contains('id_bidang_minat', $minat->id_bidang_minat)) checked @endif
                                >
                                <label class="form-check-label" for="bidangMinat{{ $minat->id_bidang_minat }}">
                                    {{ $minat->nama_bidang_minat }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('bidang_minat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Mata Kuliah -->
                <div class="form-group mb-3">
                    <label for="mata_kuliah" class="font-weight-bold">Mata Kuliah</label>
                    <div>
                        @foreach ($mataKuliah as $kuliah)
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    name="mata_kuliah[]" 
                                    value="{{ $kuliah->id_mata_kuliah }}" 
                                    class="form-check-input"
                                    id="mataKuliah{{ $kuliah->id_mata_kuliah }}"
                                    @if($pengguna->mataKuliah->contains('id_mata_kuliah', $kuliah->id_mata_kuliah)) checked @endif
                                >
                                <label class="form-check-label" for="mataKuliah{{ $kuliah->id_mata_kuliah }}">
                                    {{ $kuliah->nama_mata_kuliah }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('mata_kuliah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <!-- Tombol Simpan dan Batal -->
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary w-50 mr-2">Simpan Perubahan</button>
                <a href="{{ url('profile') }}" class="btn btn-secondary w-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection