@empty($infoSertifikasi)
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
                <a href="{{ url('/infoSertifikasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/infoSertifikasi/' . $infoSertifikasi->id_info_sertifikasi . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Sertifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Sertifikasi Name -->
                    <div class="form-group">
                        <label>Nama Sertifikasi</label>
                        <input type="text" class="form-control" id="nama_sertifikasi" name="nama_sertifikasi" value="{{ old('nama_sertifikasi', $infoSertifikasi->nama_sertifikasi) }}" required>
                    </div>
                  
                    <!-- Sertifikasi Level -->
                    <div class="form-group">
                        <label>Level Sertifikasi</label>
                        <select name="level_sertifikasi" id="level_sertifikasi" class="form-control" required>
                            <option value="{{ old('level_sertifikasi', $infoSertifikasi->level_sertifikasi) }}">- Pilih Level Sertifikasi -</option>
                            <option value="Profesi" {{ $infoSertifikasi->level_sertifikasi == 'Profesi' ? 'selected' : '' }}>Profesi</option>
                            <option value="Keahlian" {{ $infoSertifikasi->level_sertifikasi == 'Keahlian' ? 'selected' : '' }}>Keahlian</option>
                        </select>
                    </div>

                    <!-- Sertifikasi Vendor -->
                    <div class="form-group">
                        <label>Vendor Sertifikasi</label>
                        <select name="id_vendor_sertifikasi" id="id_vendor_sertifikasi" class="form-control" required>
                            <option value="">- Pilih Vendor Sertifikasi -</option>
                            @foreach ($vendorSertifikasi as $vendor)
                                <option value="{{ $vendor->id_vendor_sertifikasi }}" {{ $infoSertifikasi->id_vendor_sertifikasi == $vendor->id_vendor_sertifikasi ? 'selected' : '' }}>
                                    {{ $vendor->nama_vendor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Sertifikasi Type -->
                    <div class="form-group">
                        <label>Jenis Sertifikasi</label>
                        <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                            <option value="">- Pilih Jenis Sertifikasi -</option>
                            @foreach ($jenisSertifikasi as $j)
                                <option value="{{ $j->id_jenis_pelatihan_sertifikasi }}" {{ $infoSertifikasi->id_jenis_pelatihan_sertifikasi == $j->id_jenis_pelatihan_sertifikasi ? 'selected' : '' }}>
                                    {{ $j->nama_jenis_pelatihan_sertifikasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sertifikasi Period -->
                    <div class="form-group">
                        <label>Periode Sertifikasi</label>
                        <select name="id_periode" id="id_periode" class="form-control" required>
                            <option value="">- Pilih Periode Sertifikasi -</option>
                            @foreach ($periode as $p)
                                <option value="{{ $p->id_periode }}" {{ $infoSertifikasi->id_periode == $p->id_periode ? 'selected' : '' }}>
                                    {{ $p->tahun_periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mata Kuliah -->
                    <div class="form-group">
                        <label>Mata Kuliah</label>
                        <div id="mata_kuliah">
                            @foreach ($mataKuliah as $mk)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                        name="id_mata_kuliah[]" 
                                        value="{{ $mk->id_mata_kuliah }}" 
                                        id="mata_kuliah_{{ $mk->id_mata_kuliah }}" 
                                        {{ in_array($mk->id_mata_kuliah, old('id_mata_kuliah', $selectedMataKuliah)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mata_kuliah_{{ $mk->id_mata_kuliah }}">
                                        {{ $mk->nama_mata_kuliah }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small id="error-id_mata_kuliah" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Bidang Minat -->
                    <div class="form-group">
                        <label>Bidang Minat</label>
                        <div id="bidang_minat">
                            @foreach ($bidangMinat as $bm)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                        name="id_bidang_minat[]" 
                                        value="{{ $bm->id_bidang_minat }}" 
                                        id="bidang_minat_{{ $bm->id_bidang_minat }}" 
                                        {{ in_array($bm->id_bidang_minat, old('id_bidang_minat', $selectedBidangMinat)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bidang_minat_{{ $bm->id_bidang_minat }}">
                                        {{ $bm->nama_bidang_minat }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small id="error-id_bidang_minat" class="error-text form-text text-danger"></small>
                    </div>
                    
                    <!-- Tanggal Mulai -->
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $infoSertifikasi->tanggal_mulai) }}" required>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $infoSertifikasi->tanggal_selesai) }}" required>
                    </div>

                    <!-- Kuota Peserta -->
                    <div class="form-group">
                        <label>Kuota Peserta</label>
                        <input type="number" class="form-control" id="kuota_peserta" name="kuota_peserta" value="{{ old('kuota_peserta', $infoSertifikasi->kuota_peserta) }}" required>
                    </div>

                    <!-- Masa Berlaku -->
                    <div class="form-group">
                        <label>Masa Berlaku</label>
                        <input type="text" class="form-control" id="masa_berlaku" name="masa_berlaku" value="{{ old('masa_berlaku', $infoSertifikasi->masa_berlaku) }}" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    nama_sertifikasi: {
                        required: true,
                        maxlength: 100
                    },
                    "id_mata_kuliah[]": {
                        required: true
                    },
                    "id_bidang_minat[]": {
                        required: true
                    },
                    level_sertifikasi: {
                        required: true
                    },
                    id_vendor_sertifikasi: {
                        required: true
                    },
                    id_periode: {
                        required: true
                    },
                    tanggal_mulai: {
                        required: true,
                        date: true
                    },
                    tanggal_selesai: {
                        required: true,
                        date: true
                    },
                    kuota_peserta: {
                        required: true,
                        digits: true,
                        min: 1
                    },
                    masa_berlaku: {
                        required: true,
                        maxlength: 50
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response); // Tambahkan ini untuk memeriksa respon dari server
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataSertifikasi.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText); // Tambahkan ini untuk memeriksa error dari server
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty
