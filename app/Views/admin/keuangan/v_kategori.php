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
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm">
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
                <h4 class="modal-title">Tambah Kategori Keuangan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text" class="form-control" required placeholder="PM001 atau PK001">
                    <small class="text-muted">PM untuk Pemasukan, PK untuk Pengeluaran</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" required placeholder="Nama kategori">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-control" required>
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
        </div>
    </div>
</div>