<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title mb-0">Bimbingan Akademik</h4>
        </div>
        <div class="card-body">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4><?= count($mahasiswa_bimbingan) ?></h4>
                            <small>Total Mahasiswa Bimbingan</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4><?= count(array_filter($mahasiswa_bimbingan, fn($m) => $m['status_akademik'] == 'Aktif')) ?></h4>
                            <small>Status Aktif</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4>5</h4>
                            <small>KRS Pending</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h4>2</h4>
                            <small>IPK < 2.0</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Mahasiswa Bimbingan -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-info">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Semester</th>
                            <th>IPK</th>
                            <th>SKS Lulus</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($mahasiswa_bimbingan as $mhs): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $mhs['nim'] ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('uploaded/mahasiswa/' . ($mhs['foto'] ?? 'default.jpg')) ?>" 
                                         class="rounded-circle me-2" width="40" height="40">
                                    <div>
                                        <strong><?= $mhs['nama'] ?></strong><br>
                                        <small class="text-muted"><?= $mhs['email'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= $mhs['nama_prodi'] ?></td>
                            <td class="text-center"><?= $mhs['semester_aktif'] ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= $mhs['ipk'] >= 3.5 ? 'success' : ($mhs['ipk'] >= 3.0 ? 'primary' : ($mhs['ipk'] >= 2.0 ? 'warning' : 'danger')) ?>">
                                    <?= number_format($mhs['ipk'], 2) ?>
                                </span>
                            </td>
                            <td class="text-center"><?= $mhs['sks_lulus'] ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= $mhs['status_akademik'] == 'Aktif' ? 'success' : 'warning' ?>">
                                    <?= $mhs['status_akademik'] ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $mhs['id_mahasiswa'] ?>" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Approve KRS">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info" title="Konsultasi">
                                        <i class="fas fa-comments"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Detail Mahasiswa -->
                        <div class="modal fade" id="modalDetail<?= $mhs['id_mahasiswa'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">Detail Mahasiswa - <?= $mhs['nama'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="<?= base_url('uploaded/mahasiswa/' . ($mhs['foto'] ?? 'default.jpg')) ?>" 
                                                     class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                                <h5><?= $mhs['nama'] ?></h5>
                                                <p class="text-muted"><?= $mhs['nim'] ?></p>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-primary">Data Akademik</h6>
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td width="150px">Program Studi</td>
                                                        <td>: <?= $mhs['nama_prodi'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Semester Aktif</td>
                                                        <td>: <?= $mhs['semester_aktif'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>IPK</td>
                                                        <td>: <?= number_format($mhs['ipk'], 2) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>SKS Lulus</td>
                                                        <td>: <?= $mhs['sks_lulus'] ?> SKS</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>: <?= $mhs['status_akademik'] ?></td>
                                                    </tr>
                                                </table>

                                                <h6 class="text-success mt-3">Data Pribadi</h6>
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td width="150px">Email</td>
                                                        <td>: <?= $mhs['email'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. HP</td>
                                                        <td>: <?= $mhs['no_hp'] ?? '-' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                        <td>: <?= $mhs['alamat'] ?? '-' ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Progress Studi -->
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <h6 class="text-warning">Progress Studi</h6>
                                                <div class="progress mb-2" style="height: 25px;">
                                                    <div class="progress-bar bg-success" style="width: <?= ($mhs['sks_lulus'] / 144) * 100 ?>%">
                                                        <?= number_format(($mhs['sks_lulus'] / 144) * 100, 1) ?>%
                                                    </div>
                                                </div>
                                                <small class="text-muted"><?= $mhs['sks_lulus'] ?> / 144 SKS</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="button" class="btn btn-success">Approve KRS</button>
                                        <button type="button" class="btn btn-primary">Kirim Pesan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- KRS Approval Section -->
<div class="col-md-12 mt-4">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>KRS Menunggu Persetujuan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead class="table-warning">
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Semester</th>
                            <th>Jumlah SKS</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2021001</td>
                            <td>Ahmad Fauzi</td>
                            <td>4</td>
                            <td>21 SKS</td>
                            <td>10 Des 2024</td>
                            <td>
                                <button class="btn btn-sm btn-success me-1">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2021005</td>
                            <td>Dewi Sartika</td>
                            <td>6</td>
                            <td>18 SKS</td>
                            <td>11 Des 2024</td>
                            <td>
                                <button class="btn btn-sm btn-success me-1">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.progress {
    border-radius: 10px;
}
.progress-bar {
    border-radius: 10px;
}
</style>