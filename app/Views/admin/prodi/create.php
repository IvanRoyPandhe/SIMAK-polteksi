<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="card-title mb-0">Tambah Program Studi</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('Prodi/store') ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kode Prodi</label>
                            <input type="text" class="form-control" name="kode_prodi" 
                                   value="<?= old('kode_prodi') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Program Studi</label>
                            <input type="text" class="form-control" name="nama_prodi" 
                                   value="<?= old('nama_prodi') ?>" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenjang</label>
                    <select class="form-select" name="jenjang" required>
                        <option value="D3" <?= old('jenjang') == 'D3' ? 'selected' : '' ?>>D3</option>
                        <option value="D4" <?= old('jenjang') == 'D4' ? 'selected' : '' ?>>D4</option>
                        <option value="S1" <?= old('jenjang') == 'S1' ? 'selected' : '' ?>>S1</option>
                        <option value="S2" <?= old('jenjang') == 'S2' ? 'selected' : '' ?>>S2</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('Prodi') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>