<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Kelola Tugas & Quiz</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTugasModal">
                            <i class="fas fa-plus me-2"></i>Buat Tugas Baru
                        </button>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createQuizModal">
                            <i class="fas fa-question-circle me-2"></i>Buat Quiz
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Mata Kuliah</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tugas)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Belum ada tugas yang dibuat
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($tugas as $t): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $t['judul'] ?? 'Sample Tugas' ?></td>
                                    <td><?= $t['nama_matkul'] ?? 'Mata Kuliah' ?></td>
                                    <td><?= date('d/m/Y', strtotime($t['deadline'] ?? date('Y-m-d'))) ?></td>
                                    <td>
                                        <span class="badge bg-success">Aktif</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">0 Mahasiswa</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Tugas Modal -->
<div class="modal fade" id="createTugasModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Buat Tugas Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control" placeholder="Masukkan judul tugas">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <select class="form-select">
                                <option>Pilih Mata Kuliah</option>
                                <option>Algoritma Pemrograman</option>
                                <option>Basis Data</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Deadline</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bobot Nilai (%)</label>
                            <input type="number" class="form-control" placeholder="10" min="1" max="100">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control" rows="4" placeholder="Masukkan deskripsi tugas..."></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">File Lampiran (Opsional)</label>
                            <input type="file" class="form-control" multiple>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success">Simpan Tugas</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Quiz Modal -->
<div class="modal fade" id="createQuizModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fas fa-question-circle me-2"></i>Buat Quiz Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Judul Quiz</label>
                            <input type="text" class="form-control" placeholder="Masukkan judul quiz">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <select class="form-select">
                                <option>Pilih Mata Kuliah</option>
                                <option>Algoritma Pemrograman</option>
                                <option>Basis Data</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Durasi (Menit)</label>
                            <input type="number" class="form-control" placeholder="60" min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bobot Nilai (%)</label>
                            <input type="number" class="form-control" placeholder="20" min="1" max="100">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Deskripsi Quiz</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan deskripsi quiz..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning">Simpan Quiz</button>
            </div>
        </div>
    </div>
</div>