<form action="{{ url('/infoPelatihan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Info Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                 <div class="form-group">
                    <label>Nama Pelatihan</label>
                    <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan" maxlength="100" required>
                    <small id="error-nama_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Pelatihan</label>
                    <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                        <option value="">- Pilih Jenis Pelatihan -</option>
                        @foreach ($jenisPelatihan as $j)
                            <option value="{{ $j->id_jenis_pelatihan_sertifikasi }}">{{ $j->nama_jenis_pelatihan_sertifikasi }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Vendor Pelatihan</label>
                    <select name="id_vendor_pelatihan" id="id_vendor_pelatihan" class="form-control" required>
                        <option value="">- Pilih Vendor -</option>
                        @foreach ($vendorPelatihan as $v)
                            <option value="{{ $v->id_vendor_pelatihan }}">{{ $v->nama_vendor }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_vendor_pelatihan" class="error-text form-text text-danger"></small>
                </div>
              
                <div class="form-group">
                    <label>Periode Pelatihan</label>
                    <select name="id_periode" id="id_periode" class="form-control" required>
                        <option value="">- Pilih Periode Pelatihan -</option>
                        @foreach ($periode as $p)
                            <option value="{{ $p->id_periode }}">{{ $p->tahun_periode }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_periode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Lokasi Pelatihan</label>
                    <input type="text" class="form-control" id="lokasi_pelatihan" name="lokasi_pelatihan" maxlength="100" required>
                    <small id="error-lokasi_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level Pelatihan</label>
                    <select name="level_pelatihan" id="level_pelatihan" class="form-control" required>
                        <option value="">- Pilih Level Pelatihan -</option>
                        <option value="Internasional">Internasional</option>
                        <option value="Nasional">Nasional</option>
                    </select>
                    <small id="error-level_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Mata Kuliah</label>
                    <div id="mata_kuliah">
                        @foreach ($mataKuliah as $mk)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="id_mata_kuliah[]" value="{{ $mk->id_mata_kuliah }}" id="mata_kuliah_{{ $mk->id_mata_kuliah }}">
                                <label class="form-check-label" for="mata_kuliah_{{ $mk->id_mata_kuliah }}">{{ $mk->nama_mata_kuliah }}</label>
                            </div>
                        @endforeach
                    </div>
                    <small id="error-id_mata_kuliah" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Bidang Minat</label>
                    <div id="bidang_minat">
                        @foreach ($bidangMinat as $bm)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="id_bidang_minat[]" value="{{ $bm->id_bidang_minat }}" id="bidang_minat_{{ $bm->id_bidang_minat }}">
                                <label class="form-check-label" for="bidang_minat_{{ $bm->id_bidang_minat }}">{{ $bm->nama_bidang_minat }}</label>
                            </div>
                        @endforeach
                    </div>
                    <small id="error-id_bidang_minat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                    <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kuota Peserta</label>
                    <input type="number" class="form-control" id="kuota_peserta" name="kuota_peserta" min="1" required>
                    <small id="error-kuota_peserta" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Biaya</label>
                    <input type="text" class="form-control" id="biaya" name="biaya" required>
                    <small id="error-biaya" class="error-text form-text text-danger"></small>
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
        $("#form-tambah").validate({
            rules: {
                id_vendor_pelatihan: {
                    required: true,
                    digits: true
                },
                id_jenis_pelatihan_sertifikasi: {
                    required: true,
                    digits: true
                },
                id_periode: {
                    required: true,
                    digits: true
                },
                "id_mata_kuliah[]": {
                    required: true
                },
                "id_bidang_minat[]": {
                    required: true
                },
                lokasi_pelatihan: {
                    required: true,
                    maxlength: 100
                },
                nama_pelatihan: {
                    required: true,
                    maxlength: 100
                },
                level_pelatihan: {
                    required: true,
                    maxlength: 100
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
                biaya: {
                    required: true,
                    number: true
                }
            },
            
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataInfo.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
