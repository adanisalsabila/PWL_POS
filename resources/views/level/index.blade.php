@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Level</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Level</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Level</h3>
                <a href="{{ route('level.create') }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Tambah Level
                </a>
            </div>
            <div class="card-body">
                <table id="level-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Level</th>
                            <th>Nama Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(function () {
        $('#level-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('level.list') }}', // Link to the list function
            columns: [
                { data: 'level_id', name: 'level_id' },
                { data: 'level_kode', name: 'level_kode' },
                { data: 'level_nama', name: 'level_nama' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
