@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Barang</h3>
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
@endsection

@push('js')
    <script>
        $(function() {
            $('#barang-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('barang.list') !!}',
                    error: function(xhr, error, thrown) {
                        console.error('Ajax error:', xhr, error, thrown);
                    }
                },
                columns: [
                    { data: 'kategori_nama', name: 'kategori_nama' },
                    { data: 'barang_kode', name: 'barang_kode' },
                    { data: 'barang_nama', name: 'barang_nama' },
                    { data: 'harga_beli', name: 'harga_beli' },
                    { data: 'harga_jual', name: 'harga_jual' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush