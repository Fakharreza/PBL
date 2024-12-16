@empty($detail)
<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/statistikSertifikasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
</div>
@else
<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Sertifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>ID Input Sertifikasi</th><td>{{ $detail->id_input_sertifikasi }}</td></tr>
                    <tr><th>Nama Pengguna</th><td>{{ $detail->nama_pengguna }}</td></tr>
                    <tr><th>Nama Sertifikasi</th><td>{{ $detail->nama_sertifikasi }}</td></tr>
                    <tr><th>Lokasi Sertifikasi</th><td>{{ $detail->lokasi_sertifikasi }}</td></tr>
                    <tr><th>Waktu Sertifikasi</th><td>{{ $detail->waktu_sertifikasi }}</td></tr>
                    <tr><th>No Sertifikat</th><td>{{ $detail->no_sertifikat }}</td></tr>
                    <tr><th>Masa Berlaku</th><td>{{ $detail->masa_berlaku }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endempty


