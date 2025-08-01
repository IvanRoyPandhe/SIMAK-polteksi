<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Kategori Keuangan</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Kategori
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
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h3><?= count(array_filter($kategori, fn($k) => $k['jenis'] == 'Pemasukan')) ?></h3>
                            <p class="mb-0">Kategori Pemasukan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h3><?= count(array_filter($kategori, fn($k) => $k['jenis'] == 'Pengeluaran')) ?></h3>
                            <p class="mb-0">Kategori Pengeluaran</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Kategori</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($kategori as $data): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><code><?= $data['kode_kategori'] ?></code></td>
                            <td><?= $data['nama_kategori'] ?></td>
                            <td>
                                <?php if ($data['jenis'] == 'Pemasukan'): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-arrow-up"></i> Pemasukan
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-arrow-down"></i> Pengeluaran
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($data['is_active']): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit<?= $data['id_kategori'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" 
                                        data-id="<?= $data['id_kategori'] ?>" 
                                        data-name="<?= $data['nama_kategori'] ?>" 
                                        data-type="kategori-keuangan">
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
            <form action="<?= base_url('KasInternal/InsertKategori') ?>" method="post">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Tambah Kategori Keuangan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kategori</label>
                        <input type="text" class="form-control" name="kode_kategori" required placeholder="PM001 atau PK001">
                        <small class="text-muted">PM untuk Pemasukan, PK untuk Pengeluaran</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategori" required placeholder="Nama kategori">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-control" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
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
<?php foreach ($kategori as $data): ?>
<div class="modal fade" id="modal-edit<?= $data['id_kategori'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('KasInternal/UpdateKategori/' . $data['id_kategori']) ?>" method="post">
                <div class="modal-header bg-warning text-dark">
                    <h4 class="modal-title">Edit Kategori Keuangan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kategori</label>
                        <input type="text" class="form-control" name="kode_kategori" value="<?= $data['kode_kategori'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategori" value="<?= $data['nama_kategori'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-control" name="jenis" required>
                            <option value="Pemasukan" <?= $data['jenis'] == 'Pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
                            <option value="Pengeluaran" <?= $data['jenis'] == 'Pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                        </select>
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