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
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID Pelatihan</th>
                        <td>{{ $dataPelatihan->id_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pelatihan</th>
                        <td>{{ $dataPelatihan->nama_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pelatihan</th>
                        <td>{{ $dataPelatihan->jenisPelatihan->nama_jenis_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Pelatihan</th>
                        <td>{{ $dataPelatihan->waktu_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Biaya</th>
                        <td>{{ number_format($dataPelatihan->biaya, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Pelatihan</th>
                        <td>{{ $dataPelatihan->lokasi_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Bukti Pelatihan</th>
                        <td>
                            @if($dataPelatihan->bukti_pelatihan)
                                <a href="{{ asset('storage/' . $dataPelatihan->bukti_pelatihan) }}" target="_blank" class="btn btn-success btn-sm">Lihat Bukti</a>
                            @else
                                <span class="text-danger">Belum diunggah</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty
