<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Data Ruangan</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Ruangan
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('info')) : ?>
                <script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: '<?= session()->getFlashdata('info'); ?>',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 4000,
                    });
                </script>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <script>
                    let errors = `<?php foreach (session()->getFlashdata('errors') as $error): ?><?= $error; ?> <br> <?php endforeach; ?>`;
                    Swal.fire({
                        title: 'Kesalahan',
                        html: errors,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        timer: 4000,
                    });
                </script>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Nama Ruangan</th>
                            <th>Kapasitas</th>
                            <th>Fasilitas</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($ruangan as $data) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nama_ruangan'] ?></td>
                            <td><?= $data['kapasitas'] ?> orang</td>
                            <td><?= $data['fasilitas'] ?: '-' ?></td>
                            <td>
                                <?php if ($data['status'] == 'Tersedia'): ?>
                                    <span class="badge bg-success">Tersedia</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $data['nama_user'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit<?= $data['id_ruangan'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $data['id_ruangan'] ?>" data-name="<?= $data['nama_ruangan'] ?>" data-type="ruangan">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Tambah Ruangan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Ruangan/InsertData') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" class="form-control" required placeholder="Contoh: Lab Komputer 1">
                </div>
                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" required placeholder="Contoh: 30">
                </div>
                <div class="mb-3">
                    <label class="form-label">Fasilitas</label>
                    <textarea name="fasilitas" class="form-control" rows="3" placeholder="Contoh: Proyektor, AC, Whiteboard"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($ruangan as $data) : ?>
<div class="modal fade" id="modal-edit<?= $data['id_ruangan'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h4 class="modal-title">Edit Ruangan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Ruangan/UpdateData/' . $data['id_ruangan']) ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" class="form-control" value="<?= $data['nama_ruangan'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" value="<?= $data['kapasitas'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fasilitas</label>
                    <textarea name="fasilitas" class="form-control" rows="3"><?= $data['fasilitas'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Tersedia" <?= $data['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                        <option value="Tidak Tersedia" <?= $data['status'] == 'Tidak Tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?php endforeach; ?>