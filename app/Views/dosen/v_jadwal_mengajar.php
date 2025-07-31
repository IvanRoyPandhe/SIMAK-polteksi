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
                                    <td><?= $j['hari'] ?? 'Senin' ?></td>
                                    <td><?= $j['jam_mulai'] ?? '08:00' ?> - <?= $j['jam_selesai'] ?? '10:00' ?></td>
                                    <td><?= $j['nama_matkul'] ?></td>
                                    <td><?= $j['kelas'] ?? 'A' ?></td>
                                    <td><?= $j['ruangan'] ?? 'R101' ?></td>
                                    <td><?= $j['semester'] ?> - <?= $j['tahun_akademik'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada jadwal mengajar</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>