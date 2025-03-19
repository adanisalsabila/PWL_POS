@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Stok</h3>
    </div>
    <div class="card-body">
        <!-- Button to add new stock -->
        <a href="{{ route('stok.create') }}" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Stok
        </a>
        
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
            <tbody>
                <!-- Data will be loaded here by DataTables -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#stok-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('stok.list') !!}', // URL to fetch data
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
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <a href="/stok/${row.stok_id}/edit" class="btn btn-sm btn-warning">Edit</a>
                            <form action="/stok/${row.stok_id}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                            </form>
                        `;
                    }
                }
            ]
        });
    });
</script>
@endpush
