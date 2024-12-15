@extends('layoutsSuperAdmin.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Tabel Belum Disetujui -->
        <table class="table table-bordered table-striped table-hover table-sm" id="table_belum_disetujui"
            style="width:100%">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 35%;">Nama</th>
                    <th style="width: 20%;">Jenis</th>
                    <th style="width: 40%;">Aksi</th>
                </tr>
            </thead>
        </table>

        <!-- Tabel Disetujui -->
        <table class="table table-bordered table-striped table-hover table-sm" id="table_disetujui" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 35%;">Nama</th>
                    <th style="width: 20%;">Jenis</th>
                    <th style="width: 40%;">Aksi</th>
                </tr>
            </thead>
        </table>

        <!-- Tabel Ditolak -->
        <table class="table table-bordered table-striped table-hover table-sm" id="table_ditolak" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 35%;">Nama</th>
                    <th style="width: 20%;">Jenis</th>
                    <th style="width: 40%;">Aksi</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            // Belum Disetujui DataTable
            $('#table_belum_disetujui').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('accPeserta/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.status = 'belum_disetujui';
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
                        data: "nama",
                        className: "",
                        searchable: true
                    },
                    {
                        data: "jenis",
                        className: "text-center",
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

            // Disetujui DataTable
            $('#table_disetujui').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('accPeserta/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.status = 'disetujui';
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
                        data: "nama",
                        className: "",
                        searchable: true
                    },
                    {
                        data: "jenis",
                        className: "text-center",
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

            // Ditolak DataTable
            $('#table_ditolak').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('accPeserta/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.status = 'ditolak';
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
                        data: "nama",
                        className: "",
                        searchable: true
                    },
                    {
                        data: "jenis",
                        className: "text-center",
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