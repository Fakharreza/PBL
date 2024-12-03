@empty($vendorSertifikasi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/vendorSertif') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/vendorSertif/' . $vendorSertifikasi->id_vendor_sertifikasi . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Vendor Sertifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Vendor</label>
                        <input value="{{ old('nama_vendor', $vendorSertifikasi->nama_vendor) }}" type="text" name="nama_vendor" id="nama_vendor" class="form-control" required>
                        <small id="error-nama_vendor" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <input value="{{ old('alamat', $vendorSertifikasi->alamat) }}" type="text" name="alamat" id="alamat" class="form-control" required>
                        <small id="error-alamat" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Kota</label>
                        <input value="{{ old('kota', $vendorSertifikasi->kota) }}" type="text" name="kota" id="kota" class="form-control" required>
                        <small id="error-kota" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>No Telp</label>
                        <input value="{{ old('no_telp', $vendorSertifikasi->no_telp) }}" type="text" name="no_telp" id="no_telp" class="form-control" required>
                        <small id="error-no_telp" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Alamat Web</label>
                        <input value="{{ old('alamat_web', $vendorSertifikasi->alamat_web) }}" type="text" name="alamat_web" id="alamat_web" class="form-control" required>
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
        $(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    nama_vendor: {
                        required: true
                    },
                    alamat: {
                        required: true
                    },
                    kota: {
                        required: true
                    },
                    no_telp: {
                        required: true
                    },
                    alamat_web: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false, // Do not process the data
                        contentType: false, // Do not set content type
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataVendorSertif.ajax.reload(); // Reload DataTable
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
