<form action="{{ url('/infoSertifikasi/' . $info . '/store_peserta') }}" method="POST" id="form-tambah-peserta">
    @csrf
    <div id="modal-tambah-peserta" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPesertaLabel">Tambah Peserta Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="dosen">Anggota Peserta</label>
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Rekomendasi Dosen
                        </div>
                        <div class="card-body">
                            @foreach ($dosen as $d)
                                <div class="form-check">
                                    <input 
                                        type="checkbox" 
                                        name="id_pengguna[]" 
                                        id="dosen_{{ $d->id_pengguna }}" 
                                        class="form-check-input" 
                                        value="{{ $d->id_pengguna }}" 
                                        {{ in_array($d->id_pengguna, $peserta) ? 'checked' : '' }}
                                    >
                                    <label for="dosen_{{ $d->id_pengguna }}" class="form-check-label">
                                        {{ $d->nama_pengguna }} - Telah mengikuti {{ $d->jumlah_sertifikasi ?? 0 }} sertifikasi
                                    </label>
                                </div>
                            @endforeach
                            <small id="error-id_pengguna" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Peserta</button>
                <button type="button" id="btn-hapus-semua" class="btn btn-danger">Hapus Semua Peserta</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-tambah-peserta").validate({
            rules: {
                "id_pengguna[]": {
                    required: true
                }
            },
            messages: {
                "id_pengguna[]": {
                    required: "Harap pilih setidaknya satu peserta."
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#modal-tambah-peserta').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataInfo.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server.'
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

        // Fungsi untuk tombol hapus semua peserta
        $('#btn-hapus-semua').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus semua peserta yang terdaftar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Semua'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("/infoSertifikasi/" . $info . "/hapus_peserta") }}',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataInfo.ajax.reload();
                                $('#modal-tambah-peserta').modal('hide');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
