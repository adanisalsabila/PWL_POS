@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Level</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="level-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Level</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Kategori</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="kategori-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Stok</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="stok-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Barang ID</th>
                                <th>Jumlah Stok</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="barang-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Kategori ID</th>
                                <th>Supplier ID</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#level-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.level.list') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nama', name: 'nama' },
                ]
            });

            $('#kategori-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.kategori.list') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nama', name: 'nama' },
                ]
            });

            $('#stok-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.stok.list') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'barang_id', name: 'barang_id' },
                    { data: 'jumlah_stok', name: 'jumlah_stok' },
                    { data: 'tanggal_masuk', name: 'tanggal_masuk' },
                ]
            });

            $('#barang-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.barang.list') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nama', name: 'nama' },
                    { data: 'kategori_id', name: 'kategori_id' },
                    { data: 'supplier_id', name: 'supplier_id' },
                ]
            });
        });
    </script>
@endpush