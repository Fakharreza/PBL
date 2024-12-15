<form action="{{ url('/dataPelatihan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Pelatihan</label>
                    <input type="text" name="nama_pelatihan" id="nama_pelatihan" class="form-control" required>
                    <small id="error-nama_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenis Pelatihan</label>
                    <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                        <option value="">- Pilih Jenis Pelatihan -</option>
                        @foreach ($jenisPelatihan as $jenis)
                            <option value="{{ $jenis->id_jenis_pelatihan_sertifikasi }}">{{ $jenis->nama_jenis_pelatihan_sertifikasi }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
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
                    <label>Waktu Pelatihan</label>
                    <input type="date" name="waktu_pelatihan" id="waktu_pelatihan" class="form-control" required>
                    <small id="error-waktu_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Lokasi Pelatihan</label>
                    <input type="text" name="lokasi_pelatihan" id="lokasi_pelatihan" class="form-control" required>
                    <small id="error-lokasi_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Bukti Pelatihan (PDF)</label>
                    <input type="file" name="bukti_pelatihan" id="bukti_pelatihan" class="form-control" accept="application/pdf">
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

<script>
    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                nama_pelatihan: {
                    required: true,
                    maxlength: 150
                },
                id_jenis_pelatihan_sertifikasi: {
                    required: true
                },
                id_periode: {
                    required: true,
                    digits: true
                },
                waktu_pelatihan: {
                    required: true,
                    date: true
                },
                lokasi_pelatihan: {
                    required: true,
                    maxlength: 200
                },
                bukti_pelatihan: {
                    extension: "pdf"
                }
            },
            messages: {
                bukti_pelatihan: {
                    extension: "File harus berupa PDF"
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
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPelatihan.ajax.reload();
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