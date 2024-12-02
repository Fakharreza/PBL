@extends('layoutsSuperAdmin.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
            <button onclick="modalAction('{{ url('/vendorPelatihan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah</button>

            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <table class="table table-bordered table-striped table-hover table-sm" id="table_vendorPelatihan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Vendor Pelatihan</th>
                        <th>Alamat</th>
                        <th>Alamat Web</th>
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
        var dataJenis;
        $(document).ready(function() {
            dataJenis = $('#table_vendorPelatihan').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('vendorPelatihan/list') }}",
                    "dataType": "json",
                    "type": "POST" , 
                    "data": function(d) {

                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_vendor",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "alamat",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "alamat_web",
                        className: "",
                        orderable: false,
                        searchable: true
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