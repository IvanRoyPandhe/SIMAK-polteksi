<div class="col-md-12">
    <!-- Dashboard Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h4><?= count($krs) ?></h4>
                    <small>Total KRS</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4><?= count(array_filter($krs, fn($k) => $k['status'] == 'Disetujui')) ?></h4>
                    <small>KRS Disetujui</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h4><?= count(array_filter($krs, fn($k) => $k['status'] == 'Pending')) ?></h4>
                    <small>Menunggu Approval</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-<?= ($periode_aktif['status_krs'] ?? 'Tutup') == 'Aktif' ? 'success' : 'danger' ?> text-white">
                <div class="card-body text-center">
                    <h4><?= $periode_aktif['status_krs'] ?? 'Tutup' ?></h4>
                    <small>Status Periode KRS</small>
                    <?php if (isset($periode_aktif['tgl_selesai_krs'])): ?>
                        <br><small class="opacity-75">s/d <?= date('d/m/Y', strtotime($periode_aktif['tgl_selesai_krs'])) ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manajemen KRS</h4>
                <div>
                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modal-periode">
                        <i class="fas fa-calendar"></i> Kelola Periode
                    </button>
                    <button type="button" class="btn btn-info me-2" onclick="window.open('<?= base_url('KRS/Laporan') ?>', '_blank')">
                        <i class="fas fa-file-alt"></i> Laporan
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                        <i class="fas fa-plus"></i> Override KRS
                    </button>
                </div>
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

            <?php if (session()->getFlashdata('errors')): ?>
                <script>
                    let errors = `<?php foreach (session()->getFlashdata('errors') as $error): ?><?= $error; ?> <br> <?php endforeach; ?>`;
                    Swal.fire({
                        title: 'Kesalahan',
                        html: errors,
                        icon: 'error',
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
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Tahun Akademik</th>
                            <th>Status</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($krs as $data) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nim'] ?></td>
                            <td><?= $data['nama_mahasiswa'] ?></td>
                            <td><?= $data['kode_matkul'] ?> - <?= $data['nama_matkul'] ?></td>
                            <td><?= $data['sks'] ?> SKS</td>
                            <td><?= $data['semester_aktif'] ?></td>
                            <td><?= $data['tahun_akademik'] ?></td>
                            <td>
                                <?php if ($data['status'] == 'Pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif ($data['status'] == 'Disetujui'): ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($data['status'] == 'Pending' || $data['status'] == 'Menunggu Persetujuan'): ?>
                                    <a href="<?= base_url('KRS/Approve/' . $data['id_krs']) ?>" class="btn btn-success btn-sm" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="<?= base_url('KRS/Reject/' . $data['id_krs']) ?>" class="btn btn-danger btn-sm" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $data['id_krs'] ?>" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-secondary btn-sm delete-btn" data-id="<?= $data['id_krs'] ?>" data-name="<?= $data['nama_matkul'] ?>" data-type="krs" title="Hapus">
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Tambah KRS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('KRS/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mahasiswa</label>
                            <select name="mahasiswa_id" class="form-control" required>
                                <option value="">Pilih Mahasiswa</option>
                                <?php foreach ($mahasiswa as $mhs) : ?>
                                    <option value="<?= $mhs['id_mahasiswa'] ?>"><?= $mhs['nim'] ?> - <?= $mhs['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <select name="matkul_id" class="form-control" required>
                                <option value="">Pilih Mata Kuliah</option>
                                <?php foreach ($matkul as $mk) : ?>
                                    <option value="<?= $mk['id_matkul'] ?>"><?= $mk['kode_matkul'] ?> - <?= $mk['nama_matkul'] ?> (<?= $mk['sks'] ?> SKS)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Semester Aktif</label>
                            <select name="semester_aktif" class="form-control" required>
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" class="form-control" required placeholder="Contoh: 2024/2025">
                        </div>
                    </div>
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

<!-- Modal Kelola Periode -->
<div class="modal fade" id="modal-periode" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h4 class="modal-title">Kelola Periode KRS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('KRS/UpdatePeriode') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Periode Akademik</label>
                    <select name="periode_id" class="form-control" required>
                        <?php foreach ($periode_list as $periode): ?>
                            <option value="<?= $periode['id_periode'] ?>" <?= $periode['is_active'] ? 'selected' : '' ?>>
                                <?= $periode['semester'] ?> <?= $periode['tahun_akademik'] ?>
                                <?= $periode['is_active'] ? '(Aktif)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Status Periode KRS</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_krs" id="krs_aktif" value="Aktif" <?= ($periode_aktif['status_krs'] ?? 'Tutup') == 'Aktif' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="krs_aktif">
                            <span class="badge bg-success">Aktif</span> - Mahasiswa dapat mengisi KRS
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_krs" id="krs_tutup" value="Tutup" <?= ($periode_aktif['status_krs'] ?? 'Tutup') == 'Tutup' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="krs_tutup">
                            <span class="badge bg-danger">Tutup</span> - Periode KRS ditutup
                        </label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai KRS</label>
                            <input type="date" name="tgl_mulai_krs" class="form-control" value="<?= $periode_aktif['tgl_mulai_krs'] ?? date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai KRS</label>
                            <input type="date" name="tgl_selesai_krs" class="form-control" value="<?= $periode_aktif['tgl_selesai_krs'] ?? date('Y-m-d', strtotime('+14 days')) ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Batas Maksimal SKS</label>
                    <input type="number" name="max_sks" class="form-control" value="<?= $periode_aktif['max_sks'] ?? 24 ?>" min="12" max="30" required>
                    <small class="text-muted">SKS maksimal yang dapat diambil mahasiswa (akan disesuaikan dengan IPK)</small>
                </div>
                
                <div class="alert alert-info">
                    <h6>Aturan SKS berdasarkan IPK:</h6>
                    <ul class="mb-0">
                        <li>IPK < 2.0: Maksimal 18 SKS</li>
                        <li>IPK 2.0 - 2.49: Maksimal 20 SKS</li>
                        <li>IPK 2.5 - 3.49: Maksimal 22 SKS</li>
                        <li>IPK ≥ 3.5: Maksimal 24 SKS</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Simpan Pengaturan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>