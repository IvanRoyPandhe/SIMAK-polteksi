<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Data Mata Kuliah</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Mata Kuliah
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
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Prodi</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($matkul as $data) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="badge bg-primary"><?= $data['kode_matkul'] ?></span></td>
                            <td><?= $data['nama_matkul'] ?></td>
                            <td><span class="badge bg-info"><?= $data['nama_prodi'] ?? 'Belum Set' ?></span></td>
                            <td><?= $data['sks'] ?> SKS</td>
                            <td>Semester <?= $data['semester'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit<?= $data['id_matkul'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $data['id_matkul'] ?>" data-name="<?= $data['nama_matkul'] ?>" data-type="matkul">
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
                <h4 class="modal-title">Tambah Mata Kuliah</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('MataKuliah/InsertData') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kode Mata Kuliah</label>
                    <input type="text" name="kode_matkul" class="form-control" required placeholder="Contoh: TI101">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Mata Kuliah</label>
                    <input type="text" name="nama_matkul" class="form-control" required placeholder="Contoh: Pemrograman Dasar">
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
                    <label class="form-label">Kurikulum</label>
                    <select name="kurikulum_id" class="form-control" required>
                        <option value="">Pilih Kurikulum</option>
                        <option value="1">Kurikulum 2022 - Teknologi Mesin</option>
                        <option value="2">Kurikulum 2022 - Teknologi Informasi</option>
                        <option value="3">Kurikulum 2022 - Akuntansi</option>
                        <option value="4">Kurikulum 2022 - Administrasi Perkantoran</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Mata Kuliah</label>
                    <select name="jenis" class="form-control" required>
                        <option value="">Pilih Jenis</option>
                        <option value="Wajib">Wajib</option>
                        <option value="Pilihan">Pilihan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">SKS</label>
                    <input type="number" name="sks" class="form-control" required min="1" max="6" placeholder="Contoh: 3">
                </div>
                <div class="mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-control" required>
                        <option value="">Pilih Semester</option>
                        <?php for($i = 1; $i <= 8; $i++): ?>
                            <option value="<?= $i ?>">Semester <?= $i ?></option>
                        <?php endfor; ?>
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

<!-- Modal Edit -->
<?php foreach ($matkul as $data) : ?>
<div class="modal fade" id="modal-edit<?= $data['id_matkul'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h4 class="modal-title">Edit Mata Kuliah</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('MataKuliah/UpdateData/' . $data['id_matkul']) ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kode Mata Kuliah</label>
                    <input type="text" name="kode_matkul" class="form-control" value="<?= $data['kode_matkul'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Mata Kuliah</label>
                    <input type="text" name="nama_matkul" class="form-control" value="<?= $data['nama_matkul'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">SKS</label>
                    <input type="number" name="sks" class="form-control" value="<?= $data['sks'] ?>" required min="1" max="6">
                </div>
                <div class="mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-control" required>
                        <?php for($i = 1; $i <= 8; $i++): ?>
                            <option value="<?= $i ?>" <?= $data['semester'] == $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?php endforeach; ?>