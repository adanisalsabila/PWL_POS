@extends('layouts.template')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kategori</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active">Kategori</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kategori</h3>
                    <div class="card-tools">
                        <a href="{{ route('kategori.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Kategori
                        </a>
                    </div>
                </div>
                <!-- Card Body -->
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
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#kategori-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('kategori.list') }}', // URL to fetch data
                columns: [
                    { data: 'kategori_id', name: 'kategori_id' },
                    { data: 'kategori_kode', name: 'kategori_kode' },
                    { data: 'kategori_nama', name: 'kategori_nama' },
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
