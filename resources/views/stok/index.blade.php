@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Stok</h3>
        </div>
        <div class="card-body">
            <table id="stok-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Barang ID</th>
                        <th>User ID</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
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
            $('#stok-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('stok.list') !!}',
                columns: [
                    { data: 'stok_id', name: 'stok_id' },
                    { data: 'barang_id', name: 'barang_id' },
                    { data: 'user_id', name: 'user_id' },
                    { data: 'stok_tanggal', name: 'stok_tanggal' },
                    { data: 'stok_jumlah', name: 'stok_jumlah' },
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
                            return '<a href="/stok/' + row.stok_id + '/edit" class="btn btn-sm btn-warning">Edit</a>' +
                                '<form action="/stok/' + row.stok_id + '" method="POST" style="display: inline-block;">' +
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