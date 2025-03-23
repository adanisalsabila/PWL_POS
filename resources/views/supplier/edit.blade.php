<!-- Edit Supplier -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Supplier</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $supplier->name }}" required>
            </div>
            <div class="form-group">
                <label for="contact">Kontak</label>
                <input type="text" class="form-control" id="contact" name="contact" value="{{ $supplier->contact }}" required>
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $supplier->address }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
