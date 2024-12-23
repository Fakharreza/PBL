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

        <table class="table table-bordered table-striped table-hover table-sm" id="table_info">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal for upload form -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" aria-hidden="true">
</div>

@endsection

@push('js')
<script>
    var dataJenis;
    $(document).ready(function () {
        // Initialize DataTable
        dataJenis = $('#table_info').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('suratTugas/list') }}",  // Check if URL is correct
                "dataType": "json",
                "type": "POST",
                "data": function (d) {}
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
                    searchable: true
                },
                {
                    data: "jenis",
                    className: "text-center",
                    searchable: false
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

    // Function to open the upload form via AJAX
    function openUploadForm(jenis, id) {
        $.ajax({
            url: 'suratTugas/' + jenis + '/' + id + '/upload_form', // Correct the URL
            type: 'GET',
            success: function (response) {
                $('#myModal').html(response);
                $('#myModal').modal('show');
            },
            error: function (xhr, status, error) {
                alert('Gagal memuat form upload');
            }
        });
    }
</script>
@endpush
