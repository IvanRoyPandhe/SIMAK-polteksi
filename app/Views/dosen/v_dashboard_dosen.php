<!-- Welcome Section -->
<div class="welcome-section text-white mb-4" style="background: linear-gradient(135deg, #28a745, #20c997); padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="mb-2">Selamat Datang, <?= $user['nama'] ?? 'Dosen' ?>!</h2>
            <p class="mb-0 opacity-90">Dashboard Dosen - Sistem Informasi Akademik POLTEKSI</p>
            <small class="opacity-75">Kelola perkuliahan dan bimbingan akademik dengan mudah</small>
        </div>
        <div class="col-md-4 text-end">
            <div class="d-flex flex-column">
                <span class="h5 mb-1"><?= date('d F Y') ?></span>
                <span class="opacity-75"><?= date('H:i') ?> WIB</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-gradient-primary text-white h-100 shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Kelas</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['total_kelas'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-chalkboard me-1"></i>Mengajar</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-gradient-success text-white h-100 shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Mahasiswa</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['total_mahasiswa'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-users me-1"></i>Di Kelas</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-gradient-info text-white h-100 shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Mata Kuliah</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['total_kelas'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-book me-1"></i>Diampu</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-gradient-warning text-white h-100 shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Nilai Pending</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['nilai_pending'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-clock me-1"></i>Belum Final</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-star fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                <small class="opacity-75">Akses cepat ke fitur utama</small>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <!-- Row 1 -->
                    <div class="col-lg-3 col-md-6">
                        <a href="<?= base_url('Dashboard/Dosen/JadwalMengajar') ?>" class="quick-action-btn btn btn-outline-primary w-100 p-3 text-decoration-none" data-bs-toggle="tooltip" title="Lihat jadwal mengajar hari ini dan minggu ini">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-calendar-alt fa-2x mb-2 text-primary"></i>
                                <span class="fw-semibold">Jadwal Mengajar</span>
                                <small class="text-muted mt-1">Lihat jadwal</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="<?= base_url('Dashboard/Dosen/InputNilai') ?>" class="quick-action-btn btn btn-outline-success w-100 p-3 text-decoration-none" data-bs-toggle="tooltip" title="Input dan kelola nilai mahasiswa">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-star fa-2x mb-2 text-success"></i>
                                <span class="fw-semibold">Input Nilai</span>
                                <small class="text-muted mt-1">Kelola nilai</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="<?= base_url('Dashboard/Dosen/MateriKuliah') ?>" class="quick-action-btn btn btn-outline-info w-100 p-3 text-decoration-none" data-bs-toggle="tooltip" title="Kelola materi kuliah">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-book-open fa-2x mb-2 text-info"></i>
                                <span class="fw-semibold">Materi Kuliah</span>
                                <small class="text-muted mt-1">Upload materi</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="<?= base_url('Dashboard/Dosen/Laporan') ?>" class="quick-action-btn btn btn-outline-purple w-100 p-3 text-decoration-none" data-bs-toggle="tooltip" title="Lihat laporan dan statistik">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-chart-bar fa-2x mb-2 text-purple"></i>
                                <span class="fw-semibold">Laporan</span>
                                <small class="text-muted mt-1">Statistik</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Schedule -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Jadwal Hari Ini</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php if (!empty($jadwal_hari_ini)): ?>
                        <?php 
                        $colors = ['primary', 'success', 'info', 'warning', 'danger'];
                        $icons = ['fas fa-book', 'fas fa-laptop', 'fas fa-users', 'fas fa-chalkboard', 'fas fa-graduation-cap'];
                        $i = 0;
                        ?>
                        <?php foreach ($jadwal_hari_ini as $jadwal): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-<?= $colors[$i % count($colors)] ?>">
                                <i class="<?= $icons[$i % count($icons)] ?> text-white"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1"><?= date('H:i', strtotime($jadwal['jam_mulai'])) ?> - <?= date('H:i', strtotime($jadwal['jam_selesai'])) ?></h6>
                                <p class="mb-1"><?= $jadwal['nama_matkul'] ?> - Kelas <?= $jadwal['nama_kelas'] ?? 'A' ?></p>
                                <small class="text-muted"><?= $jadwal['nama_ruangan'] ?? 'Ruang Kuliah' ?></small>
                            </div>
                        </div>
                        <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada jadwal mengajar hari ini</p>
                            <small class="text-muted">Selamat beristirahat!</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Reminder</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($reminders)): ?>
                    <?php foreach ($reminders as $reminder): ?>
                    <div class="alert alert-<?= $reminder['type'] ?>">
                        <i class="<?= $reminder['icon'] ?> me-2"></i>
                        <strong><?= $reminder['title'] ?></strong><br>
                        <small><?= $reminder['message'] ?></small>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="text-muted">Semua tugas sudah selesai!</p>
                        <small class="text-muted">Tidak ada reminder untuk saat ini</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #d39e00);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #117a8b);
}
.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline-item {
    position: relative;
    margin-bottom: 20px;
}
.timeline-marker {
    position: absolute;
    left: -45px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.timeline::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
.counter {
    font-weight: 700;
}

/* Enhanced Quick Actions Styles */
.quick-action-btn {
    border-radius: 12px;
    transition: all 0.3s ease;
    border-width: 2px;
    min-height: 120px;
    position: relative;
    overflow: hidden;
}

.quick-action-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.quick-action-btn:hover i {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

.btn-outline-purple {
    color: #6f42c1;
    border-color: #6f42c1;
}

.btn-outline-purple:hover {
    color: #fff;
    background-color: #6f42c1;
    border-color: #6f42c1;
}

.text-purple {
    color: #6f42c1 !important;
}

/* Quick Action Animation */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.quick-action-btn.active {
    animation: pulse 0.6s ease-in-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .quick-action-btn {
        min-height: 100px;
        font-size: 0.9rem;
    }
    
    .quick-action-btn i {
        font-size: 1.5rem !important;
    }
}
</style>

<script>
// Counter Animation
function animateCounters() {
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                setTimeout(updateCounter, 20);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(animateCounters, 500);
});

const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

</script>

<!-- Quick Action Modals -->
<div class="modal fade" id="absensiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="fas fa-user-check me-2"></i>Kelola Absensi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('Dashboard/Dosen/Absensi') ?>" class="btn btn-primary w-100 p-3">
                            <i class="fas fa-list me-2"></i>Lihat Absensi Kelas
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button class="btn btn-success w-100 p-3" onclick="startAbsensi()">
                            <i class="fas fa-play me-2"></i>Mulai Absensi Baru
                        </button>
                    </div>
                </div>
                <hr>
                <h6>Absensi Hari Ini:</h6>
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Algoritma Pemrograman - Kelas A</strong><br>
                            <small class="text-muted">08:00 - 10:00</small>
                        </div>
                        <span class="badge bg-success">Selesai</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Basis Data - Kelas B</strong><br>
                            <small class="text-muted">10:30 - 12:30</small>
                        </div>
                        <span class="badge bg-warning">Berlangsung</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tugasModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-tasks me-2"></i>Kelola Tugas & Quiz</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="<?= base_url('Dashboard/Dosen/Tugas') ?>" class="btn btn-primary w-100 p-3">
                            <i class="fas fa-list me-2"></i>Lihat Semua Tugas
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-success w-100 p-3" onclick="createTugas()">
                            <i class="fas fa-plus me-2"></i>Buat Tugas Baru
                        </button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-warning w-100 p-3" onclick="createQuiz()">
                            <i class="fas fa-question-circle me-2"></i>Buat Quiz
                        </button>
                    </div>
                </div>
                <hr>
                <h6>Tugas Aktif:</h6>
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Tugas Algoritma Sorting</strong><br>
                            <small class="text-muted">Deadline: 20 Desember 2024</small>
                        </div>
                        <span class="badge bg-info">15 Submitted</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Quiz Database Normalization</strong><br>
                            <small class="text-muted">Deadline: 18 Desember 2024</small>
                        </div>
                        <span class="badge bg-warning">8 Submitted</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Quick Action Functions
function showAbsensiModal() {
    const modal = new bootstrap.Modal(document.getElementById('absensiModal'));
    modal.show();
}

function showTugasModal() {
    const modal = new bootstrap.Modal(document.getElementById('tugasModal'));
    modal.show();
}

function startAbsensi() {
    Swal.fire({
        title: 'Mulai Absensi',
        text: 'Pilih kelas untuk memulai absensi',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url("Dashboard/Dosen/Absensi") ?>';
        }
    });
}

function createTugas() {
    Swal.fire({
        title: 'Buat Tugas Baru',
        text: 'Fitur ini akan mengarahkan ke halaman pembuatan tugas',
        icon: 'info',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = '<?= base_url("Dashboard/Dosen/Tugas") ?>';
    });
}

function createQuiz() {
    Swal.fire({
        title: 'Buat Quiz Baru',
        text: 'Fitur ini akan mengarahkan ke halaman pembuatan quiz',
        icon: 'info',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = '<?= base_url("Dashboard/Dosen/Tugas") ?>';
    });
}

// Enhanced initialization
document.addEventListener('DOMContentLoaded', function() {
    // Add click animation to quick action buttons
    document.querySelectorAll('.quick-action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.add('active');
            setTimeout(() => {
                this.classList.remove('active');
            }, 600);
        });
    });
});
</script>