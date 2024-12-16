@empty($dataSertifikasi)
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
                <a href="{{ url('/dataSertifikasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/dataSertifikasi/' . $dataSertifikasi->id_input_sertifikasi . '/update_ajax') }}" method="POST"
        id="form-edit" enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label for="nama_sertifikasi">Nama Sertifikasi</label>
                        <input value="{{ old('nama_sertifikasi', $dataSertifikasi->nama_sertifikasi) }}" type="text"
                            name="nama_sertifikasi" id="nama_sertifikasi" class="form-control" required>
                        <small id="error-nama_sertifikasi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Sertifikasi</label>
                        <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                            <option value="">- Pilih Jenis Pelatihan -</option>
                            @foreach ($jenisPelatihan as $jenis)
                                <option value="{{ $jenis->id_jenis_pelatihan_sertifikasi }}" 
                                    {{ old('id_jenis_pelatihan_sertifikasi', $dataSertifikasi->id_jenis_pelatihan_sertifikasi) == $jenis->id_jenis_pelatihan_sertifikasi ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis_pelatihan_sertifikasi }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-nama_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
                    </div>
    
                    <div class="form-group">
                        <label for="no_sertifikat">No Sertifikat</label>
                        <input value="{{ old('no_sertifikat', $dataSertifikasi->no_sertifikat) }}" type="text"
                            name="no_sertifikat" id="no_sertifikat" class="form-control" required>
                        <small id="error-no_sertifikat" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_sertifikasi">Lokasi Sertifikasi</label>
                        <input value="{{ old('lokasi_sertifikasi', $dataSertifikasi->lokasi_sertifikasi) }}" type="text"
                            name="lokasi_sertifikasi" id="lokasi_sertifikasi" class="form-control" required>
                        <small id="error-lokasi_sertifikasi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Periode Sertifikasi</label>
                        <select name="id_periode" id="id_periode" class="form-control" required>
                            <option value="">- Pilih Periode -</option>
                            @foreach ($periode as $p)
                                <option value="{{ $p->id_periode }}" {{ $dataSertifikasi->id_periode == $p->id_periode ? 'selected' : '' }}>
                                    {{ $p->tahun_periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="waktu_sertifikasi">Waktu Sertifikasi</label>
                        <input
                            value="{{ old('waktu_sertifikasi', \Carbon\Carbon::parse($dataSertifikasi->waktu_sertifikasi)->format('Y-m-d')) }}"
                            type="date" class="form-control" id="waktu_sertifikasi" name="waktu_sertifikasi" required>
                        <small id="error-waktu_sertifikasi" class="error-text form-text text-danger"></small>
                    </div>
                    {{-- <div class="form-group">
                        <label for="bukti_sertifikasi">Bukti Sertifikasi (PDF)</label>
                        @if ($dataSertifikasi->bukti_sertifikasi)
                            <p>File yang diunggah:
                                <a href="{{ asset('storage/sertifikasi/' . $dataSertifikasi->bukti_sertifikasi) }}"
                                    target="_blank">
                                    {{ $dataSertifikasi->bukti_sertifikasi }}
                                </a>
                            </p>
                        @endif
                        <input type="file" name="bukti_sertifikasi" id="bukti_sertifikasi" class="form-control"
                            accept="application/pdf">
                        <small id="error-bukti_sertifikasi" class="error-text form-text text-danger"></small>
                    </div> --}}
                    <div class="form-group">
                        <label for="masa_berlaku">Masa Berlaku</label>
                        <input
                            value="{{ old('masa_berlaku', \Carbon\Carbon::parse($dataSertifikasi->masa_berlaku)->format('Y-m-d')) }}"
                            type="date" class="form-control" id="masa_berlaku" name="masa_berlaku" required>
                        <small id="error-masa_berlaku" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
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
                        maxlength: 40
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
                    masa_berlaku: {
                        required: true,
                        date: true
                    },
                    // bukti_sertifikasi: {
                    //     extension: "pdf",
                    //     filesize: 2048 // ini dalam kilobyte (KB), bisa sesuaikan dengan 2MB
                    // }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: '/dataSertifikasi/' + id + '/update_ajax',
                        type: 'PUT',
                        data: formData,
                        success: function(response) {
                            console.log(response); // Pastikan response JSON diterima
                            if (response.status) {
                                // Jika berhasil
                                alert('Data berhasil diupdate');
                            } else {
                                // Jika gagal
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr
                            .responseText); // Debugging jika ada error di AJAX
                            alert('Terjadi kesalahan di server!');
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
@endempty
