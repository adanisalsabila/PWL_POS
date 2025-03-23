<div class="modal fade" id="modal-edit-ajax" tabindex="-1" role="dialog" aria-labelledby="modalEditAjaxLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditAjaxLabel">Edit Data (Ajax)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-ajax">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_barang_id" name="barang_id">
                    <div class="form-group">
                        <label for="edit_barang_kode">Barang Kode</label>
                        <input type="text" class="form-control" id="edit_barang_kode" name="barang_kode" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_barang_nama">Barang Nama</label>
                        <input type="text" class="form-control" id="edit_barang_nama" name="barang_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_harga_beli">Harga Beli</label>
                        <input type="number" class="form-control" id="edit_harga_beli" name="harga_beli" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_harga_jual">Harga Jual</label>
                        <input type="number" class="form-control" id="edit_harga_jual" name="harga_jual" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kategori_id">Kategori</label>
                        <select class="form-control" id="edit_kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->kategori_id }}">{{ $kat->kategori_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>