<div class="modal fade" id="dataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formData">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="id">

                    <div class="mb-3">
                        <label class="form-label">Tegangan</label>
                        <input type="number" step="any" class="form-control" id="tegangan">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Arus</label>
                        <input type="number" step="any" class="form-control" id="arus">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Daya</label>
                        <input type="number" step="any" class="form-control" id="daya" readonly>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>