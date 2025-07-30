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
                        <tr>
                            <td>1</td>
                            <td>2021001</td>
                            <td>Budi Santoso</td>
                            <td>Ganjil 2024/2025</td>
                            <td>18 SKS</td>
                            <td><span class="badge bg-warning">Menunggu Persetujuan</span></td>
                            <td>15 Des 2024</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail1">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-approve1">
                                    <i class="fas fa-check"></i> Setuju
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-reject1">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2021002</td>
                            <td>Sari Dewi</td>
                            <td>Ganjil 2024/2025</td>
                            <td>21 SKS</td>
                            <td><span class="badge bg-success">Disetujui</span></td>
                            <td>14 Des 2024</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail2">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                                <span class="text-muted">Sudah disetujui</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail KRS -->
<div class="modal fade" id="modal-detail1" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title">Detail KRS - Budi Santoso (2021001)</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Kelas</th>
                                <th>Dosen</th>
                                <th>Jadwal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>TI301</td>
                                <td>Pemrograman Web</td>
                                <td>3</td>
                                <td>A</td>
                                <td>Dr. Ahmad Fauzi</td>
                                <td>Senin, 08:00-10:30</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>TI302</td>
                                <td>Basis Data</td>
                                <td>3</td>
                                <td>B</td>
                                <td>Dr. Siti Nurhaliza</td>
                                <td>Selasa, 10:30-13:00</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>TI303</td>
                                <td>Jaringan Komputer</td>
                                <td>3</td>
                                <td>A</td>
                                <td>Dr. Budi Santoso</td>
                                <td>Rabu, 08:00-10:30</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total SKS</th>
                                <th>18</th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="modal-approve1" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h4 class="modal-title">Setujui KRS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Dashboard/Dosen/ApproveKRS/1') ?>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menyetujui KRS mahasiswa <strong>Budi Santoso (2021001)</strong>?</p>
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
<div class="modal fade" id="modal-reject1" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h4 class="modal-title">Tolak KRS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('Dashboard/Dosen/RejectKRS/1') ?>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menolak KRS mahasiswa <strong>Budi Santoso (2021001)</strong>?</p>
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