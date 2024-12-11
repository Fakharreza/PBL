@empty($infoPelatihan)
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
                <a href="{{ url('/infoPelatihan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/infoPelatihan/' . $infoPelatihan->id_info_pelatihan . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Info Pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Vendor Pelatihan</label>
                        <select name="id_vendor_pelatihan" id="id_vendor_pelatihan" class="form-control" required>
                            <option value="">- Pilih Vendor -</option>
                            @foreach ($vendorPelatihan as $v)
                                <option value="{{ $v->id_vendor_pelatihan }}" {{ $infoPelatihan->id_vendor_pelatihan == $v->id_vendor_pelatihan ? 'selected' : '' }}>
                                    {{ $v->nama_vendor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pelatihan</label>
                        <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                            <option value="">- Pilih Jenis Pelatihan -</option>
                            @foreach ($jenisPelatihan as $j)
                                <option value="{{ $j->id_jenis_pelatihan_sertifikasi }}" {{ $infoPelatihan->id_jenis_pelatihan_sertifikasi == $j->id_jenis_pelatihan_sertifikasi ? 'selected' : '' }}>
                                    {{ $j->nama_jenis_pelatihan_sertifikasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Periode Pelatihan</label>
                        <select name="id_periode" id="id_periode" class="form-control" required>
                            <option value="">- Pilih Periode -</option>
                            @foreach ($periode as $p)
                                <option value="{{ $p->id_periode }}" {{ $infoPelatihan->id_periode == $p->id_periode ? 'selected' : '' }}>
                                    {{ $p->tahun_periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Pelatihan</label>
                        <input type="text" class="form-control" id="lokasi_pelatihan" name="lokasi_pelatihan" value="{{ old('lokasi_pelatihan', $infoPelatihan->lokasi_pelatihan) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Pelatihan</label>
                        <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan" value="{{ old('nama_pelatihan', $infoPelatihan->nama_pelatihan) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Level Pelatihan</label>
                        <select name="level_pelatihan" id="level_pelatihan" class="form-control" required>
                            <option value="{{ old('level_pelatiham', $infoPelatihan->level_pelatihan) }}">- Pilih Level Pelatihan -</option>
                            <option value="Internasional" {{ $infoPelatihan->level_pelatihan == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                            <option value="Nasional" {{ $infoPelatihan->level_pelatihan == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $infoPelatihan->tanggal_mulai) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $infoPelatihan->tanggal_selesai) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kuota Peserta</label>
                        <input type="number" class="form-control" id="kuota_peserta" name="kuota_peserta" value="{{ old('kuota_peserta', $infoPelatihan->kuota_peserta) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Biaya</label>
                        <input type="number" class="form-control" id="biaya" name="biaya" step="0.01" value="{{ old('biaya', $infoPelatihan->biaya) }}" required>
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
                    nama_pelatihan: {
                        required: true,
                        maxlength: 100
                    },
                    level_pelatihan: {
                        required: true
                    }
                    lokasi_pelatihan: {
                        required: true,
                        maxlength: 100
                    },
                    kuota_peserta: {
                        required: true,
                        number: true
                    },
                    biaya: {
                        required: true,
                        number: true
                    },
                }
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataJenis.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty
