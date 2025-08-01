<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Informasi Beasiswa</h4>
        </div>
        <div class="card-body">
            <?php if (empty($beasiswa)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Belum ada informasi beasiswa tersedia.
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($beasiswa as $b): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><?= $b['nama_beasiswa'] ?></h5>
                                <small>
                                    <span class="badge bg-light text-dark"><?= $b['jenis'] ?></span>
                                    <span class="badge bg-<?= $b['status'] == 'Aktif' ? 'success' : 'secondary' ?>"><?= $b['status'] ?></span>
                                </small>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Jumlah Dana:</strong><br>
                                    <span class="text-success fs-5">Rp <?= number_format($b['jumlah_dana'], 0, ',', '.') ?></span>
                                </div>
                                
                                <?php if ($b['kuota']): ?>
                                <div class="mb-3">
                                    <strong>Kuota:</strong> <?= $b['kuota'] ?> mahasiswa
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($b['batas_pendaftaran']): ?>
                                <div class="mb-3">
                                    <strong>Batas Pendaftaran:</strong><br>
                                    <span class="text-danger"><?= date('d F Y', strtotime($b['batas_pendaftaran'])) ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($b['persyaratan']): ?>
                                <div class="mb-3">
                                    <strong>Persyaratan:</strong><br>
                                    <div class="text-muted"><?= nl2br($b['persyaratan']) ?></div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($b['status'] == 'Aktif'): ?>
                            <div class="card-footer">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Hubungi bagian akademik untuk informasi pendaftaran
                                </small>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>