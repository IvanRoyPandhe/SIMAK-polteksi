<div class="welcome-section text-white mb-4" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(220, 38, 38, 0.2);">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div class="mb-3 mb-md-0">
            <h3 class="mb-3 text-white">Selamat Datang, <?= $user['nama'] ?></h3>
            <p class="mb-0 text-white">Portal Mahasiswa - Akses informasi akademik dan layanan kampus</p>
        </div>
        <div class="text-end">
            <p class="mb-1 text-white"><i class="far fa-calendar me-2"></i>
                <?php
                $date = new DateTime();
                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                echo $formatter->format($date);
                ?>
            </p>
        </div>
    </div>
</div>

<!-- Pengaduan Khusus Mahasiswa -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-comment-dots me-2"></i>Layanan Pengaduan Mahasiswa</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Sampaikan keluhan, saran, atau masalah akademik Anda kepada pihak kampus.</p>
                <a href="<?= base_url('Dashboard/MyPengaduan') ?>" class="btn btn-warning">
                    <i class="fas fa-list me-2"></i>Lihat Pengaduan Saya
                </a>
                <button class="btn btn-outline-warning ms-2" data-bs-toggle="modal" data-bs-target="#pengaduanModal">
                    <i class="fas fa-paper-plane me-2"></i>Buat Pengaduan Baru
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Cards -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card bg-gradient-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                <h5>Beasiswa</h5>
                <p class="mb-3"><?= $total_beasiswa ?> Beasiswa Tersedia</p>
                <a href="<?= base_url('Beasiswa') ?>" class="btn btn-light btn-sm">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card bg-gradient-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-newspaper fa-3x mb-3"></i>
                <h5>Artikel</h5>
                <p class="mb-3">Berita & Info Kampus</p>
                <a href="<?= base_url('Artikel') ?>" class="btn btn-light btn-sm">Baca Artikel</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card bg-gradient-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-3x mb-3"></i>
                <h5>Kegiatan</h5>
                <p class="mb-3">Event & Pengumuman</p>
                <a href="<?= base_url('Kegiatan') ?>" class="btn btn-light btn-sm">Lihat Kegiatan</a>
            </div>
        </div>
    </div>
</div>

<!-- Beasiswa Aktif -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Beasiswa Tersedia</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($beasiswa_aktif)): ?>
                    <div class="row">
                        <?php foreach(array_slice($beasiswa_aktif, 0, 4) as $bea): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card border-left-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title text-primary"><?= $bea['nama_beasiswa'] ?></h6>
                                        <span class="badge bg-<?= $bea['jenis'] == 'Prestasi' ? 'success' : 'info' ?>"><?= $bea['jenis'] ?></span>
                                    </div>
                                    <p class="text-success mb-2"><strong>Rp <?= number_format($bea['jumlah_dana'], 0, ',', '.') ?></strong></p>
                                    <p class="small text-muted mb-2">Kuota: <?= $bea['kuota'] ?> orang</p>
                                    <p class="small text-danger mb-3">Batas: <?= date('d F Y', strtotime($bea['batas_pendaftaran'])) ?></p>
                                    <button class="btn btn-primary btn-sm w-100" onclick="alert('Silakan hubungi admin untuk mendaftar beasiswa ini.')">
                                        <i class="fas fa-paper-plane me-1"></i>Daftar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center">
                        <a href="<?= base_url('Beasiswa') ?>" class="btn btn-outline-primary">Lihat Semua Beasiswa</a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada beasiswa tersedia saat ini</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Pengumuman Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($pengumuman)): ?>
                    <?php foreach(array_slice($pengumuman, 0, 5) as $announce): ?>
                    <div class="d-flex mb-3 pb-3 border-bottom">
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-bullhorn text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1"><?= $announce['judul'] ?></h6>
                            <p class="mb-1 small text-muted"><?= substr(strip_tags($announce['isi']), 0, 60) ?>...</p>
                            <small class="text-muted"><?= date('d/m/Y', strtotime($announce['tgl'])) ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <a href="<?= base_url('Kegiatan') ?>" class="btn btn-sm btn-outline-success w-100">Lihat Semua</a>
                <?php else: ?>
                    <p class="text-muted text-center">Tidak ada pengumuman</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Artikel Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Artikel Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($artikel)): ?>
                    <div class="row">
                        <?php foreach(array_slice($artikel, 0, 3) as $art): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <?php if($art['thumbnail']): ?>
                                <img src="<?= base_url('uploaded/thumbnail_artikel/' . $art['thumbnail']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="card-body">
                                    <span class="badge bg-primary mb-2"><?= $art['nama_kategori'] ?></span>
                                    <h6 class="card-title"><?= $art['judul'] ?></h6>
                                    <p class="card-text small text-muted"><?= substr(strip_tags($art['isi']), 0, 100) ?>...</p>
                                    <small class="text-muted"><?= date('d F Y', strtotime($art['created_at'])) ?></small>
                                </div>
                                <div class="card-footer">
                                    <a href="<?= base_url('Home/DetailArtikel/' . $art['slug']) ?>" class="btn btn-sm btn-outline-primary w-100">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center">
                        <a href="<?= base_url('Artikel') ?>" class="btn btn-outline-warning">Lihat Semua Artikel</a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada artikel tersedia</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pengaduan -->
<div class="modal fade" id="pengaduanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Form Pengaduan Mahasiswa</h5>
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
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Pengaduan</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Detail Pengaduan</label>
                    <textarea name="masalah" class="form-control" rows="5" required placeholder="Jelaskan masalah atau keluhan Anda secara detail..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-warning">Kirim Pengaduan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #dc2626, #b91c1c);
}
.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #1e7e34);
}
.bg-gradient-warning {
    background: linear-gradient(45deg, #f59e0b, #d97706);
}
.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #138496);
}
.border-left-primary {
    border-left: 4px solid #dc2626 !important;
}
.card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>