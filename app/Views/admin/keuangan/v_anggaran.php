<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manajemen Anggaran</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Anggaran
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
                            <th>Periode</th>
                            <th>Kategori</th>
                            <th>Anggaran</th>
                            <th>Terpakai</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($anggaran as $data): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['semester'] ?? 'Ganjil' ?> <?= $data['tahun_akademik'] ?? '2024/2025' ?></td>
                            <td><span class="badge bg-info"><?= $data['nama_kategori'] ?? 'Kategori' ?></span></td>
                            <td>Rp <?= number_format($data['jumlah_anggaran'] ?? 0, 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($data['jumlah_terpakai'] ?? 0, 0, ',', '.') ?></td>
                            <td>Rp <?= number_format(($data['jumlah_anggaran'] ?? 0) - ($data['jumlah_terpakai'] ?? 0), 0, ',', '.') ?></td>
                            <td>
                                <?php 
                                $status = $data['status'] ?? 'Draft';
                                $badgeClass = $status == 'Active' ? 'success' : ($status == 'Approved' ? 'primary' : 'secondary');
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>"><?= $status ?></span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit<?= $data['id_anggaran'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" 
                                        data-id="<?= $data['id_anggaran'] ?>" 
                                        data-name="<?= $data['nama_kategori'] ?>" 
                                        data-type="anggaran">
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
            <form action="<?= base_url('KasInternal/InsertAnggaran') ?>" method="post">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Tambah Anggaran</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Periode Akademik</label>
                        <select class="form-control" name="periode_id" required>
                            <option value="">Pilih Periode</option>
                            <?php foreach ($periode as $p): ?>
                                <option value="<?= $p['id_periode'] ?>"><?= $p['semester'] ?> <?= $p['tahun_akademik'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Anggaran</label>
                        <input type="number" class="form-control" name="jumlah_anggaran" required placeholder="0" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
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
<?php foreach ($anggaran as $data): ?>
<div class="modal fade" id="modal-edit<?= $data['id_anggaran'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('KasInternal/UpdateAnggaran/' . $data['id_anggaran']) ?>" method="post">
                <div class="modal-header bg-warning text-dark">
                    <h4 class="modal-title">Edit Anggaran</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Periode Akademik</label>
                        <select class="form-control" name="periode_id" required>
                            <?php foreach ($periode as $p): ?>
                                <option value="<?= $p['id_periode'] ?>" <?= $data['periode_id'] == $p['id_periode'] ? 'selected' : '' ?>>
                                    <?= $p['semester'] ?> <?= $p['tahun_akademik'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="kategori_id" required>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>" <?= $data['kategori_id'] == $k['id_kategori'] ? 'selected' : '' ?>>
                                    <?= $k['nama_kategori'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Anggaran</label>
                        <input type="number" class="form-control" name="jumlah_anggaran" value="<?= $data['jumlah_anggaran'] ?>" required min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"><?= $data['keterangan'] ?></textarea>
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