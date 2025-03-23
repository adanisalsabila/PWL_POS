<!-- Create Supplier -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Supplier</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="contact">Kontak</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
