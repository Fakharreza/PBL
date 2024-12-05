<!-- confirm_ajax.blade.php -->
<form action="{{ url('/mataKuliah/' . $mataKuliah->id_mata_kuliah . '/delete_ajax') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Mata Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi !!!</h5>
                    Apakah Anda yakin ingin menghapus data mata kuliah berikut?
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th>Nama Mata Kuliah</th>
                        <td>{{ $mataKuliah->mata_kuliah }}</td>
                    </tr>
                    <tr>
                        <th>Kode Mata Kuliah</th>
                        <td>{{ $mataKuliah->kode_mata_kuliah }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </div>
</form>
