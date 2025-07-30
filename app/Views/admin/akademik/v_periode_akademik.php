<!-- Dashboard Cards -->
<?php if ($periode_aktif): ?>
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3><?= $statistik['total_mahasiswa'] ?></h3>
                <p class="mb-0">Total Mahasiswa KRS</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3><?= $statistik['krs_disetujui'] ?></h3>
                <p class="mb-0">KRS Disetujui</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3><?= $statistik['krs_pending'] ?></h3>
                <p class="mb-0">KRS Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3><?= $statistik['total_kelas'] ?></h3>
                <p class="mb-0">Total Kelas</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Periode Aktif: <?= $periode_aktif['semester'] . ' ' . $periode_aktif['tahun_akademik'] ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($jadwal_penting as $jadwal): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card border-left-<?= $jadwal['status'] == 'active' ? 'success' : ($jadwal['status'] == 'upcoming' ? 'warning' : 'secondary') ?>">
                            <div class="card-body">
                                <h6><?= $jadwal['nama'] ?></h6>
                                <p class="text-muted mb-0"><?= date('d M Y', strtotime(explode(' - ', $jadwal['tanggal'])[0])) ?> - <?= date('d M Y', strtotime(explode(' - ', $jadwal['tanggal'])[1] ?? explode(' - ', $jadwal['tanggal'])[0])) ?></p>
                                <span class="badge bg-<?= $jadwal['status'] == 'active' ? 'success' : ($jadwal['status'] == 'upcoming' ? 'warning' : 'secondary') ?>">
                                    <?= $jadwal['status'] == 'active' ? 'Berlangsung' : ($jadwal['status'] == 'upcoming' ? 'Akan Datang' : 'Selesai') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                        <i class="fas fa-plus"></i> Tambah Periode
                    </button>
                    <button class="btn btn-success" onclick="exportKalender()">
                        <i class="fas fa-calendar-alt"></i> Export Kalender
                    </button>
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-kalender">
                        <i class="fas fa-eye"></i> Lihat Kalender
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Semua Periode Akademik</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Periode
                </button>
            </div>
        </div>
        <div class="card-body">
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

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Semester</th>
                            <th>Tahun Akademik</th>
                            <th>Periode KRS</th>
                            <th>Max SKS</th>
                            <th>Status</th>
                            <th>Aktif</th>
                            <th width="250px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($periode as $data) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['semester'] ?></td>
                            <td><?= $data['tahun_akademik'] ?></td>
                            <td><?= date('d M', strtotime($data['tgl_mulai_krs'])) ?> - <?= date('d M Y', strtotime($data['tgl_selesai_krs'])) ?></td>
                            <td>
                                <span class="badge bg-info"><?= $data['max_sks_normal'] ?? 24 ?> SKS</span>
                                <small class="text-muted d-block">Remedial: <?= $data['max_sks_remedial'] ?? 12 ?> SKS</small>
                            </td>
                            <td>
                                <?php if ($data['status_krs'] == 'Buka'): ?>
                                    <span class="badge bg-success">KRS Buka</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">KRS Tutup</span>
                                <?php endif; ?>
                                <br>
                                <?php if ($data['status_khs'] == 'Final'): ?>
                                    <span class="badge bg-primary">KHS Final</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">KHS Draft</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($data['is_active']): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <a href="<?= base_url('PeriodeAkademik/SetAktif/' . $data['id_periode']) ?>" class="btn btn-sm btn-outline-success">Aktifkan</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('PeriodeAkademik/Detail/' . $data['id_periode']) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <div class="btn-group">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= base_url('PeriodeAkademik/UpdateStatus/' . $data['id_periode'] . '/status_krs/' . ($data['status_krs'] == 'Buka' ? 'Tutup' : 'Buka')) ?>">
                                            <?= $data['status_krs'] == 'Buka' ? 'Tutup KRS' : 'Buka KRS' ?>
                                        </a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('PeriodeAkademik/UpdateStatus/' . $data['id_periode'] . '/status_khs/' . ($data['status_khs'] == 'Final' ? 'Draft' : 'Final')) ?>">
                                            <?= $data['status_khs'] == 'Final' ? 'Draft KHS' : 'Finalisasi KHS' ?>
                                        </a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $data['id_periode'] ?>" data-name="<?= $data['semester'] . ' ' . $data['tahun_akademik'] ?>" data-type="periode">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Tambah Periode Akademik</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('PeriodeAkademik/InsertData') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-control" required>
                        <option value="">Pilih Semester</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tahun Akademik</label>
                    <input type="text" name="tahun_akademik" class="form-control" required placeholder="Contoh: 2024/2025">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Mulai KRS</label>
                    <input type="date" name="tgl_mulai_krs" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Selesai KRS</label>
                    <input type="date" name="tgl_selesai_krs" class="form-control" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai Kuliah</label>
                            <input type="date" name="tgl_mulai_kuliah" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai Kuliah</label>
                            <input type="date" name="tgl_selesai_kuliah" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">UTS Mulai</label>
                            <input type="date" name="tgl_uts_mulai" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">UTS Selesai</label>
                            <input type="date" name="tgl_uts_selesai" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">UAS Mulai</label>
                            <input type="date" name="tgl_uas_mulai" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">UAS Selesai</label>
                            <input type="date" name="tgl_uas_selesai" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Max SKS Normal</label>
                            <input type="number" name="max_sks_normal" class="form-control" value="24" min="1" max="30">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Max SKS Remedial</label>
                            <input type="number" name="max_sks_remedial" class="form-control" value="12" min="1" max="20">
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan untuk periode ini"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>