<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-info text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Laporan KRS</h4>
                <button class="btn btn-light btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Laporan
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Summary Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4><?= $total_krs ?></h4>
                            <small>Total KRS</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4><?= count(array_filter($krs_data, fn($k) => $k['status'] == 'Disetujui')) ?></h4>
                            <small>KRS Disetujui</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4><?= count(array_unique(array_column($krs_data, 'mahasiswa_id'))) ?></h4>
                            <small>Mahasiswa Terdaftar</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Detail -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-info">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        $grouped_data = [];
                        
                        // Group by mahasiswa
                        foreach ($krs_data as $krs) {
                            $grouped_data[$krs['mahasiswa_id']]['info'] = [
                                'nim' => $krs['nim'],
                                'nama' => $krs['nama_mahasiswa'],
                                'semester_aktif' => $krs['semester_aktif']
                            ];
                            $grouped_data[$krs['mahasiswa_id']]['matkul'][] = $krs;
                        }
                        
                        foreach ($grouped_data as $mahasiswa_id => $data):
                            $first_row = true;
                            $total_sks = array_sum(array_column($data['matkul'], 'sks'));
                            foreach ($data['matkul'] as $matkul):
                        ?>
                        <tr>
                            <?php if ($first_row): ?>
                            <td rowspan="<?= count($data['matkul']) ?>"><?= $no++ ?></td>
                            <td rowspan="<?= count($data['matkul']) ?>"><?= $data['info']['nim'] ?></td>
                            <td rowspan="<?= count($data['matkul']) ?>">
                                <strong><?= $data['info']['nama'] ?></strong><br>
                                <small class="text-muted">Total SKS: <?= $total_sks ?></small>
                            </td>
                            <?php $first_row = false; endif; ?>
                            <td><?= $matkul['kode_matkul'] ?> - <?= $matkul['nama_matkul'] ?></td>
                            <td class="text-center"><?= $matkul['sks'] ?></td>
                            <td class="text-center"><?= $data['info']['semester_aktif'] ?></td>
                            <td class="text-center">
                                <?php if ($matkul['status'] == 'Disetujui'): ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php elseif ($matkul['status'] == 'Pending' || $matkul['status'] == 'Menunggu Persetujuan'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($matkul['tgl_pengajuan'] ?? $matkul['created_at'])) ?></td>
                        </tr>
                        <?php 
                            endforeach;
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Rekap per Mata Kuliah -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Rekap Peserta per Mata Kuliah</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Kode MK</th>
                                    <th>Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Jumlah Peserta</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $matkul_count = [];
                                foreach ($krs_data as $krs) {
                                    $key = $krs['kode_matkul'];
                                    if (!isset($matkul_count[$key])) {
                                        $matkul_count[$key] = [
                                            'kode' => $krs['kode_matkul'],
                                            'nama' => $krs['nama_matkul'],
                                            'sks' => $krs['sks'],
                                            'count' => 0,
                                            'disetujui' => 0
                                        ];
                                    }
                                    $matkul_count[$key]['count']++;
                                    if ($krs['status'] == 'Disetujui') {
                                        $matkul_count[$key]['disetujui']++;
                                    }
                                }
                                
                                foreach ($matkul_count as $mk):
                                ?>
                                <tr>
                                    <td><?= $mk['kode'] ?></td>
                                    <td><?= $mk['nama'] ?></td>
                                    <td class="text-center"><?= $mk['sks'] ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary"><?= $mk['count'] ?></span>
                                        <small class="text-muted">(<?= $mk['disetujui'] ?> disetujui)</small>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($mk['count'] >= 20): ?>
                                            <span class="badge bg-success">Optimal</span>
                                        <?php elseif ($mk['count'] >= 10): ?>
                                            <span class="badge bg-warning">Cukup</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Kurang</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="row mt-4">
                <div class="col-md-12 text-end">
                    <p class="text-muted">
                        Laporan dicetak pada: <?= date('d F Y H:i:s') ?><br>
                        <small>Sistem Informasi Akademik POLTEKSI</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header .btn {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    body {
        font-size: 12px;
    }
}
</style>