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
    // Handler untuk tombol Setuju dan Tolak
    $('#btn-setuju, #btn-tolak').on('click', function () {
        var id = $(this).data('id');
        var jenis = $(this).data('jenis');
        var status = $(this).attr('id') === 'btn-setuju' ? 'setuju' : 'ditolak';

        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin mengubah status seluruh peserta menjadi "${status}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah Status!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
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
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#myModal').modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Terjadi Kesalahan!',
                            text: 'Silakan coba lagi.',
                            icon: 'error',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    });
});

</script>