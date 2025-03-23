@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Barang</h3>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-create">
            <i class="fas fa-plus"></i> Tambah Barang
        </button>
        <button type="button" class="btn btn-success ml-2 float-right" id="addBarangAjaxBtn">
            <i class="fas fa-plus"></i> Tambah Barang (Ajax)
        </button>
    </div>
    <div class="card-body">
        <table id="barang-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Kategori Nama</th>
                    <th>Barang Kode</th>
                    <th>Barang Nama</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-create">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="barang_kode">Barang Kode</label>
                        <input type="text" class="form-control" id="barang_kode" name="barang_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="barang_nama">Barang Nama</label>
                        <input type="text" class="form-control" id="barang_nama" name="barang_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->kategori_id }}">{{ $kat->kategori_nama }}</option>
                            @endforeach
                        </select>
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

<div class="modal fade" id="modal-create-ajax" tabindex="-1" role="dialog" aria-labelledby="modalCreateAjaxLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateAjaxLabel">Tambah Barang (Ajax)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-create-ajax">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="barang_kode">Barang Kode</label>
                        <input type="text" class="form-control" id="barang_kode-ajax" name="barang_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="barang_nama">Barang Nama</label>
                        <input type="text" class="form-control" id="barang_nama-ajax" name="barang_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli-ajax" name="harga_beli" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual-ajax" name="harga_jual" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <select class="form-control" id="kategori_id-ajax" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->kategori_id }}">{{ $kat->kategori_nama }}</option>
                            @endforeach
                        </select>
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

@include('barang.edit_ajax')

@include('barang.confirm_ajax')

@endsection

@push('js')
<script>
    $(function () {
        var table = $('#barang-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('barang.list') !!}',
            columns: [
                { data: 'kategori_nama', name: 'kategori_nama' },
                { data: 'barang_kode', name: 'barang_kode' },
                { data: 'barang_nama', name: 'barang_nama' },
                { data: 'harga_beli', name: 'harga_beli' },
                { data: 'harga_jual', name: 'harga_jual' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="editBarang(${row.barang_id})">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDelete(${row.barang_id})">Hapus</a>
                        `;
                    }
                }
            ]
        });

        $('#addBarangAjaxBtn').click(function() {
            $('#modal-create-ajax').modal('show');
        });

        $('#form-create-ajax').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '{!! route('barang.store') !!}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#modal-create-ajax').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menyimpan barang!');
                }
            });
        });

        window.editBarang = function(id) {
            $.get('/barang/edit-ajax/' + id, function(data) {
                $('#modal-edit-ajax .modal-content').html(data);
                $('#modal-edit-ajax').modal('show');
            });
        }

        window.confirmDelete = function(id) {
            $.get('/barang/confirm-delete/' + id, function(data) {
                $('#confirmDeleteModal .modal-content').html(data);
                $('#confirmDeleteModal').modal('show');
            });
        }

        $(document).on('submit', '#form-edit-ajax', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var id = $('#edit_barang_id').val();

            $.ajax({
                url: '/barang/' + id,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    $('#modal-edit-ajax').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat memperbarui barang!');
                }
            });
        });

        $(document).on('click', '#confirmDeleteBtn', function() {
            var id = $('#delete_barang_id').val();

            $.ajax({
                url: '/barang/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#confirmDeleteModal').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus barang!');
                }
            });
        });
    });
</script>
@endpush