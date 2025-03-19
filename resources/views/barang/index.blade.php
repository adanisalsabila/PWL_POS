@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Barang</h3>
        </div>
        <div class="card-body">
            <table id="barang-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kategori ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $('#barang-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('barang.list') !!}',
                columns: [
                    { data: 'barang_id', name: 'barang_id' },
                    { data: 'kategori_id', name: 'kategori_id' },
                    { data: 'barang_kode', name: 'barang_kode' },
                    { data: 'barang_nama', name: 'barang_nama' },
                    { data: 'harga_beli', name: 'harga_beli' },
                    { data: 'harga_jual', name: 'harga_jual' },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [
                    {
                        targets: -1,
                        render: function(data, type, row) {
                            return '<a href="/barang/' + row.barang_id + '/edit" class="btn btn-sm btn-warning">Edit</a>' +
                                '<form action="/barang/' + row.barang_id + '" method="POST" style="display: inline-block;">' +
                                    '@csrf @method("DELETE")' +
                                    '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button>' +
                                '</form>';
                        }
                    }
                ]
            });
        });
    </script>
@endpush