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
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID Sertifikasi</th>
                        <td>{{ $dataSertifikasi->id_input_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Nama Sertifikasi</th>
                        <td>{{ $dataSertifikasi->nama_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>No Sertifikat</th>
                        <td>{{ $dataSertifikasi->no_sertifikat }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Sertifikasi</th>
                        <td>{{ $dataSertifikasi->lokasi_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Sertifikasi</th>
                        <td>{{ $dataSertifikasi->waktu_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Bukti Sertifikasi</th>
                        <td>
                            @if($dataSertifikasi->bukti_sertifikasi)
                                <a href="{{ asset('storage/sertifikasi/' . $dataSertifikasi->bukti_sertifikasi) }}" target="_blank" class="btn btn-success btn-sm">Lihat Bukti</a>
                            @else
                                <span class="text-danger">Belum diunggah</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku</th>
                        <td>{{ $dataSertifikasi->masa_berlaku }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty
