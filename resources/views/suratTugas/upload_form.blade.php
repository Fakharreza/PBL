<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Surat Tugas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="uploadSuratForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file_surat_tugas">Upload Surat Tugas (PDF)</label>
                    <input type="file" name="file_surat_tugas" id="file_surat_tugas" class="form-control" required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#uploadSuratForm').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('suratTugas.upload', ['jenis' => $jenis, 'id' => $id]) }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
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
                        text: 'Gagal mengupload surat tugas. Silakan coba lagi.',
                        icon: 'error',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
</script>
