<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-success text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Transkrip Nilai</h4>
                <button class="btn btn-light btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Transkrip
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Header Transkrip -->
            <div class="text-center mb-4">
                <h4 class="text-primary">TRANSKRIP NILAI AKADEMIK</h4>
                <h5>POLITEKNIK SIBER DAN SANDI NEGARA</h5>
                <hr>
            </div>

            <div class="row mb-4">
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150px"><strong>NIM</strong></td>
                            <td>: <?= $mahasiswa['nim'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>: <?= $mahasiswa['nama'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Program Studi</strong></td>
                            <td>: <?= $mahasiswa['nama_prodi'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tahun Angkatan</strong></td>
                            <td>: <?= $mahasiswa['tahun_angkatan'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: <?= $mahasiswa['status_akademik'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-end">
                    <img src="<?= base_url('uploaded/mahasiswa/' . ($mahasiswa['foto'] ?? 'default.jpg')) ?>" 
                         class="img-fluid rounded border" style="width: 120px; height: 150px; object-fit: cover;">
                </div>
            </div>

            <!-- Tabel Nilai -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th width="50px" class="text-center">No</th>
                            <th width="80px">Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th width="60px" class="text-center">SKS</th>
                            <th width="80px" class="text-center">Nilai</th>
                            <th width="60px" class="text-center">Huruf</th>
                            <th width="60px" class="text-center">Bobot</th>
                            <th width="100px" class="text-center">Periode</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        $total_sks = 0;
                        $total_bobot = 0;
                        foreach ($nilai as $data): 
                            if ($data['status'] == 'Final') {
                                $total_sks += $data['sks'];
                                $total_bobot += ($data['bobot'] * $data['sks']);
                            }
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $data['kode_matkul'] ?></td>
                            <td><?= $data['nama_matkul'] ?></td>
                            <td class="text-center"><?= $data['sks'] ?></td>
                            <td class="text-center"><?= number_format($data['nilai_akhir'], 1) ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= $data['nilai_huruf'] == 'A' ? 'success' : ($data['nilai_huruf'] == 'B' || $data['nilai_huruf'] == 'B+' || $data['nilai_huruf'] == 'A-' ? 'primary' : ($data['nilai_huruf'] == 'C' || $data['nilai_huruf'] == 'C+' || $data['nilai_huruf'] == 'B-' ? 'warning' : 'danger')) ?>">
                                    <?= $data['nilai_huruf'] ?>
                                </span>
                            </td>
                            <td class="text-center"><?= number_format($data['bobot'], 2) ?></td>
                            <td class="text-center"><?= $data['semester'] ?> <?= $data['tahun_akademik'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="3" class="text-end">TOTAL</th>
                            <th class="text-center"><?= $total_sks ?></th>
                            <th colspan="4"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Summary -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Ringkasan Akademik</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>Total SKS Lulus</td>
                                            <td>: <strong><?= $total_sks ?> SKS</strong></td>
                                        </tr>
                                        <tr>
                                            <td>IPK (Indeks Prestasi Kumulatif)</td>
                                            <td>: <strong class="text-<?= $mahasiswa['ipk'] >= 3.5 ? 'success' : ($mahasiswa['ipk'] >= 3.0 ? 'warning' : 'danger') ?>"><?= number_format($mahasiswa['ipk'], 2) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Semester Aktif</td>
                                            <td>: <strong><?= $mahasiswa['semester_aktif'] ?></strong></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <h5>Predikat Kelulusan</h5>
                                        <?php 
                                        $predikat = '';
                                        $color = '';
                                        if ($mahasiswa['ipk'] >= 3.51) {
                                            $predikat = 'Cum Laude';
                                            $color = 'success';
                                        } elseif ($mahasiswa['ipk'] >= 3.01) {
                                            $predikat = 'Sangat Memuaskan';
                                            $color = 'primary';
                                        } elseif ($mahasiswa['ipk'] >= 2.76) {
                                            $predikat = 'Memuaskan';
                                            $color = 'warning';
                                        } else {
                                            $predikat = 'Cukup';
                                            $color = 'secondary';
                                        }
                                        ?>
                                        <span class="badge bg-<?= $color ?> fs-6"><?= $predikat ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h6 class="card-title">Keterangan Nilai</h6>
                            <small>
                                A = 85-100 (4.00) | A- = 80-84 (3.70)<br>
                                B+ = 75-79 (3.30) | B = 70-74 (3.00)<br>
                                B- = 65-69 (2.70) | C+ = 60-64 (2.30)<br>
                                C = 55-59 (2.00) | D = 45-54 (1.00)<br>
                                E = 0-44 (0.00)
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="row mt-4">
                <div class="col-md-12 text-end">
                    <p class="text-muted">
                        Dicetak pada: <?= date('d F Y H:i:s') ?><br>
                        <small>Dokumen ini dicetak dari Sistem Informasi Akademik POLTEKSI</small>
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