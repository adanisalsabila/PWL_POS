@extends('layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Level</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Level</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Level</h3>
                <div class="card-tools">
                    <button onclick="modalAction('{{ url('/level/import') }}')" class="btn btn-info">Import Level</button>
                    <a href="{{ url('/level/export_excel') }}" class="btn btn-primary">
                        <i class="fa fa-file-excel"></i> Export Level
                    </a>
                    <a href="{{ url('/level/export_pdf') }}" class="btn btn-warning">
                        <i class="fa fa-file-pdf"></i> Export Level
                    </a>
                    <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
                </div>
            </div>
            <div class="card-body">
                <table id="level-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Level ID</th>
                            <th>Kode Level</th>
                            <th>Nama Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@include('level.create_ajax')
@include('level.edit_ajax')
@include('level.confirm_ajax')


@endsection

@section('scripts')
<script>
    $(function () {
        var table = $('#level-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('level.list') }}',
            columns: [
                { data: 'level_id', name: 'level_id' },
                { data: 'level_kode', name: 'level_kode' },
                { data: 'level_nama', name: 'level_nama' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Create Level (AJAX)
        $('#form-create-ajax').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('level.store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#modal-create-ajax').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan');
                }
            });
        });

        // Edit Level (AJAX)
        window.editLevel = function(id) {
            $.ajax({
                url: '/level/' + id + '/edit',
                method: 'GET',
                success: function(response) {
                    $('#edit_ajax_level_id').val(response.level_id);
                    $('#edit_ajax_level_kode').val(response.level_kode);
                    $('#edit_ajax_level_nama').val(response.level_nama);
                    $('#modal-edit-ajax').modal('show');
                }
            });
        };

        // Update Level (AJAX)
        $('#form-edit-ajax').on('submit', function (e) {
            e.preventDefault();
            var id = $('#edit_ajax_level_id').val();
            var formData = $(this).serialize();

            $.ajax({
                url: '/level/' + id + '/update',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#modal-edit-ajax').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan');
                }
            });
        });

        // Delete Level (AJAX)
        window.deleteLevel = function(id) {
            $('#modal-confirm-delete-ajax').modal('show');
            $('#confirm-delete-ajax-button').on('click', function() {
                $.ajax({
                    url: '/level/' + id,
                    method: 'DELETE',
                    data: { 
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(response) {
                        $('#modal-confirm-delete-ajax').modal('hide');
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan');
                    }
                });
            });
        };
    });
</script>
@endsection