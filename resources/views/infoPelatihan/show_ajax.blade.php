@empty($infoPelatihan)
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
                <a href="{{ url('/infoPelatihan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Info Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID Vendor Pelatihan</th>
                        <td>{{ $infoPelatihan->id_vendor_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Nama Vendor</th>
                        <td>{{ $infoPelatihan->vendorPelatihan->nama_vendor }}</td>
                    </tr>
                    <tr>
                        <th>ID Jenis Pelatihan</th>
                        <td>{{ $infoPelatihan->id_jenis_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Nama Jenis Pelatihan</th>
                        <td>{{ $infoPelatihan->jenisPelatihan->nama_jenis_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>ID Periode</th>
                        <td>{{ $infoPelatihan->id_periode }}</td>
                    </tr>
                    <tr>
                        <th>Periode Pelatihan</th>
                        <td>{{ $infoPelatihan->periode->tahun_periode }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Pelatihan</th>
                        <td>{{ $infoPelatihan->lokasi_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pelatihan</th>
                        <td>{{ $infoPelatihan->nama_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Level Pelatihan</th>
                        <td>{{ $infoPelatihan->level_pelatihan }}</td>
                    </tr>

                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $infoPelatihan->tanggal_mulai }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $infoPelatihan->tanggal_selesai }}</td>
                    </tr>
                    <tr>
                        <th>Kuota Peserta</th>
                        <td>{{ $infoPelatihan->kuota_peserta }}</td>
                    </tr>
                    <tr>
                        <th>Biaya</th>
                        <td>{{ number_format($infoPelatihan->biaya, 2, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty