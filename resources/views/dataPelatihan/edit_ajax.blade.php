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
<form action="{{ url('/dataPelatihan/' . $dataPelatihan->id_pelatihan . '/update_ajax') }}" method="POST" id="form-edit" enctype="multipart/form-data">
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
                    <input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan" value="{{ $dataPelatihan->nama_pelatihan }}" required>
                    <small id="error-nama_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenis Pelatihan</label>
                    <select name="id_jenis_pelatihan" id="id_jenis_pelatihan" class="form-control" required>
                        <option value="">- Pilih Jenis Pelatihan -</option>
                        @foreach ($jenisPelatihan as $jenis)
                            <option value="{{ $jenis->id_jenis_pelatihan }}" {{ $jenis->id_jenis_pelatihan == $dataPelatihan->id_jenis_pelatihan ? 'selected' : '' }}>
                                {{ $jenis->jenis_pelatihan }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-jenis_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="waktu_pelatihan">Waktu Pelatihan</label>
                    <input type="date" class="form-control" id="waktu_pelatihan" name="waktu_pelatihan" value="{{ $dataPelatihan->waktu_pelatihan }}" required>
                    <small id="error-waktu_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="biaya">Biaya</label>
                    <input type="number" class="form-control" id="biaya" name="biaya" value="{{ $dataPelatihan->biaya }}" required>
                    <small id="error-biaya" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="lokasi_pelatihan">Lokasi Pelatihan</label>
                    <input type="text" class="form-control" id="lokasi_pelatihan" name="lokasi_pelatihan" value="{{ $dataPelatihan->lokasi_pelatihan }}" required>
                    <small id="error-lokasi_pelatihan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="bukti_pelatihan">Bukti Pelatihan (PDF)</label>
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

<script>
    $(document).ready(function () {
        $("#form-edit").validate({
            rules: {
                nama_pelatihan: {
                    required: true,
                    maxlength: 150
                },
                jenis_pelatihan: {
                    required: true
                },
                waktu_pelatihan: {
                    required: true,
                    date: true
                },
                biaya: {
                    required: true,
                    number: true
                },
                lokasi_pelatihan: {
                    required: true,
                    maxlength: 200
                },
                bukti_pelatihan: {
                    extension: "pdf",
                    filesize: 2048 // In KB
                }
            },
            messages: {
                bukti_pelatihan: {
                    extension: "File harus berupa PDF",
                    filesize: "Ukuran file maksimal 2 MB"
                }
            },
            submitHandler: function (form) {
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
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
                            $.each(response.msgField, function (prefix, val) {
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
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endempty