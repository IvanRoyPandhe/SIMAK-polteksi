<div class="col-md-12">
    <div class="welcome-section text-white mb-4" style="background: linear-gradient(135deg, #dc2626, #ef4444); padding: 2rem; border-radius: 10px;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-2">Selamat Datang, <?= $user['nama'] ?? 'Mahasiswa' ?></h3>
                <p class="mb-0">Portal Akademik Mahasiswa - SIMAK POLTEKSI</p>
            </div>
            <div class="text-end">
                <p class="mb-1"><i class="far fa-calendar me-2"></i><?= date('d F Y') ?></p>
                <p class="mb-0"><i class="far fa-clock me-2"></i>Semester Ganjil 2024/2025</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6>IPK Kumulatif</h6>
                            <h3><?= isset($mahasiswa['ipk']) ? number_format($mahasiswa['ipk'], 2) : '0.00' ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6>SKS Lulus</h6>
                            <h3><?= isset($mahasiswa['sks_lulus']) ? $mahasiswa['sks_lulus'] : '0' ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6>Semester</h6>
                            <h3><?= isset($mahasiswa['semester_aktif']) ? $mahasiswa['semester_aktif'] : '1' ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6>Status Akademik</h6>
                            <h3><?= isset($mahasiswa['status_akademik']) ? $mahasiswa['status_akademik'] : 'Aktif' ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Mata Kuliah yang Diambil</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($jadwal)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada mata kuliah yang diambil atau KRS belum disetujui.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode MK</th>
                                        <th>Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Dosen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($jadwal as $j): ?>
                                    <tr>
                                        <td><?= $j['kode_matkul'] ?></td>
                                        <td><?= $j['nama_matkul'] ?></td>
                                        <td><?= $j['sks'] ?></td>
                                        <td><?= $j['nama_dosen'] ?? 'Belum ditentukan' ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('Dashboard/Mahasiswa/KRS') ?>" class="btn btn-primary">
                            <i class="fas fa-file-alt me-2"></i>Kelola KRS
                        </a>
                        <a href="<?= base_url('Dashboard/Mahasiswa/KHS') ?>" class="btn btn-success">
                            <i class="fas fa-chart-line me-2"></i>Lihat KHS
                        </a>
                        <a href="<?= base_url('Beasiswa') ?>" class="btn btn-warning">
                            <i class="fas fa-graduation-cap me-2"></i>Info Beasiswa
                        </a>
                        <a href="<?= base_url('Pengaduan') ?>" class="btn btn-info">
                            <i class="fas fa-question-circle me-2"></i>Pengaduan
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Pengumuman</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Periode KRS Dibuka!</strong><br>
                        Periode pengisian KRS semester Ganjil 2024/2025 telah dibuka hingga 31 Desember 2024.
                    </div>
                    <div class="alert alert-info">
                        <strong>Jadwal UTS</strong><br>
                        Ujian Tengah Semester akan dilaksanakan pada tanggal 15-20 Januari 2025.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>