<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Transkrip Nilai Mahasiswa</h4>
                <button class="btn btn-light btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Header Transkrip -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h5 class="text-primary">TRANSKRIP NILAI AKADEMIK</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="150px">NIM</td>
                            <td>: <?= $mahasiswa['nim'] ?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>: <?= $mahasiswa['nama'] ?></td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td>: <?= $mahasiswa['nama_prodi'] ?></td>
                        </tr>
                        <tr>
                            <td>Tahun Angkatan</td>
                            <td>: <?= $mahasiswa['tahun_angkatan'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-end">
                    <img src="<?= base_url('uploaded/mahasiswa/' . ($mahasiswa['foto'] ?? 'default.jpg')) ?>" 
                         class="img-fluid rounded" style="width: 120px; height: 150px; object-fit: cover;">
                </div>
            </div>

            <!-- Tabel Nilai -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th width="50px">No</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th width="60px">SKS</th>
                            <th width="80px">Nilai</th>
                            <th width="80px">Huruf</th>
                            <th width="80px">Bobot</th>
                            <th width="100px">Periode</th>
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
                            <td><?= $no++ ?></td>
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
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Ringkasan Akademik</h6>
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
                                    <td>Status Akademik</td>
                                    <td>: <span class="badge bg-<?= $mahasiswa['status_akademik'] == 'Aktif' ? 'success' : 'warning' ?>"><?= $mahasiswa['status_akademik'] ?></span></td>
                                </tr>
                                <tr>
                                    <td>Semester Aktif</td>
                                    <td>: <strong><?= $mahasiswa['semester_aktif'] ?></strong></td>
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
}
</style>