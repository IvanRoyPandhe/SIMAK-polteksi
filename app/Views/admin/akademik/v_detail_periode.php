<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Detail Periode <?= $periode['semester'] . ' ' . $periode['tahun_akademik'] ?></h4>
                <?php if ($periode['is_active']): ?>
                    <span class="badge bg-success">Periode Aktif</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Semester</strong></td>
                                <td>: <?= $periode['semester'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tahun Akademik</strong></td>
                                <td>: <?= $periode['tahun_akademik'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Periode KRS</strong></td>
                                <td>: <?= date('d M Y', strtotime($periode['tgl_mulai_krs'])) ?> - <?= date('d M Y', strtotime($periode['tgl_selesai_krs'])) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Periode Kuliah</strong></td>
                                <td>: <?= $periode['tgl_mulai_kuliah'] ? date('d M Y', strtotime($periode['tgl_mulai_kuliah'])) . ' - ' . date('d M Y', strtotime($periode['tgl_selesai_kuliah'])) : 'Belum diset' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>UTS</strong></td>
                                <td>: <?= $periode['tgl_uts_mulai'] ? date('d M Y', strtotime($periode['tgl_uts_mulai'])) . ' - ' . date('d M Y', strtotime($periode['tgl_uts_selesai'])) : 'Belum diset' ?></td>
                            </tr>
                            <tr>
                                <td><strong>UAS</strong></td>
                                <td>: <?= $periode['tgl_uas_mulai'] ? date('d M Y', strtotime($periode['tgl_uas_mulai'])) . ' - ' . date('d M Y', strtotime($periode['tgl_uas_selesai'])) : 'Belum diset' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Max SKS Normal</strong></td>
                                <td>: <?= $periode['max_sks_normal'] ?? 24 ?> SKS</td>
                            </tr>
                            <tr>
                                <td><strong>Max SKS Remedial</strong></td>
                                <td>: <?= $periode['max_sks_remedial'] ?? 12 ?> SKS</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php if ($periode['keterangan']): ?>
                <div class="mt-3">
                    <strong>Keterangan:</strong>
                    <p class="text-muted"><?= nl2br($periode['keterangan']) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Timeline Akademik</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php foreach ($jadwal_penting as $jadwal): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-<?= $jadwal['status'] == 'active' ? 'success' : ($jadwal['status'] == 'upcoming' ? 'warning' : 'secondary') ?>"></div>
                        <div class="timeline-content">
                            <h6><?= $jadwal['nama'] ?></h6>
                            <p class="text-muted mb-1"><?= $jadwal['tanggal'] ?></p>
                            <span class="badge bg-<?= $jadwal['status'] == 'active' ? 'success' : ($jadwal['status'] == 'upcoming' ? 'warning' : 'secondary') ?>">
                                <?= $jadwal['status'] == 'active' ? 'Berlangsung' : ($jadwal['status'] == 'upcoming' ? 'Akan Datang' : 'Selesai') ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Periode</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Total Mahasiswa KRS</span>
                        <strong><?= $statistik['total_mahasiswa'] ?></strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>KRS Disetujui</span>
                        <strong class="text-success"><?= $statistik['krs_disetujui'] ?></strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>KRS Pending</span>
                        <strong class="text-warning"><?= $statistik['krs_pending'] ?></strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Total Kelas</span>
                        <strong><?= $statistik['total_kelas'] ?></strong>
                    </div>
                </div>
                
                <hr>
                
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" style="width: <?= $statistik['total_mahasiswa'] > 0 ? ($statistik['krs_disetujui'] / $statistik['total_mahasiswa']) * 100 : 0 ?>%"></div>
                </div>
                <small class="text-muted">Progress Approval KRS: <?= $statistik['total_mahasiswa'] > 0 ? round(($statistik['krs_disetujui'] / $statistik['total_mahasiswa']) * 100, 1) : 0 ?>%</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if (!$periode['is_active']): ?>
                    <a href="<?= base_url('PeriodeAkademik/SetAktif/' . $periode['id_periode']) ?>" class="btn btn-success">
                        <i class="fas fa-play"></i> Aktifkan Periode
                    </a>
                    <?php endif; ?>
                    
                    <button class="btn btn-primary" onclick="exportKalender(<?= $periode['id_periode'] ?>)">
                        <i class="fas fa-calendar-alt"></i> Export Kalender
                    </button>
                    
                    <a href="<?= base_url('PeriodeAkademik') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 3px solid #dee2e6;
}
</style>

<script>
function exportKalender(periodeId) {
    window.open('<?= base_url('PeriodeAkademik/GenerateKalender/') ?>' + periodeId, '_blank');
}
</script>