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
                        <h6 class="text-white-50 mb-1">Mahasiswa Bimbingan</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['mahasiswa_bimbingan'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-user-tie me-1"></i>PA</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-user-friends fa-2x"></i>
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
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('DashboardDosen/JadwalMengajar') ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column justify-content-center">
                            <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                            <span>Jadwal Mengajar</span>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('DashboardDosen/InputNilai') ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column justify-content-center">
                            <i class="fas fa-star fa-2x mb-2"></i>
                            <span>Input Nilai</span>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('DashboardDosen/BimbinganAkademik') ?>" class="btn btn-outline-info w-100 h-100 d-flex flex-column justify-content-center">
                            <i class="fas fa-user-graduate fa-2x mb-2"></i>
                            <span>Bimbingan Akademik</span>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-outline-warning w-100 h-100 d-flex flex-column justify-content-center">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <span>Laporan</span>
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
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary">
                            <i class="fas fa-book text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">08:00 - 10:00</h6>
                            <p class="mb-1">Algoritma Pemrograman - Kelas A</p>
                            <small class="text-muted">Ruang Lab Komputer 1</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success">
                            <i class="fas fa-laptop text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">10:30 - 12:30</h6>
                            <p class="mb-1">Basis Data - Kelas B</p>
                            <small class="text-muted">Ruang Lab Komputer 2</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">14:00 - 16:00</h6>
                            <p class="mb-1">Bimbingan Akademik</p>
                            <small class="text-muted">Ruang Dosen</small>
                        </div>
                    </div>
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
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Deadline Input Nilai UTS</strong><br>
                    <small>3 hari lagi - 15 Desember 2024</small>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Rapat Dosen</strong><br>
                    <small>Besok, 13 Desember 2024 - 09:00</small>
                </div>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>KRS Mahasiswa Bimbingan</strong><br>
                    <small>5 mahasiswa menunggu approval</small>
                </div>
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
</script>