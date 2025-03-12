<div class="modal fade" id="updateFrequencyModal<?= $frequency['id'] ?>" tabindex="-1" role="dialog"
    aria-labelledby="updateFrequencyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('admin/risk/frequencies/' . $frequency['id']) ?>" method="post">
                <input type="hidden" name="_method" value="PUT"> <!-- PUT metodunu kullanmak için -->
                <input type="hidden" name="id" id="frequency_id<?= $frequency['id'] ?>" value="<?= $frequency['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateFrequencyModalLabel">Risk Olasılığını Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_frequency_name">Risk Olasılığı Adı</label>
                        <input type="text" name="name" class="form-control"
                            id="edit_frequency_name<?= $frequency['id'] ?>" value="<?= $frequency['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_frequency_level">Risk Olasılığı Seviyesi</label>
                        <input type="number" name="level" class="form-control"
                            id="edit_frequency_level<?= $frequency['id'] ?>" value="<?= $frequency['level'] ?>"
                            required>
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