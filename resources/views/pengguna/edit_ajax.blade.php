@empty($pengguna)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pengguna/' . $pengguna->id_pengguna . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                <label>jenis Pengguna</label>
                    <select name="id_jenis_pengguna" id="id_jenis_pengguna" class="form-control" required>
                        <option value="">- Pilih Jenis Pengguna -</option>
                        @foreach ($jenisPengguna as $l)
                            <option value="{{ $l->id_jenis_pengguna }}">{{ $l->nama_jenis_pengguna }}</option>
                        @endforeach
                    </select>
                    <small id="error-level_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>email</label>
                    <input value="{{ old('email', $pengguna->email) }}" type="text" name="email" id="email" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nip</label>
                    <input value="{{ old('nip', $pengguna->nip) }}" type="text" name="nip" id="nip" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input value="{{ old('nama_pengguna', $pengguna->nama_pengguna) }}" type="text" name="nama_pengguna" id="nama_pengguna" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input value="" type="password" name="password" id="password" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>
            </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btnwarning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
    </form>
    <script>
        $(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    id_jenis_pengguna: {
                        required: true,
                        number: true
                    },
                    nama_pengguna: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    password: {
                        required: true,
                    }
                },
                submitHandler: function (form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false, // setting processData dan contentType ke false, untuk menghandle file 
                        contentType: false,
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                datapengguna.ajax.reload();
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