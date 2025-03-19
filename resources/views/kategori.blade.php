@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Kategori</h3>
        </div>
        <div class="card-body">
            <table id="kategori-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $('#kategori-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('kategori.list') !!}', // Pastikan rute ini benar
                columns: [
                    { data: 'kategori_id', name: 'kategori_id' },
                    { data: 'kategori_kode', name: 'kategori_kode' },
                    { data: 'kategori_nama', name: 'kategori_nama' }
                ]
            });
        });
    </script>
@endpush