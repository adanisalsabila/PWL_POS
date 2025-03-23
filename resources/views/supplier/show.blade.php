<!-- Show Supplier Details -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Supplier</h3>
    </div>
    <div class="card-body">
        <p><strong>Nama:</strong> {{ $supplier->name }}</p>
        <p><strong>Kontak:</strong> {{ $supplier->contact }}</p>
        <p><strong>Alamat:</strong> {{ $supplier->address }}</p>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
