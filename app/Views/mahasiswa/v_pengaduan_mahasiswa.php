<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Pengaduan Saya</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buatPengaduanModal">
                    <i class="fas fa-plus"></i> Buat Pengaduan
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($pengaduan)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Anda belum memiliki pengaduan.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pengaduan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                                <td>
                                    <strong><?= $p['jenis_masalah'] ?></strong><br>
                                    <small class="text-muted"><?= substr($p['masalah'], 0, 100) ?>...</small>
                                </td>
                                <td>
                                    <?php if ($p['status'] == 0): ?>
                                        <span class="badge bg-warning">Menunggu</span>
                                    <?php elseif ($p['status'] == 1): ?>
                                        <span class="badge bg-info">Diproses</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($p['jawaban']): ?>
                                        <div class="alert alert-success mb-0">
                                            <strong>Dijawab oleh: <?= $p['nama_penjawab'] ?></strong><br>
                                            <?= $p['jawaban'] ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Belum dijawab</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Buat Pengaduan -->
<div class="modal fade" id="buatPengaduanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Pengaduan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Pengaduan/BuatPengaduan') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Judul Pengaduan</label>
                    <input type="text" name="judul" class="form-control" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label class="form-label">Isi Pengaduan</label>
                    <textarea name="isi_pengaduan" class="form-control" rows="5" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>