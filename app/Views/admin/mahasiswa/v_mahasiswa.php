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

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Data Mahasiswa</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Mahasiswa
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Semester</th>
                            <th>Angkatan</th>
                            <th>Status</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($mahasiswa as $mhs) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $mhs['nim'] ?></td>
                            <td><?= $mhs['nama'] ?></td>
                            <td><?= $mhs['email'] ?></td>
                            <td><?= $mhs['nama_prodi'] ?? 'Belum Set' ?></td>
                            <td><?= $mhs['semester'] ?? '-' ?></td>
                            <td><?= $mhs['tahun_angkatan'] ?? '-' ?></td>
                            <td>
                                <span class="badge bg-<?= $mhs['status'] == 'Aktif' ? 'success' : ($mhs['status'] == 'Lulus' ? 'primary' : 'warning') ?>">
                                    <?= $mhs['status'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('Mahasiswa/Biodata/' . $mhs['id_mahasiswa']) ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-user"></i>
                                </a>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $mhs['id_mahasiswa'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $mhs['id_mahasiswa'] ?>" data-name="<?= $mhs['nama'] ?>" data-type="mahasiswa">
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
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Mahasiswa/Insert') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Program Studi</label>
                    <select name="prodi_id" class="form-control" required>
                        <option value="">Pilih Program Studi</option>
                        <option value="1">D3 Teknologi Mesin</option>
                        <option value="2">D3 Teknologi Informasi</option>
                        <option value="3">D3 Akuntansi</option>
                        <option value="4">D3 Administrasi Perkantoran</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-control" required>
                                <option value="">Pilih Semester</option>
                                <?php for($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Angkatan</label>
                            <select name="tahun_angkatan" class="form-control" required>
                                <option value="">Pilih Tahun Angkatan</option>
                                <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Lulus">Lulus</option>
                        <option value="DO">Drop Out</option>
                    </select>
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

<!-- Modal Edit untuk setiap mahasiswa -->
<?php foreach ($mahasiswa as $mhs) : ?>
<div class="modal fade" id="editModal<?= $mhs['id_mahasiswa'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Mahasiswa/Update/' . $mhs['id_mahasiswa']) ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" value="<?= $mhs['nim'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $mhs['nama'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $mhs['email'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Program Studi</label>
                    <select name="prodi_id" class="form-control" required>
                        <option value="1" <?= ($mhs['prodi_id'] ?? '') == '1' ? 'selected' : '' ?>>D3 Teknologi Mesin</option>
                        <option value="2" <?= ($mhs['prodi_id'] ?? '') == '2' ? 'selected' : '' ?>>D3 Teknologi Informasi</option>
                        <option value="3" <?= ($mhs['prodi_id'] ?? '') == '3' ? 'selected' : '' ?>>D3 Akuntansi</option>
                        <option value="4" <?= ($mhs['prodi_id'] ?? '') == '4' ? 'selected' : '' ?>>D3 Administrasi Perkantoran</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-control" required>
                                <?php for($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= $i ?>" <?= $mhs['semester'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Angkatan</label>
                            <select name="tahun_angkatan" class="form-control" required>
                                <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                                    <option value="<?= $i ?>" <?= ($mhs['tahun_angkatan'] ?? '') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Aktif" <?= $mhs['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Cuti" <?= $mhs['status'] == 'Cuti' ? 'selected' : '' ?>>Cuti</option>
                        <option value="Lulus" <?= $mhs['status'] == 'Lulus' ? 'selected' : '' ?>>Lulus</option>
                        <option value="DO" <?= $mhs['status'] == 'DO' ? 'selected' : '' ?>>Drop Out</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?php endforeach; ?>