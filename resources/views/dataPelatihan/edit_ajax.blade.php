@empty($dataPelatihan)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan.
            </div>
            <a href="{{ url('/dataPelatihan') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/dataPelatihan/' . $dataPelatihan->id_input_pelatihan . '/update_ajax') }}" method="POST" id="form-edit" enctype="multipart/form-data">

    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="nama_pelatihan">Nama Pelatihan</label>
                    <input value="{{ old('nama_pelatihan', $dataPelatihan->nama_pelatihan) }}" type="text" name="nama_pelatihan" id="nama_pelatihan" class="form-control" required>
                    <small id="error-nama_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenis Pelatihan</label>
                    <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                        <option value="">- Pilih Jenis Pelatihan -</option>
                        @foreach ($jenisPelatihan as $jenis)
                            <option value="{{ $jenis->id_jenis_pelatihan_sertifikasi }}" 
                                {{ old('id_jenis_pelatihan_sertifikasi', $dataPelatihan->id_jenis_pelatihan_sertifikasi) == $jenis->id_jenis_pelatihan_sertifikasi ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis_pelatihan_sertifikasi }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-nama_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="waktu_pelatihan">Waktu Pelatihan</label>
                    <input value="{{ old('waktu_pelatihan', \Carbon\Carbon::parse($dataPelatihan->waktu_pelatihan)->format('Y-m-d')) }}" 
                        type="date" class="form-control" id="waktu_pelatihan" name="waktu_pelatihan" required>
                    <small id="error-waktu_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="lokasi_pelatihan">Lokasi Pelatihan</label>
                    <input value="{{ old('lokasi_pelatihan', $dataPelatihan->lokasi_pelatihan) }}" type="text" class="form-control" id="lokasi_pelatihan" name="lokasi_pelatihan" required>
                    <small id="error-lokasi_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="bukti_pelatihan">Bukti Pelatihan (PDF)</label>
                    @if($dataPelatihan->bukti_pelatihan)
                        <p>File yang diunggah: 
                            <a href="{{ asset('storage/bukti_pelatihan/' . $dataPelatihan->bukti_pelatihan) }}" target="_blank">
                                {{ $dataPelatihan->bukti_pelatihan }}
                            </a>
                        </p>
                    @endif
                    <input type="file" class="form-control" id="bukti_pelatihan" name="bukti_pelatihan" accept="application/pdf">
                    <small id="error-bukti_pelatihan" class="error-text form-text text-danger"></small>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
@endempty
