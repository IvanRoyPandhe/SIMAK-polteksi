<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title mb-0">Laporan Nilai</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Nilai Akhir</th>
                            <th>Huruf</th>
                            <th>Bobot</th>
                            <th>Periode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($nilai as $data): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['kode_matkul'] ?></td>
                            <td><?= $data['nama_matkul'] ?></td>
                            <td class="text-center"><?= $data['sks'] ?></td>
                            <td class="text-center"><?= number_format($data['nilai_tugas'], 1) ?></td>
                            <td class="text-center"><?= number_format($data['nilai_uts'], 1) ?></td>
                            <td class="text-center"><?= number_format($data['nilai_uas'], 1) ?></td>
                            <td class="text-center"><strong><?= number_format($data['nilai_akhir'], 1) ?></strong></td>
                            <td class="text-center">
                                <span class="badge bg-<?= $data['nilai_huruf'] == 'A' ? 'success' : ($data['nilai_huruf'] == 'B' || $data['nilai_huruf'] == 'B+' || $data['nilai_huruf'] == 'A-' ? 'primary' : ($data['nilai_huruf'] == 'C' || $data['nilai_huruf'] == 'C+' || $data['nilai_huruf'] == 'B-' ? 'warning' : 'danger')) ?>">
                                    <?= $data['nilai_huruf'] ?>
                                </span>
                            </td>
                            <td class="text-center"><?= number_format($data['bobot'], 2) ?></td>
                            <td class="text-center"><?= $data['semester'] ?> <?= $data['tahun_akademik'] ?></td>
                            <td class="text-center">
                                <?php if ($data['status'] == 'Final'): ?>
                                    <span class="badge bg-success">Final</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Draft</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Ringkasan Nilai</h6>
                            <?php 
                            $total_sks = 0;
                            $total_bobot = 0;
                            foreach ($nilai as $data) {
                                if ($data['status'] == 'Final') {
                                    $total_sks += $data['sks'];
                                    $total_bobot += ($data['bobot'] * $data['sks']);
                                }
                            }
                            $ipk = $total_sks > 0 ? $total_bobot / $total_sks : 0;
                            ?>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td>Total SKS</td>
                                    <td>: <strong><?= $total_sks ?> SKS</strong></td>
                                </tr>
                                <tr>
                                    <td>IPK</td>
                                    <td>: <strong class="text-<?= $ipk >= 3.5 ? 'success' : ($ipk >= 3.0 ? 'warning' : 'danger') ?>"><?= number_format($ipk, 2) ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Mata Kuliah Lulus</td>
                                    <td>: <strong><?= count(array_filter($nilai, fn($n) => $n['status'] == 'Final' && $n['nilai_huruf'] != 'E')) ?></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h6 class="card-title">Keterangan Nilai</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small>
                                        A = 85-100 (4.00)<br>
                                        A- = 80-84 (3.70)<br>
                                        B+ = 75-79 (3.30)<br>
                                        B = 70-74 (3.00)
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small>
                                        B- = 65-69 (2.70)<br>
                                        C+ = 60-64 (2.30)<br>
                                        C = 55-59 (2.00)<br>
                                        D = 45-54 (1.00)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>