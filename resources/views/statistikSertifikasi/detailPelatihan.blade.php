@if ($detail)
    <div class="modal fade" id="detailPelatihanModal" tabindex="-1" aria-labelledby="detailPelatihanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailPelatihanModalLabel">Detail Pelatihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr><th>ID Input Pelatihan</th><td>{{ $detail->id_input_pelatihan }}</td></tr>
                        <tr><th>Nama Pengguna</th><td>{{ $detail->nama_pengguna }}</td></tr>
                        <tr><th>Nama Pelatihan</th><td>{{ $detail->nama_pelatihan }}</td></tr>
                        <tr><th>Lokasi Pelatihan</th><td>{{ $detail->lokasi_pelatihan }}</td></tr>
                        <tr><th>Waktu Pelatihan</th><td>{{ $detail->waktu_pelatihan }}</td></tr>
                        <tr><th>Tahun Periode</th><td>{{ $detail->tahun_periode }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-danger">
        Data pelatihan tidak ditemukan.
    </div>
@endif
