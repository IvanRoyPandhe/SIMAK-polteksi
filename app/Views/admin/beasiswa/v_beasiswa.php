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

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Data Beasiswa</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Beasiswa
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Nama Beasiswa</th>
                            <th>Jenis</th>
                            <th>Jumlah Dana</th>
                            <th>Kuota</th>
                            <th>Batas Pendaftaran</th>
                            <th>Status</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($beasiswa as $bea) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $bea['nama_beasiswa'] ?></td>
                            <td>
                                <span class="badge bg-<?= $bea['jenis'] == 'Prestasi' ? 'success' : ($bea['jenis'] == 'Ekonomi' ? 'warning' : 'info') ?>">
                                    <?= $bea['jenis'] ?>
                                </span>
                            </td>
                            <td>Rp <?= number_format($bea['jumlah_dana'], 0, ',', '.') ?></td>
                            <td><?= $bea['kuota'] ?> orang</td>
                            <td><?= date('d/m/Y', strtotime($bea['batas_pendaftaran'])) ?></td>
                            <td>
                                <span class="badge bg-<?= $bea['status'] == 'Buka' ? 'success' : 'secondary' ?>">
                                    <?= $bea['status'] ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $bea['id_beasiswa'] ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $bea['id_beasiswa'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $bea['id_beasiswa'] ?>" data-name="<?= $bea['nama_beasiswa'] ?>" data-type="beasiswa">
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
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Beasiswa/Insert') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Beasiswa</label>
                    <input type="text" name="nama_beasiswa" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis Beasiswa</label>
                            <select name="jenis" class="form-control" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Prestasi">Prestasi</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="KIP">KIP Kuliah</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jumlah Dana</label>
                            <input type="number" name="jumlah_dana" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kuota</label>
                            <input type="number" name="kuota" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Batas Pendaftaran</label>
                            <input type="date" name="batas_pendaftaran" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Persyaratan</label>
                    <textarea name="persyaratan" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Buka">Buka</option>
                        <option value="Tutup">Tutup</option>
                    </select>
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

<!-- Modal Detail dan Edit untuk setiap beasiswa -->
<?php foreach ($beasiswa as $bea) : ?>
<!-- Modal Detail -->
<div class="modal fade" id="detailModal<?= $bea['id_beasiswa'] ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Nama Beasiswa:</h6>
                        <p><?= $bea['nama_beasiswa'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Jenis:</h6>
                        <p><span class="badge bg-<?= $bea['jenis'] == 'Prestasi' ? 'success' : ($bea['jenis'] == 'Ekonomi' ? 'warning' : 'info') ?>"><?= $bea['jenis'] ?></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Jumlah Dana:</h6>
                        <p>Rp <?= number_format($bea['jumlah_dana'], 0, ',', '.') ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Kuota:</h6>
                        <p><?= $bea['kuota'] ?> orang</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Batas Pendaftaran:</h6>
                        <p><?= date('d F Y', strtotime($bea['batas_pendaftaran'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Status:</h6>
                        <p><span class="badge bg-<?= $bea['status'] == 'Buka' ? 'success' : 'secondary' ?>"><?= $bea['status'] ?></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h6>Persyaratan:</h6>
                        <p><?= nl2br($bea['persyaratan']) ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal<?= $bea['id_beasiswa'] ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Beasiswa/Update/' . $bea['id_beasiswa']) ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Beasiswa</label>
                    <input type="text" name="nama_beasiswa" class="form-control" value="<?= $bea['nama_beasiswa'] ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis Beasiswa</label>
                            <select name="jenis" class="form-control" required>
                                <option value="Prestasi" <?= $bea['jenis'] == 'Prestasi' ? 'selected' : '' ?>>Prestasi</option>
                                <option value="Ekonomi" <?= $bea['jenis'] == 'Ekonomi' ? 'selected' : '' ?>>Ekonomi</option>
                                <option value="KIP" <?= $bea['jenis'] == 'KIP' ? 'selected' : '' ?>>KIP Kuliah</option>
                                <option value="Lainnya" <?= $bea['jenis'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jumlah Dana</label>
                            <input type="number" name="jumlah_dana" class="form-control" value="<?= $bea['jumlah_dana'] ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kuota</label>
                            <input type="number" name="kuota" class="form-control" value="<?= $bea['kuota'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Batas Pendaftaran</label>
                            <input type="date" name="batas_pendaftaran" class="form-control" value="<?= $bea['batas_pendaftaran'] ?>" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Persyaratan</label>
                    <textarea name="persyaratan" class="form-control" rows="4" required><?= $bea['persyaratan'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Buka" <?= $bea['status'] == 'Buka' ? 'selected' : '' ?>>Buka</option>
                        <option value="Tutup" <?= $bea['status'] == 'Tutup' ? 'selected' : '' ?>>Tutup</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?php endforeach; ?>