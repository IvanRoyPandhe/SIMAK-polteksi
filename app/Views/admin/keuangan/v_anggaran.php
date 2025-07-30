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
                <h4 class="modal-title">Tambah Anggaran</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Periode Akademik</label>
                    <select class="form-control" required>
                        <option value="">Pilih Periode</option>
                        <option value="1">Ganjil 2024/2025</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="1">Gaji & Tunjangan Dosen</option>
                        <option value="2">Operasional Kampus</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Anggaran</label>
                    <input type="number" class="form-control" required placeholder="0">
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>