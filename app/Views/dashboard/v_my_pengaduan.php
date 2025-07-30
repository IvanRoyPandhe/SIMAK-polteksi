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
                <h4 class="card-title">Pengaduan Saya</h4>
                <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#pengaduanModal" style="background: linear-gradient(135deg, #dc2626, #ef4444); border: none;">
                    <i class="fas fa-plus"></i> Buat Pengaduan Baru
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($pengaduan)): ?>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50px">No</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pengaduan as $aduan) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <span class="badge bg-info"><?= $aduan['kategori'] ?? 'Umum' ?></span>
                                </td>
                                <td><?= $aduan['judul'] ?? $aduan['jenis_masalah'] ?? '-' ?></td>
                                <td>
                                    <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                                        <?= substr($aduan['masalah'], 0, 100) ?>...
                                    </div>
                                </td>
                                <td>
                                    <?php if ($aduan['status'] == 'Pending' || $aduan['status'] == '0'): ?>
                                        <span class="badge bg-warning">Menunggu</span>
                                    <?php elseif ($aduan['status'] == 'Proses' || $aduan['status'] == '1'): ?>
                                        <span class="badge bg-info">Diproses</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($aduan['created_at'])) ?></td>
                                <td>
                                    <?php if (!empty($aduan['jawaban'])): ?>
                                        <button class="btn btn-sm text-white" data-bs-toggle="modal" data-bs-target="#jawabanModal<?= $aduan['id_pengaduan'] ?>" style="background: linear-gradient(135deg, #dc2626, #ef4444); border: none;">
                                            <i class="fas fa-eye"></i> Lihat Jawaban
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted">Belum dijawab</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Pengaduan</h5>
                    <p class="text-muted">Anda belum pernah membuat pengaduan. Klik tombol di atas untuk membuat pengaduan baru.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Pengaduan Baru -->
<div class="modal fade" id="pengaduanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                <h5 class="modal-title">Buat Pengaduan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Dashboard/SubmitPengaduan') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_pengadu" class="form-control" value="<?= $user['nama'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori Pengaduan</label>
                    <select name="kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Fasilitas">Fasilitas</option>
                        <option value="Administrasi">Administrasi</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Pengaduan</label>
                    <input type="text" name="judul" class="form-control" required placeholder="Ringkasan singkat masalah Anda">
                </div>
                <div class="mb-3">
                    <label class="form-label">Detail Pengaduan</label>
                    <textarea name="masalah" class="form-control" rows="5" required placeholder="Jelaskan masalah atau keluhan Anda secara detail..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444); border: none;">Kirim Pengaduan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Jawaban untuk setiap pengaduan -->
<?php foreach ($pengaduan as $aduan) : ?>
    <?php if (!empty($aduan['jawaban'])): ?>
    <div class="modal fade" id="jawabanModal<?= $aduan['id_pengaduan'] ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Jawaban Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6 class="fw-bold">Judul Pengaduan:</h6>
                        <p><?= $aduan['judul'] ?? $aduan['jenis_masalah'] ?? '-' ?></p>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-bold">Pengaduan Anda:</h6>
                        <div class="bg-light p-3 rounded">
                            <?= nl2br($aduan['masalah']) ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-bold">Jawaban dari Admin:</h6>
                        <div class="bg-success bg-opacity-10 p-3 rounded border-start border-success border-3">
                            <?= nl2br($aduan['jawaban']) ?>
                        </div>
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-clock me-1"></i>
                        Dijawab pada: <?= date('d F Y, H:i', strtotime($aduan['updated_at'] ?? $aduan['created_at'])) ?> WIB
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<style>
.table td {
    vertical-align: middle;
}
.badge {
    font-size: 0.75em;
}
</style>