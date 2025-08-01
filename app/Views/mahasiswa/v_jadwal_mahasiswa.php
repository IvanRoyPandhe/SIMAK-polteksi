<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Jadwal Kuliah</h4>
        </div>
        <div class="card-body">
            <?php if (empty($jadwal)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Belum ada mata kuliah yang diambil atau KRS belum disetujui.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode MK</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($jadwal as $j): ?>
                            <tr>
                                <td><?= $no++ ?></td>
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