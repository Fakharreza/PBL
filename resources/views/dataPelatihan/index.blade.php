@extends('layoutsSuperAdmin.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Pelatihan Dosen</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/dataPelatihan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah data</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_dataPelatihan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelatihan</th>
                        <th>Jenis Pelatihan</th>
                        <th>Periode</th>
                        <th>Waktu Pelatihan</th>
                        <th>Lokasi Pelatihan</th>
                        <th>Bukti Pelatihan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal for Create, Edit, Show, Delete -->
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

        $(document).ready(function() {
            $('#table_dataPelatihan').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('dataPelatihan/list') }}",
                    type: "POST",
                    dataType: "json",
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "nama_pelatihan", orderable: true, searchable: true },
                    { data: "jenis_pelatihan_sertifikasi", orderable: true, searchable: true },
                    { data: "periode", orderable: true, searchable: true },
                    { data: "waktu_pelatihan", orderable: true, searchable: true },
                    { data: "lokasi_pelatihan", orderable: true, searchable: true },
                    { data: "bukti_pelatihan", className: "text-center", orderable: false, searchable: false },
                    { data: "aksi", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush