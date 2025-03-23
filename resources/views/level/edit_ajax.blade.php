<!-- Modal for editing level -->
<div class="modal fade" id="modal-edit-ajax" tabindex="-1" role="dialog" aria-labelledby="modal-edit-ajax-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-ajax-label">Edit Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-ajax" method="POST">
                    @csrf
                    <input type="hidden" id="edit_ajax_level_id" name="level_id">
                    <div class="form-group">
                        <label for="edit_ajax_level_kode">Kode Level</label>
                        <input type="text" class="form-control" id="edit_ajax_level_kode" name="level_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_ajax_level_nama">Nama Level</label>
                        <input type="text" class="form-control" id="edit_ajax_level_nama" name="level_nama" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
