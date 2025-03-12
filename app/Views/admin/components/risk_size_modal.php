<div class="modal fade" id="updateSizeModal<?= $size['id'] ?>" tabindex="-1" role="dialog"
    aria-labelledby="updateSizeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('admin/risk/sizes/' . $size['id']) ?>" method="post">
                <input type="hidden" name="_method" value="PUT"> <!-- Güncelleme işlemi için PUT metodu -->
                <input type="hidden" name="id" id="size_id<?= $size['id'] ?>" value="<?= $size['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateSizeModalLabel">Risk Şiddetinü Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_size_name">Risk Şiddeti Adı</label>
                        <input type="text" name="name" class="form-control" id="edit_size_name<?= $size['id'] ?>"
                            value="<?= $size['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_size_level">Risk Şiddeti Seviyesi</label>
                        <input type="number" name="level" class="form-control" id="edit_size_level<?= $size['id'] ?>"
                            value="<?= $size['level'] ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>