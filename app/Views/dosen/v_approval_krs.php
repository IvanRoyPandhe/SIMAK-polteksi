<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Approval KRS Mahasiswa Bimbingan</h4>
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
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Semester</th>
                            <th>Total SKS</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th width="200px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($krs_list)): ?>
                            <?php $no = 1; foreach ($krs_list as $krs): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $krs['nim'] ?></td>
                                <td><?= $krs['nama_mahasiswa'] ?></td>
                                <td><?= $krs['semester'] ?? 'Ganjil' ?> <?= $krs['tahun_akademik'] ?? date('Y') ?></td>
                                <td><?= $krs['sks'] ?> SKS</td>
                                <td><span class="badge bg-warning">Menunggu Persetujuan</span></td>
                                <td><?= date('d M Y', strtotime($krs['tgl_pengajuan'])) ?></td>
                                <td>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-approve<?= $krs['id_krs'] ?>">
                                        <i class="fas fa-check"></i> Setuju
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-reject<?= $krs['id_krs'] ?>">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada KRS yang menunggu persetujuan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($krs_list)): ?>
    <?php foreach ($krs_list as $krs): ?>
    <!-- Modal Approve -->
    <div class="modal fade" id="modal-approve<?= $krs['id_krs'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title">Setujui KRS</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <?= form_open('Dashboard/Dosen/ApproveKRS/' . $krs['id_krs']) ?>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui KRS mahasiswa <strong><?= $krs['nama_mahasiswa'] ?> (<?= $krs['nim'] ?>)</strong>?</p>
                    <p><strong>Mata Kuliah:</strong> <?= $krs['nama_matkul'] ?> (<?= $krs['sks'] ?> SKS)</p>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Berikan catatan jika diperlukan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui KRS</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div class="modal fade" id="modal-reject<?= $krs['id_krs'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title">Tolak KRS</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <?= form_open('Dashboard/Dosen/RejectKRS/' . $krs['id_krs']) ?>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak KRS mahasiswa <strong><?= $krs['nama_mahasiswa'] ?> (<?= $krs['nim'] ?>)</strong>?</p>
                    <p><strong>Mata Kuliah:</strong> <?= $krs['nama_matkul'] ?> (<?= $krs['sks'] ?> SKS)</p>
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Berikan alasan penolakan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak KRS</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>