<!-- Modal Peserta -->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Daftar Peserta</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta as $item)
                        <tr>
                            <td>{{ $item->pengguna->nama ?? 'Nama tidak ditemukan' }}</td>
                            <td>{{ $item->pengguna->email ?? 'Email tidak ditemukan' }}</td>
                            <td>{{ $item->status_acc ?? 'Belum disetujui' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada peserta ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" id="btn-setuju" data-id="{{ $id }}" data-jenis="{{ $jenis }}">Setuju</button>
            <button class="btn btn-danger" id="btn-tolak" data-id="{{ $id }}" data-jenis="{{ $jenis }}">Tolak</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Handler for Setuju and Tolak buttons
        $('#btn-setuju, #btn-tolak').on('click', function () {
            var id = $(this).data('id');
            var jenis = $(this).data('jenis');
            var status = $(this).attr('id') === 'btn-setuju' ? 'setuju' : 'ditolak';

            if (!confirm(`Apakah Anda yakin ingin mengubah status seluruh peserta menjadi "${status}"?`)) {
                return;
            }

            $.ajax({
                url: `accPeserta/${id}/ubah_status`,
                type: 'POST',
                data: {
                    status: status,
                    jenis: jenis,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#myModal').modal('hide');
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
</script>