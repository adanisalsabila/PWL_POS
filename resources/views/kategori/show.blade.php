@extends('layouts.template')

@section('content')
<div class="content-header">
    <div class="container-fluid
    <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Kategori</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Kode:</label>
                    <p>{{ $kategori->kategori_kode }}</p>
                </div>
                <div class="form-group">
                    <label>Nama:</label>
                    <p>{{ $kategori->kategori_nama }}</p>
                </div>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</section>
@endsection