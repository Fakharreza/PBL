@extends('layoutsSuperAdmin.template') 

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Sertifikasi Dosen</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/dataSertifikasi/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah data</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <table class="table table-bordered table-striped table-hover table-sm" id="table_dataSertifikasi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Sertifikasi</th>
                        <th>Jenis Sertifikasi</th>
                        <th>Lokasi</th>
                        <th>Masa Berlaku</th>
                        <th>Bukti Sertifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataSertifikasi;
        $(document).ready(function() {
            dataSertifikasi = $('#table_dataSertifikasi').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('dataSertifikasi/list') }}",
                    "dataType": "json",
                    "type": "POST", 
                    "data": function(d) {
                        // Additional data if needed
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_sertifikasi",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    { 
                        data: "jenis_pelatihan_sertifikasi", 
                        orderable: true, 
                        searchable: true 
                    },
                    {
                        data: "lokasi_sertifikasi",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "masa_berlaku",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "bukti_sertifikasi", 
                        className: "text-center", 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
