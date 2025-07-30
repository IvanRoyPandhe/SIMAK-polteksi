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

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Informasi Beasiswa</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if (!empty($beasiswa)) : ?>
                            <?php foreach ($beasiswa as $item) : ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 border-left-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="card-title text-primary"><?= esc($item['nama_beasiswa']) ?></h5>
                                                <span class="badge bg-<?= $item['jenis'] == 'Prestasi' ? 'success' : ($item['jenis'] == 'Ekonomi' ? 'warning' : 'info') ?>">
                                                    <?= esc($item['jenis']) ?>
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <p class="text-muted mb-1"><i class="fas fa-money-bill-wave me-2"></i>Dana Beasiswa</p>
                                                <h6 class="text-success">Rp <?= number_format($item['jumlah_dana'], 0, ',', '.') ?></h6>
                                            </div>
                                            <div class="mb-3">
                                                <p class="text-muted mb-1"><i class="fas fa-users me-2"></i>Kuota</p>
                                                <span class="fw-bold"><?= $item['kuota'] ?> orang</span>
                                            </div>
                                            <div class="mb-3">
                                                <p class="text-muted mb-1"><i class="fas fa-calendar-alt me-2"></i>Batas Pendaftaran</p>
                                                <span class="fw-bold text-danger"><?= date('d F Y', strtotime($item['batas_pendaftaran'])) ?></span>
                                            </div>
                                            <?php if (!empty($item['persyaratan'])) : ?>
                                                <div class="mb-3">
                                                    <p class="text-muted mb-1"><i class="fas fa-list-check me-2"></i>Persyaratan</p>
                                                    <p class="small"><?= esc($item['persyaratan']) ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-<?= $item['status'] == 'Buka' ? 'success' : 'secondary' ?>">
                                                    <?= $item['status'] == 'Buka' ? 'Pendaftaran Buka' : 'Pendaftaran Tutup' ?>
                                                </span>
                                                <?php if ($item['status'] == 'Buka' && strtotime($item['batas_pendaftaran']) >= strtotime(date('Y-m-d'))) : ?>
                                                    <button class="btn btn-primary btn-sm" onclick="alert('Silakan hubungi admin kampus untuk mendaftar beasiswa ini.')">
                                                        <i class="fas fa-paper-plane me-1"></i>Daftar
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada informasi beasiswa tersedia</h5>
                                    <p class="text-muted">Silakan cek kembali nanti untuk informasi beasiswa terbaru</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}
.card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}
</style>