@extends('layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Level</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('level.index') }}">Level</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Data Level</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('level.update', $level->level_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="level_kode">Kode Level</label>
                        <input type="text" class="form-control" id="level_kode" name="level_kode" value="{{ $level->level_kode }}" required>
                    </div>
                    <div class="form-group">
                        <label for="level_nama">Nama Level</label>
                        <input type="text" class="form-control" id="level_nama" name="level_nama" value="{{ $level->level_nama }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('level.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection