@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Stok</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('stok.update', $stok->stok_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="barang_id">Barang</label>
                <select name="barang_id" class="form-control" required>
                    @foreach ($barang as $item)
                        <option value="{{ $item->barang_id }}" @if($item->barang_id == $stok->barang_id) selected @endif>{{ $item->barang_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->user_id }}" @if($user->user_id == $stok->user_id) selected @endif>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="stok_tanggal">Tanggal</label>
                <input type="date" name="stok_tanggal" class="form-control" value="{{ $stok->stok_tanggal }}" required>
            </div>
            <div class="form-group">
                <label for="stok_jumlah">Jumlah</label>
                <input type="number" name="stok_jumlah" class="form-control" value="{{ $stok->stok_jumlah }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
