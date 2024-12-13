@empty($infoSertifikasi)
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
                <a href="{{ url('/infoSertifikasi') }}" class="btn btn-warning">Kembali</a>
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
                        <th>ID Vendor Sertifikasi</th>
                        <td>{{ $infoSertifikasi->id_vendor_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Nama Vendor</th>
                        <td>{{ $infoSertifikasi->vendorSertifikasi->nama_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Periode Sertifikasi</th>
                        <td>{{ $infoSertifikasi->periode->tahun_periode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Sertifikasi</th>
                        <td>{{ $infoSertifikasi->nama_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Level Sertifikasi</th>
                        <td>{{ $infoSertifikasi->level_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $infoSertifikasi->tanggal_mulai }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $infoSertifikasi->tanggal_selesai }}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku</th>
                        <td>{{ $infoSertifikasi->masa_berlaku }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty
