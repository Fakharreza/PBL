@empty($vendorSertifikasi)
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
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/vendorSertif') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Vendor Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID Vendor Sertifikasi</th>
                        <td>{{ $vendorSertifikasi->id_vendor_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Nama Vendor</th>
                        <td>{{ $vendorSertifikasi->nama_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $vendorSertifikasi->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Kota</th>
                        <td>{{ $vendorSertifikasi->kota }}</td>
                    </tr>
                    <tr>
                        <th>No Telp</th>
                        <td>{{ $vendorSertifikasi->no_telp }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Web</th>
                        <td>{{ $vendorSertifikasi->alamat_web }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty
