<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="kategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="kategoriForm">
                    <div class="form-group">
                        <label for="kategori_kode">Kode</label>
                        <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_nama">Nama</label>
                        <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" required>
                    </div>
                    <input type="hidden" id="kategori_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="saveKategoriBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>