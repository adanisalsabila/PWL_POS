<!-- Edit Supplier via AJAX -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier (AJAX)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editSupplierForm">
                    <div class="form-group">
                        <label for="editName">Nama</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editContact">Kontak</label>
                        <input type="text" class="form-control" id="editContact" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Alamat</label>
                        <input type="text" class="form-control" id="editAddress" name="address" required>
                    </div>
                    <input type="hidden" id="editSupplierId" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveEditBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>
