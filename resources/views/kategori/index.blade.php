@extends('layouts.template')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kategori</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kategori</h3>
                <div class="card-tools">
                    <button id="addKategoriBtn" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </button>
                    <button id="addKategoriAjaxBtn" class="btn btn-primary ml-2">
                        <i class="fas fa-plus"></i> Tambah Kategori (Ajax)
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="kategori-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="kategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="kategoriForm">
                    <div class="form-group">
                        <label for="kategori_kode">Kode</label>
                        <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_nama">Nama</label>
                        <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" required>
                    </div>
                    <input type="hidden" id="kategori_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="saveKategoriBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus kategori ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function() {
    var table = $('#kategori-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('kategori.list') }}',
        columns: [
            { data: 'kategori_id', name: 'kategori_id' },
            { data: 'kategori_kode', name: 'kategori_kode' },
            { data: 'kategori_nama', name: 'kategori_nama' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<a href="javascript:void(0)" class="btn btn-info btn-sm detail-btn" data-id="' + row.kategori_id + '">Detail</a> ' +
                           '<a href="javascript:void(0)" class="btn btn-warning btn-sm edit-btn" data-id="' + row.kategori_id + '">Edit</a> ' +
                           '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.kategori_id + '">Hapus</button>';
                }
            }
        ]
    });

    $('#addKategoriAjaxBtn').click(function() {
        $('#kategoriModal').modal('show');
        $('#kategoriForm')[0].reset();
        $('#kategori_id').val('');
        $('#kategoriModalLabel').text('Tambah Kategori (Ajax)');
    });

    $('#saveKategoriBtn').click(function() {
        var id = $('#kategori_id').val();
        var url = id ? '/kategori/' + id : '/kategori';
        var method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $('#kategoriForm').serialize(),
            success: function(response) {
                $('#kategoriModal').modal('hide');
                table.ajax.reload();
                alert(response.success);
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
            }
        });
    });

    $('#kategori-table').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/kategori/' + id + '/edit',
            method: 'GET',
            success: function(response) {
                $('#kategori_id').val(response.kategori_id);
                $('#kategori_kode').val(response.kategori_kode);
                $('#kategori_nama').val(response.kategori_nama);
                $('#kategoriModal').modal('show');
                $('#kategoriModalLabel').text('Edit Kategori');
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
            }
        });
    });

    $('#kategori-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        $('#confirmDeleteModal').modal('show');
        $('#confirmDeleteBtn').click(function() {
            $.ajax({
                url: '/kategori/' + id,
                method: 'DELETE',
                data: {_token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#confirmDeleteModal').modal('hide');
                    table.ajax.reload();
                    alert(response.success);
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
                }
            });
        });
    });

    $('#kategori-table').on('click', '.detail-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/kategori/' + id,
            method: 'GET',
            success: function(response) {
                // Tampilkan detail kategori (misalnya, di modal atau halaman baru)
                alert('Kode: ' + response.kategori_kode + '\nNama: ' + response.kategori_nama);
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
            }
        });
    });
});
</script>
@endpush