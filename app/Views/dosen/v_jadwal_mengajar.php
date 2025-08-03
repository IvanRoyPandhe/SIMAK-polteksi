<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title mb-0">Jadwal Mengajar</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-info">
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>Ruangan</th>
                            <th>Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($jadwal)): ?>
                            <?php foreach ($jadwal as $j): ?>
                                <tr>
                                    <td><span class="badge bg-primary"><?= $j['hari'] ?? 'Belum dijadwalkan' ?></span></td>
                                    <td><strong><?= $j['jam_mulai'] ?? '08:00' ?> - <?= $j['jam_selesai'] ?? '10:00' ?></strong></td>
                                    <td>
                                        <div><strong><?= $j['nama_matkul'] ?></strong></div>
                                        <small class="text-muted"><?= $j['kode_matkul'] ?> (<?= $j['sks'] ?> SKS)</small>
                                    </td>
                                    <td><span class="badge bg-success"><?= $j['nama_kelas'] ?? 'Kelas A' ?></span></td>
                                    <td><i class="fas fa-door-open me-1"></i><?= $j['ruangan'] ?? 'Belum ditentukan' ?></td>
                                    <td>
                                        <div><?= $j['semester'] ?></div>
                                        <small class="text-muted"><?= $j['tahun_akademik'] ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
                                    <div class="text-muted">Belum ada jadwal mengajar untuk semester ini</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>