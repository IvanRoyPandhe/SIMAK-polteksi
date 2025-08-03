<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-user-check me-2"></i>Kelola Absensi Mahasiswa</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#startAbsensiModal">
                            <i class="fas fa-play me-2"></i>Mulai Absensi Baru
                        </button>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-info" onclick="exportAbsensi()">
                            <i class="fas fa-download me-2"></i>Export Data
                        </button>
                    </div>
                </div>

                <div class="row mb-4">
                    <?php if (!empty($kelas)): ?>
                        <?php foreach ($kelas as $k): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><?= $k['nama_matkul'] ?? 'Mata Kuliah' ?></h6>
                                    <small><?= $k['kode_matkul'] ?? 'KODE' ?> - Kelas <?= $k['nama_kelas'] ?? 'A' ?></small>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Hari Ini</small>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success me-2">Hadir: 25</span>
                                                <span class="badge bg-danger">Tidak: 3</span>
                                            </div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-sm btn-primary" onclick="viewAbsensi(<?= $k['id_kelas'] ?? 1 ?>)">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </button>
                                            <button class="btn btn-sm btn-success" onclick="startAbsensiKelas(<?= $k['id_kelas'] ?? 1 ?>)">
                                                <i class="fas fa-play me-1"></i>Mulai
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Belum ada kelas yang diampu
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Recent Absensi -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Absensi Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kelas</th>
                                        <th>Hadir</th>
                                        <th>Tidak Hadir</th>
                                        <th>Persentase</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= date('d/m/Y') ?></td>
                                        <td>Algoritma Pemrograman</td>
                                        <td>Kelas A</td>
                                        <td><span class="badge bg-success">25</span></td>
                                        <td><span class="badge bg-danger">3</span></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" style="width: 89%">89%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime('-1 day')) ?></td>
                                        <td>Basis Data</td>
                                        <td>Kelas B</td>
                                        <td><span class="badge bg-success">22</span></td>
                                        <td><span class="badge bg-danger">6</span></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-warning" style="width: 79%">79%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Absensi Modal -->
<div class="modal fade" id="startAbsensiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-play me-2"></i>Mulai Absensi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Mata Kuliah</label>
                            <select class="form-select" id="selectMatkul">
                                <option>Pilih Mata Kuliah</option>
                                <?php if (!empty($kelas)): ?>
                                    <?php foreach ($kelas as $k): ?>
                                    <option value="<?= $k['id_kelas'] ?? 1 ?>"><?= $k['nama_matkul'] ?? 'Mata Kuliah' ?> - Kelas <?= $k['nama_kelas'] ?? 'A' ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal & Waktu</label>
                            <input type="datetime-local" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Materi Perkuliahan</label>
                            <input type="text" class="form-control" placeholder="Masukkan materi hari ini">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Durasi Absensi (Menit)</label>
                            <select class="form-select">
                                <option value="5">5 Menit</option>
                                <option value="10" selected>10 Menit</option>
                                <option value="15">15 Menit</option>
                                <option value="30">30 Menit</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="confirmStartAbsensi()">Mulai Absensi</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewAbsensi(kelasId) {
    Swal.fire({
        title: 'Detail Absensi',
        text: 'Menampilkan detail absensi untuk kelas ini',
        icon: 'info',
        confirmButtonText: 'OK'
    });
}

function startAbsensiKelas(kelasId) {
    document.getElementById('selectMatkul').value = kelasId;
    const modal = new bootstrap.Modal(document.getElementById('startAbsensiModal'));
    modal.show();
}

function confirmStartAbsensi() {
    Swal.fire({
        title: 'Mulai Absensi?',
        text: 'Absensi akan dimulai dan mahasiswa dapat melakukan presensi',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Mulai',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('startAbsensiModal')).hide();
            
            Swal.fire({
                title: 'Absensi Dimulai!',
                text: 'Mahasiswa sekarang dapat melakukan presensi',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}

function exportAbsensi() {
    Swal.fire({
        title: 'Export Data Absensi',
        text: 'Pilih format export yang diinginkan',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Excel',
        cancelButtonText: 'PDF',
        showDenyButton: true,
        denyButtonText: 'CSV'
    }).then((result) => {
        if (result.isConfirmed) {
            // Export to Excel
            Swal.fire('Export Excel', 'Data akan diexport ke format Excel', 'success');
        } else if (result.isDenied) {
            // Export to CSV
            Swal.fire('Export CSV', 'Data akan diexport ke format CSV', 'success');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Export to PDF
            Swal.fire('Export PDF', 'Data akan diexport ke format PDF', 'success');
        }
    });
}
</script>