<div class="col-md-12">
    <div class="welcome-section text-white mb-4" style="background: linear-gradient(135deg, #dc2626, #ef4444); padding: 2rem; border-radius: 10px;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-2">Selamat Datang, <?= $user['nama'] ?? 'Dosen' ?></h3>
                <p class="mb-0">Portal Dosen - SIMAK POLTEKSI</p>
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
                            <h6>Mahasiswa Bimbingan</h6>
                            <h3><?= $stats['mahasiswa_bimbingan'] ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
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
                            <h6>KRS Pending</h6>
                            <h3><?= $stats['krs_pending'] ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
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
                            <h6>Mata Kuliah Diampu</h6>
                            <h3><?= $stats['mata_kuliah'] ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x"></i>
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
                            <h6>Konsultasi Pending</h6>
                            <h3><?= $stats['konsultasi_pending'] ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-comments fa-2x"></i>
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
                    <h5>Jadwal Mengajar Hari Ini</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Mata Kuliah</th>
                                    <th>Kelas</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>08:00 - 10:30</td>
                                    <td>Pemrograman Web</td>
                                    <td>TI-3A</td>
                                    <td>Lab Komputer 1</td>
                                </tr>
                                <tr>
                                    <td>13:00 - 15:30</td>
                                    <td>Basis Data</td>
                                    <td>TI-3B</td>
                                    <td>Lab Komputer 2</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                        <a href="<?= base_url('Dashboard/Dosen/JadwalMengajar') ?>" class="btn btn-primary">
                            <i class="fas fa-calendar-alt me-2"></i>Jadwal Mengajar
                        </a>
                        <a href="<?= base_url('Dashboard/Dosen/ApprovalKRS') ?>" class="btn btn-warning">
                            <i class="fas fa-check-circle me-2"></i>Approval KRS
                        </a>
                        <a href="<?= base_url('Dashboard/Dosen/InputNilai') ?>" class="btn btn-success">
                            <i class="fas fa-edit me-2"></i>Input Nilai
                        </a>
                        <a href="<?= base_url('Dashboard/Dosen/Absensi') ?>" class="btn btn-info">
                            <i class="fas fa-clipboard-check me-2"></i>Absensi
                        </a>
                        <a href="<?= base_url('Dashboard/Dosen/MateriKuliah') ?>" class="btn btn-secondary">
                            <i class="fas fa-file-pdf me-2"></i>Upload Materi
                        </a>
                        <a href="<?= base_url('Dashboard/Dosen/Konsultasi') ?>" class="btn btn-dark">
                            <i class="fas fa-comments me-2"></i>Konsultasi
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>KRS Menunggu Approval</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Budi Santoso</strong><br>
                                <small class="text-muted">2021001 - 18 SKS</small>
                            </div>
                            <span class="badge bg-warning">Pending</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Ahmad Rizki</strong><br>
                                <small class="text-muted">2021003 - 21 SKS</small>
                            </div>
                            <span class="badge bg-warning">Pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>