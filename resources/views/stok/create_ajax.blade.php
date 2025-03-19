@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Stok</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('stok.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="barang_id">Barang</label>
                <select name="barang_id" class="form-control" required>
                    @foreach ($barang as $item)
                        <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="stok_tanggal">Tanggal</label>
                <input type="date" name="stok_tanggal" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stok_jumlah">Jumlah</label>
                <input type="number" name="stok_jumlah" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
