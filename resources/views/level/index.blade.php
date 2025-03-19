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
                <h3 class="card-title">Data Level</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-create">
                    <i class="fas fa-plus"></i> Tambah Level
                </button>
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
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Create -->
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Tambah Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-create">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="level_kode">Kode Level</label>
                        <input type="text" class="form-control" id="level_kode" name="level_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="level_nama">Nama Level</label>
                        <input type="text" class="form-control" id="level_nama" name="level_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="level_nama">Level ID</label>
                        <input type="text" class="form-control" id="level_id" name="level_id" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_level_id" name="level_id">
                    <div class="form-group">
                        <label for="edit_level_kode">Kode Level</label>
                        <input type="text" class="form-control" id="edit_level_kode" name="level_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_level_nama">Nama Level</label>
                        <input type="text" class="form-control" id="edit_level_nama" name="level_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="level_nama">Level ID</label>
                        <input type="text" class="form-control" id="level_id" name="level_id" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        $('#form-create').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('level.store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#modal-create').modal('hide');
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
                    $('#edit_level_id').val(response.level_id);
                    $('#edit_level_kode').val(response.level_kode);
                    $('#edit_level_nama').val(response.level_nama);
                    $('#modal-edit').modal('show');
                }
            });
        };

        // Update Level (AJAX)
        $('#form-edit').on('submit', function (e) {
            e.preventDefault();
            var id = $('#edit_level_id').val();
            var formData = $(this).serialize();

            $.ajax({
                url: '/level/' + id + '/update',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#modal-edit').modal('hide');
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
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: '/level/' + id,
                    method: 'DELETE',
                    data: { 
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(response) {
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan');
                    }
                });
            }
        };
    });
</script>
@endsection
