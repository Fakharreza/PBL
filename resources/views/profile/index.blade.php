@extends('layoutsSuperAdmin.template')

@section('content')
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>

<div class="container mt-5 p-4 bg-white rounded shadow-sm" style="max-width: 600px;">
    <!-- Profile Header -->
    <div class="profile-header">
        <h5 class="mb-0">Data Pengguna</h5>
    </div>

    <!-- Profile Information -->
    <div class="p-4">
        <table class="table table-borderless">
            <tr>
                <th>Nama Pengguna</th>
                <td>{{ $pengguna->nama_pengguna }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $pengguna->email }}</td>
            </tr>
            <tr>
                <th>Unit</th>
                <td>{{ $pengguna->jenisPengguna->nama_jenis_pengguna }}</td>
            </tr>
            <tr>
                <th>NIP</th>
                <td>{{ $pengguna->nip }}</td>
            </tr>
            <tr>
                <th>Kata Sandi</th>
                <td><span class="text-muted">********</span></td>
            </tr>
        </table>

        <!-- Buttons -->
        <div class="text-center">
            <button class="btn btn-primary profile-button mb-2" onclick="modalAction('{{ url('profile/' . $pengguna->id_pengguna . '/edit') }}')">Edit Profil</button>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .profile-header {
        background-color: #2d85e2;
        text-align: center;
        padding: 10px 0;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        color: #fff;
    }

    /* Styling for Profile Button */
    .profile-button {
        background-color: #2d85e2;
        transition: all 0.2s ease-in-out;
    }

    .profile-button:hover {
        background-color: #003369;
        color: #fff;
        transform: translateY(-2px);
    }

    /* Table Styling */
    .table th {
        width: 150px;
        font-weight: normal;
        color: #6c757d;
        text-align: left;
    }

    .table td {
        color: #333;
        text-align: left;
    }

    .table-borderless th, .table-borderless td {
        border: none;
    }

    /* Container Max Width */
    .container {
        max-width: 500px;
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
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif
