<!-- File: resources/views/suratTugas/upload_form.blade.php -->
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Surat Tugas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('suratTugas.upload', ['jenis' => $jenis, 'id' => $id]) }}" method="POST" enctype="multipart/form-data">
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
