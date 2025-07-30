<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manajemen Nilai Mahasiswa</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Nilai
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Mata Kuliah</th>
                            <th>Periode</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Akhir</th>
                            <th>Huruf</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($nilai as $data): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nim'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td>
                                <strong><?= $data['kode_matkul'] ?></strong><br>
                                <small><?= $data['nama_matkul'] ?> (<?= $data['sks'] ?> SKS)</small>
                            </td>
                            <td><?= $data['semester'] ?> <?= $data['tahun_akademik'] ?></td>
                            <td><?= number_format($data['nilai_tugas'], 1) ?></td>
                            <td><?= number_format($data['nilai_uts'], 1) ?></td>
                            <td><?= number_format($data['nilai_uas'], 1) ?></td>
                            <td><?= number_format($data['nilai_akhir'], 1) ?></td>
                            <td>
                                <span class="badge bg-<?= $data['nilai_huruf'] == 'A' ? 'success' : ($data['nilai_huruf'] == 'B' || $data['nilai_huruf'] == 'B+' || $data['nilai_huruf'] == 'A-' ? 'primary' : ($data['nilai_huruf'] == 'C' || $data['nilai_huruf'] == 'C+' || $data['nilai_huruf'] == 'B-' ? 'warning' : 'danger')) ?>">
                                    <?= $data['nilai_huruf'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($data['status'] == 'Final'): ?>
                                    <span class="badge bg-success">Final</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if ($data['status'] == 'Draft'): ?>
                                    <a href="<?= base_url('Nilai/Finalisasi/' . $data['id_nilai']) ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('Nilai/Transkrip/' . $data['mahasiswa_id']) ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                                <button class="btn btn-sm btn-danger">
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
                <h4 class="modal-title">Tambah Nilai</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Nilai/Insert') ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-control" required>
                        <option value="">Pilih Mahasiswa</option>
                        <?php foreach ($mahasiswa as $mhs): ?>
                            <option value="<?= $mhs['id_mahasiswa'] ?>"><?= $mhs['nim'] ?> - <?= $mhs['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mata Kuliah</label>
                    <select name="matkul_id" class="form-control" required>
                        <option value="">Pilih Mata Kuliah</option>
                        <?php foreach ($matkul as $mk): ?>
                            <option value="<?= $mk['id_matkul'] ?>"><?= $mk['kode_matkul'] ?> - <?= $mk['nama_matkul'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Periode</label>
                    <select name="periode_id" class="form-control" required>
                        <option value="">Pilih Periode</option>
                        <?php foreach ($periode as $p): ?>
                            <option value="<?= $p['id_periode'] ?>"><?= $p['semester'] ?> <?= $p['tahun_akademik'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nilai Tugas (30%)</label>
                            <input type="number" name="nilai_tugas" class="form-control" min="0" max="100" step="0.1" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nilai UTS (30%)</label>
                            <input type="number" name="nilai_uts" class="form-control" min="0" max="100" step="0.1" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nilai UAS (40%)</label>
                            <input type="number" name="nilai_uas" class="form-control" min="0" max="100" step="0.1" required>
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