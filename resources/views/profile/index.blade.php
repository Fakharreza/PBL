@extends('layoutsSuperAdmin.template')
@section('content')
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" aria-hidden="true"></div>
<div class="container mt-3 p-3 bg-light rounded">
    <div class="text-center">

        <!-- Profile Information -->
        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Profile</h4>
                
                <!-- Button Edit Profile -->
                <button class="btn btn-primary profile-button" onclick="modalAction('{{ url('profile/' . $pengguna->id_pengguna . '/edit') }}')">Edit Profile</button>
            </div>
            
            <div class="row mt-3">
                <table class="table table-bordered bg-white shadow-sm">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pengguna->nama_pengguna }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pengguna->email }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pengguna</th>
                        <td>{{ $pengguna->jenisPengguna->nama_jenis_pengguna }}</td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td>{{ $pengguna->nip }}</td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><span class="text-muted">********</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .profile-button {
        transition: background-color 0.3s, transform 0.3s;
    }

    .profile-button:hover {
        background-color: #007bff;
        color: #fff;
        transform: translateY(-2px);
    }

    th {
        background-color: #f8f9fa;
        font-weight: bold;
        text-align: center;
    }

    td {
        text-align: center;
    }
</style>
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
</script>
@endpush

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif