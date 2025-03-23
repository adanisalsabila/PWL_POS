<div class="modal fade" id="modal-create-ajax" tabindex="-1" role="dialog" aria-labelledby="modalCreateAjaxLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateAjaxLabel">Tambah Level (AJAX)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-create-ajax">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create_ajax_level_kode">Kode Level</label>
                        <input type="text" class="form-control" id="create_ajax_level_kode" name="level_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="create_ajax_level_nama">Nama Level</label>
                        <input type="text" class="form-control" id="create_ajax_level_nama" name="level_nama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>