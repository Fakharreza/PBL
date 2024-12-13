@extends('layoutsSuperAdmin.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/infoSertifikasi/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <table class="table table-bordered table-striped table-hover table-sm" id="table_infoSertifikasi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Sertifikasi</th>
                        <th>Level Sertifikasi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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
            dataSertifikasi = $('#table_infoSertifikasi').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('infoSertifikasi/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        // Tambahkan parameter jika diperlukan
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
                        data: "level_sertifikasi",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal_mulai",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal_selesai",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
