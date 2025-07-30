<div class="welcome-section text-white mb-4" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(220, 38, 38, 0.2);">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div class="mb-3 mb-md-0">
            <h3 class="mb-3 text-white">Selamat Datang, <?= $user['nama'] ?></h3>
            <p class="mb-0 text-white">Dashboard Petugas - Kelola operasional kampus dengan efisien</p>
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

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $total_mahasiswa ?></h4>
                        <p class="mb-0">Total Mahasiswa</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $total_dosen ?></h4>
                        <p class="mb-0">Total Dosen</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $beasiswa_aktif ?></h4>
                        <p class="mb-0">Beasiswa Aktif</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= count($pengaduan) ?></h4>
                        <p class="mb-0">Pengaduan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-question-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('Beasiswa') ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-graduation-cap mb-2"></i><br>
                            Kelola Beasiswa
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('Inventaris') ?>" class="btn btn-outline-success w-100">
                            <i class="fas fa-archive mb-2"></i><br>
                            Inventaris
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('Kegiatan') ?>" class="btn btn-outline-warning w-100">
                            <i class="fas fa-calendar-check mb-2"></i><br>
                            Kegiatan
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('Pengaduan') ?>" class="btn btn-outline-info w-100">
                            <i class="fas fa-question-circle mb-2"></i><br>
                            Pengaduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Beasiswa Aktif -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Beasiswa Aktif</h5>
                <a href="<?= base_url('Beasiswa') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (!empty($beasiswa)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Beasiswa</th>
                                    <th>Jenis</th>
                                    <th>Dana</th>
                                    <th>Kuota</th>
                                    <th>Batas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(array_slice($beasiswa, 0, 5) as $bea): ?>
                                <tr>
                                    <td><?= $bea['nama_beasiswa'] ?></td>
                                    <td><span class="badge bg-info"><?= $bea['jenis'] ?></span></td>
                                    <td>Rp <?= number_format($bea['jumlah_dana'], 0, ',', '.') ?></td>
                                    <td><?= $bea['kuota'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($bea['batas_pendaftaran'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Belum ada beasiswa aktif</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pengaduan Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($pengaduan)): ?>
                    <?php foreach(array_slice($pengaduan, 0, 3) as $aduan): ?>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-exclamation text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1"><?= $aduan['nama_pengadu'] ?></h6>
                            <p class="mb-1 small text-muted"><?= substr($aduan['masalah'], 0, 50) ?>...</p>
                            <small class="text-muted"><?= date('d/m/Y', strtotime($aduan['created_at'])) ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <a href="<?= base_url('Pengaduan') ?>" class="btn btn-sm btn-outline-primary w-100">Lihat Semua</a>
                <?php else: ?>
                    <p class="text-muted text-center">Tidak ada pengaduan</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>