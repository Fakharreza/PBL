<form action="{{ url('/vendorPelatihan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Vendor Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-form-label">Nama Vendor</label>
                    <input type="text" class="form-control" id="nama_vendor" name="nama_vendor" required>
                    <small id="error-nama_vendor" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                    <small id="error-alamat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Kota</label>
                    <input type="text" class="form-control" id="kota" name="kota" required>
                    <small id="error-kota" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                    <small id="error-no_telp" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Alamat Website</label>
                    <input type="url" class="form-control" id="alamat_web" name="alamat_web" required>
                    <small id="error-alamat_web" class="error-text form-text text-danger"></small>
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
                nama_vendor: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                alamat: {
                    required: true,
                    maxlength: 100
                },
                kota: {
                    required: true,
                    maxlength: 40
                },
                no_telp: {
                    required: true,
                    digits: true,
                    minlength: 8,
                    maxlength: 15
                },
                alamat_web: {
                    required: true,
                    url: true,
                    maxlength: 50
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
                            dataJenis.ajax.reload();
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
