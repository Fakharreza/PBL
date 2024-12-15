<form action="{{ url('/dataSertifikasi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Sertifikasi</label>
                    <input type="text" name="nama_sertifikasi" id="nama_sertifikasi" class="form-control" required>
                    <small id="error-nama_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Sertifikasi</label>
                    <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                        <option value="">- Pilih Jenis Pelatihan -</option>
                        @foreach ($jenisPelatihan as $jenis)
                            <option value="{{ $jenis->id_jenis_pelatihan_sertifikasi }}">{{ $jenis->nama_jenis_pelatihan_sertifikasi }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>No Sertifikat</label>
                    <input type="text" name="no_sertifikat" id="no_sertifikat" class="form-control" required>
                    <small id="error-no_sertifikat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Lokasi Sertifikasi</label>
                    <input type="text" name="lokasi_sertifikasi" id="lokasi_sertifikasi" class="form-control" required>
                    <small id="error-lokasi_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Periode Sertifikasi</label>
                    <select name="id_periode" id="id_periode" class="form-control" required>
                        <option value="">- Pilih Periode Sertifikasi -</option>
                        @foreach ($periode as $p)
                            <option value="{{ $p->id_periode }}">{{ $p->tahun_periode }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_periode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Waktu Sertifikasi</label>
                    <input type="date" name="waktu_sertifikasi" id="waktu_sertifikasi" class="form-control" required>
                    <small id="error-waktu_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bukti Sertifikasi (PDF)</label>
                    <input type="file" name="bukti_sertifikasi" id="bukti_sertifikasi" class="form-control" accept="application/pdf">
                    <small id="error-bukti_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Masa Berlaku</label>
                    <input type="date" name="masa_berlaku" id="masa_berlaku" class="form-control" required>
                    <small id="error-masa_berlaku" class="error-text form-text text-danger"></small>
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
                nama_sertifikasi: {
                    required: true,
                    maxlength: 100
                },
                id_jenis_pelatihan_sertifikasi: {
                    required: true
                },
                no_sertifikat: {
                    required: true,
                    digits: true
                },
                lokasi_sertifikasi: {
                    required: true,
                    maxlength: 50
                },
                id_periode: {
                    required: true,
                    digits: true
                },
                waktu_sertifikasi: {
                    required: true,
                    date: true
                },
                bukti_sertifikasi: {
                    required: true,
                    extension: "pdf" // File must be in PDF format
                },
                masa_berlaku: {
                    required: true,
                    date: true
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
                        if (response.status) {
                            $('#modal-master').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataSertifikasi.ajax.reload();
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
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat mengirim data.'
                        });
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
