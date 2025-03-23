@extends('layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Level</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('level.index') }}">Level</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Data Level</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Kode Level:</label>
                    <p>{{ $level->level_kode }}</p>
                </div>
                <div class="form-group">
                    <label>Nama Level:</label>
                    <p>{{ $level->level_nama }}</p>
                </div>
                <a href="{{ route('level.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</section>
@endsection