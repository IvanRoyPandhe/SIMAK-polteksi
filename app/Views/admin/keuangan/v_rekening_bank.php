<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manajemen Rekening Bank</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Rekening
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('info') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bank</th>
                            <th>No. Rekening</th>
                            <th>Nama Pemilik</th>
                            <th>Saldo Awal</th>
                            <th>Saldo Akhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($rekening as $data): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-university text-primary me-2"></i>
                                    <strong><?= $data['nama_bank'] ?></strong>
                                </div>
                            </td>
                            <td><code><?= $data['no_rekening'] ?></code></td>
                            <td><?= $data['nama_pemilik'] ?></td>
                            <td>Rp <?= number_format($data['saldo_awal'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge bg-<?= $data['saldo_akhir'] >= 0 ? 'success' : 'danger' ?>">
                                    Rp <?= number_format($data['saldo_akhir'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($data['is_active']): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit<?= $data['id_rekening'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" 
                                        data-id="<?= $data['id_rekening'] ?>" 
                                        data-name="<?= $data['nama_bank'] . ' - ' . $data['no_rekening'] ?>" 
                                        data-type="rekening-bank">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary Cards -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h3><?= count($rekening) ?></h3>
                            <p class="mb-0">Total Rekening</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h3>Rp <?= number_format(array_sum(array_column($rekening, 'saldo_akhir')), 0, ',', '.') ?></h3>
                            <p class="mb-0">Total Saldo</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h3><?= count(array_filter($rekening, fn($r) => $r['is_active'])) ?></h3>
                            <p class="mb-0">Rekening Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('KasInternal/InsertRekening') ?>" method="post">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Tambah Rekening Bank</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Bank</label>
                        <select class="form-control" name="nama_bank" required>
                            <option value="">Pilih Bank</option>
                            <option value="Bank Mandiri">Bank Mandiri</option>
                            <option value="BNI">BNI</option>
                            <option value="BRI">BRI</option>
                            <option value="BCA">BCA</option>
                            <option value="BTN">BTN</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="no_rekening" required placeholder="1234567890">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pemilik</label>
                        <input type="text" class="form-control" name="nama_pemilik" required placeholder="KAMPUS POLTEKSI">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Saldo Awal</label>
                        <input type="number" class="form-control" name="saldo_awal" required placeholder="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($rekening as $data): ?>
<div class="modal fade" id="modal-edit<?= $data['id_rekening'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('KasInternal/UpdateRekening/' . $data['id_rekening']) ?>" method="post">
                <div class="modal-header bg-warning text-dark">
                    <h4 class="modal-title">Edit Rekening Bank</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Bank</label>
                        <select class="form-control" name="nama_bank" required>
                            <option value="Bank Mandiri" <?= $data['nama_bank'] == 'Bank Mandiri' ? 'selected' : '' ?>>Bank Mandiri</option>
                            <option value="BNI" <?= $data['nama_bank'] == 'BNI' ? 'selected' : '' ?>>BNI</option>
                            <option value="BRI" <?= $data['nama_bank'] == 'BRI' ? 'selected' : '' ?>>BRI</option>
                            <option value="BCA" <?= $data['nama_bank'] == 'BCA' ? 'selected' : '' ?>>BCA</option>
                            <option value="BTN" <?= $data['nama_bank'] == 'BTN' ? 'selected' : '' ?>>BTN</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="no_rekening" value="<?= $data['no_rekening'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pemilik</label>
                        <input type="text" class="form-control" name="nama_pemilik" value="<?= $data['nama_pemilik'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Saldo Awal</label>
                        <input type="number" class="form-control" name="saldo_awal" value="<?= $data['saldo_awal'] ?>" required min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>