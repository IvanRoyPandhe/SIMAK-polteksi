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
                <h4 class="card-title">Data Dosen</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Dosen
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($dosen as $dsn) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $dsn['nip'] ?></td>
                            <td><?= $dsn['nama'] ?></td>
                            <td><?= $dsn['email'] ?></td>
                            <td><?= $dsn['nama_prodi'] ?? 'Belum Set' ?></td>
                            <td><?= $dsn['jabatan'] ?></td>
                            <td>
                                <span class="badge bg-<?= $dsn['status'] == 'Aktif' ? 'success' : ($dsn['status'] == 'Pensiun' ? 'secondary' : 'warning') ?>">
                                    <?= $dsn['status'] ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $dsn['id_dosen'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $dsn['id_dosen'] ?>" data-name="<?= $dsn['nama'] ?>" data-type="dosen">
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
                <h5 class="modal-title">Tambah Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Dosen/Insert') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" required>
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
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <select name="jabatan" class="form-control" required>
                        <option value="">Pilih Jabatan</option>
                        <option value="Asisten Ahli">Asisten Ahli</option>
                        <option value="Lektor">Lektor</option>
                        <option value="Lektor Kepala">Lektor Kepala</option>
                        <option value="Guru Besar">Guru Besar</option>
                        <option value="Dosen Luar Biasa">Dosen Luar Biasa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Pensiun">Pensiun</option>
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

<!-- Modal Edit untuk setiap dosen -->
<?php foreach ($dosen as $dsn) : ?>
<div class="modal fade" id="editModal<?= $dsn['id_dosen'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Dosen/Update/' . $dsn['id_dosen']) ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" value="<?= $dsn['nip'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $dsn['nama'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $dsn['email'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Program Studi</label>
                    <select name="prodi_id" class="form-control" required>
                        <option value="1" <?= ($dsn['prodi_id'] ?? '') == '1' ? 'selected' : '' ?>>D3 Teknologi Mesin</option>
                        <option value="2" <?= ($dsn['prodi_id'] ?? '') == '2' ? 'selected' : '' ?>>D3 Teknologi Informasi</option>
                        <option value="3" <?= ($dsn['prodi_id'] ?? '') == '3' ? 'selected' : '' ?>>D3 Akuntansi</option>
                        <option value="4" <?= ($dsn['prodi_id'] ?? '') == '4' ? 'selected' : '' ?>>D3 Administrasi Perkantoran</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <select name="jabatan" class="form-control" required>
                        <option value="Asisten Ahli" <?= $dsn['jabatan'] == 'Asisten Ahli' ? 'selected' : '' ?>>Asisten Ahli</option>
                        <option value="Lektor" <?= $dsn['jabatan'] == 'Lektor' ? 'selected' : '' ?>>Lektor</option>
                        <option value="Lektor Kepala" <?= $dsn['jabatan'] == 'Lektor Kepala' ? 'selected' : '' ?>>Lektor Kepala</option>
                        <option value="Guru Besar" <?= $dsn['jabatan'] == 'Guru Besar' ? 'selected' : '' ?>>Guru Besar</option>
                        <option value="Dosen Luar Biasa" <?= $dsn['jabatan'] == 'Dosen Luar Biasa' ? 'selected' : '' ?>>Dosen Luar Biasa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Aktif" <?= $dsn['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Cuti" <?= $dsn['status'] == 'Cuti' ? 'selected' : '' ?>>Cuti</option>
                        <option value="Pensiun" <?= $dsn['status'] == 'Pensiun' ? 'selected' : '' ?>>Pensiun</option>
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