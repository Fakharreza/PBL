@empty($pengguna)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/pengguna') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $pengguna->id_pengguna }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pengguna</th>
                        <td>{{ $pengguna->nama_pengguna}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pengguna->email }}</td>
                    </tr>
                    <tr>
                        <th>Nip</th>
                        <td>{{ $pengguna->nip }}</td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>{{ $pengguna->password }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pengguna</th>
                        <td>{{ $pengguna->jenisPengguna->nama_jenis_pengguna }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty