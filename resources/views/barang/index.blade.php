@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Barang</h3>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Tambah Barang
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
                    <!-- Data loaded by AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Create -->
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

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_barang_id" name="barang_id">
                        <div class="form-group">
                            <label for="edit_barang_kode">Barang Kode</label>
                            <input type="text" class="form-control" id="edit_barang_kode" name="barang_kode" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_barang_nama">Barang Nama</label>
                            <input type="text" class="form-control" id="edit_barang_nama" name="barang_nama" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_harga_beli">Harga Beli</label>
                            <input type="number" class="form-control" id="edit_harga_beli" name="harga_beli" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_harga_jual">Harga Jual</label>
                            <input type="number" class="form-control" id="edit_harga_jual" name="harga_jual" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_kategori_id">Kategori</label>
                            <select class="form-control" id="edit_kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->kategori_id }}">{{ $kat->kategori_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteBarang(${row.barang_id})">Hapus</a>
                    `;
                }
            }
        ]
    });

    // Tambah Barang AJAX
    $('#form-create').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: '{!! route('barang.store') !!}',
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#modal-create').modal('hide');
                table.ajax.reload();
                alert(response.message);
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat menyimpan barang!');
            }
        });
    });

    // Edit Barang AJAX
    window.editBarang = function(id) {
        $.get('/barang/' + id + '/edit', function(data) {
            $('#edit_barang_id').val(data.barang_id);
            $('#edit_barang_kode').val(data.barang_kode);
            $('#edit_barang_nama').val(data.barang_nama);
            $('#edit_harga_beli').val(data.harga_beli);
            $('#edit_harga_jual').val(data.harga_jual);
            $('#edit_kategori_id').val(data.kategori_id);
            $('#modal-edit').modal('show');
        });
    }

    // Update Barang AJAX
    $('#form-edit').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#edit_barang_id').val();

        $.ajax({
            url: '/barang/' + id,
            method: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-edit').modal('hide');
                table.ajax.reload();
                alert(response.message);
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat memperbarui barang!');
            }
        });
    });

    // Hapus Barang AJAX
    window.deleteBarang = function(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: '/barang/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    table.ajax.reload();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus barang!');
                }
            });
        }
    };
});

</script>
@endpush
