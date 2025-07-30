<!-- Welcome Section -->
<div class="welcome-section text-white mb-4" style="background: linear-gradient(135deg, #dc2626, #ef4444); padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="mb-2">Selamat Datang, <?= $user['nama'] ?? 'Admin' ?>!</h2>
            <p class="mb-0 opacity-90">Dashboard Admin SIMAK - Sistem Informasi Manajemen Kampus POLTEKSI</p>
            <small class="opacity-75">Periode Aktif: <?= $stats['periode_aktif']['semester'] ?? 'Ganjil' ?> <?= $stats['periode_aktif']['tahun_akademik'] ?? '2024/2025' ?></small>
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
                        <h6 class="text-white-50 mb-1">Total Mahasiswa</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['total_mahasiswa'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-user-check me-1"></i>Aktif</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-white" style="width: 85%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-gradient-success text-white h-100 shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Dosen</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['total_dosen'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-chalkboard-teacher me-1"></i>Pengajar</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-white" style="width: 92%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-gradient-warning text-white h-100 shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">KRS Pending</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['krs_pending'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-hourglass-half me-1"></i>Menunggu</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-white" style="width: <?= $stats['krs_pending'] > 0 ? '60' : '100' ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-gradient-info text-white h-100 shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Kelas</h6>
                        <h2 class="mb-0 counter" data-target="<?= $stats['total_kelas'] ?>">0</h2>
                        <small class="text-white-75"><i class="fas fa-calendar-check me-1"></i>Periode Aktif</small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-door-open fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-white" style="width: 78%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Statistics Grid -->
<div class="row mb-4">
    <!-- Academic Stats -->
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary mb-2">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h4 class="mb-1 counter" data-target="<?= $stats['total_prodi'] ?>">0</h4>
                <small class="text-muted">Program Studi</small>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success mb-2">
                    <i class="fas fa-book"></i>
                </div>
                <h4 class="mb-1 counter" data-target="<?= $stats['total_matkul'] ?>">0</h4>
                <small class="text-muted">Mata Kuliah</small>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning mb-2">
                    <i class="fas fa-award"></i>
                </div>
                <h4 class="mb-1 counter" data-target="<?= $stats['total_beasiswa'] ?>">0</h4>
                <small class="text-muted">Beasiswa</small>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info mb-2">
                    <i class="fas fa-box"></i>
                </div>
                <h4 class="mb-1 counter" data-target="<?= $stats['total_inventaris'] ?>">0</h4>
                <small class="text-muted">Inventaris</small>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger mb-2">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h4 class="mb-1 counter" data-target="<?= $stats['total_pengaduan'] ?>">0</h4>
                <small class="text-muted">Pengaduan</small>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="stat-icon bg-secondary bg-opacity-10 text-secondary mb-2">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h4 class="mb-1 counter" data-target="<?= $stats['total_artikel'] ?>">0</h4>
                <small class="text-muted">Artikel</small>
            </div>
        </div>
    </div>
</div>

<!-- KRS Status Cards -->
<div class="row mb-4">
    <div class="col-lg-4 mb-3">
        <div class="card bg-success bg-opacity-10 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-check-circle text-success fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-success counter" data-target="<?= $stats['krs_disetujui'] ?>">0</h4>
                        <small class="text-muted">KRS Disetujui</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="card bg-warning bg-opacity-10 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-hourglass-half text-warning fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-warning counter" data-target="<?= $stats['krs_pending'] ?>">0</h4>
                        <small class="text-muted">KRS Pending</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="card bg-danger bg-opacity-10 border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-times-circle text-danger fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-danger counter" data-target="<?= $stats['krs_ditolak'] ?>">0</h4>
                        <small class="text-muted">KRS Ditolak</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Financial Activity -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Pemasukan Hari Ini</h6>
                        <h3 class="mb-0">Rp <?= number_format($stats['pemasukan_hari_ini'], 0, ',', '.') ?></h3>
                        <small class="text-white-75"><i class="fas fa-arrow-up me-1"></i><?= date('d M Y') ?></small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="card bg-gradient-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Pengeluaran Hari Ini</h6>
                        <h3 class="mb-0">Rp <?= number_format($stats['pengeluaran_hari_ini'], 0, ',', '.') ?></h3>
                        <small class="text-white-75"><i class="fas fa-arrow-down me-1"></i><?= date('d M Y') ?></small>
                    </div>
                    <div class="align-self-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-credit-card fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Financial Summary -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Ringkasan Keuangan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Pemasukan Bulan Ini</span>
                        <span class="text-success fw-bold">Rp <?= number_format($financial_summary['pemasukan_bulan_ini'], 0, ',', '.') ?></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Pengeluaran Bulan Ini</span>
                        <span class="text-danger fw-bold">Rp <?= number_format($financial_summary['pengeluaran_bulan_ini'], 0, ',', '.') ?></span>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Saldo Bersih</span>
                    <span class="fw-bold <?= $financial_summary['saldo_bersih'] >= 0 ? 'text-success' : 'text-danger' ?>">
                        Rp <?= number_format($financial_summary['saldo_bersih'], 0, ',', '.') ?>
                    </span>
                </div>
                <div class="mt-3">
                    <a href="<?= base_url('KasInternal') ?>" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-eye me-1"></i>Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Overview -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-gradient-success text-white">
                <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Overview Akademik</h5>
            </div>
            <div class="card-body">
                <h6 class="text-muted mb-3">Mahasiswa per Prodi</h6>
                <?php foreach ($academic_overview['mahasiswa_per_prodi'] as $prodi): ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small"><?= $prodi['nama_prodi'] ?></span>
                    <span class="badge bg-primary"><?= $prodi['jumlah'] ?></span>
                </div>
                <?php endforeach; ?>
                
                <hr>
                
                <h6 class="text-muted mb-3">Status KRS</h6>
                <?php foreach ($academic_overview['krs_stats'] as $krs): ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small"><?= $krs['status'] ?></span>
                    <span class="badge bg-<?= $krs['status'] == 'Disetujui' ? 'success' : 'warning' ?>"><?= $krs['jumlah'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- System Health & Recent Activities -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-gradient-dark text-white">
                <h5 class="mb-0"><i class="fas fa-server me-2"></i>System Health</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Database Size</span>
                        <span class="badge bg-info"><?= $system_health['db_size'] ?> MB</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Total Users</span>
                        <span class="badge bg-success"><?= $system_health['total_users'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Database Tables</span>
                        <span class="badge bg-primary"><?= $system_health['total_tables'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Total Records</span>
                        <span class="badge bg-warning"><?= number_format($system_health['total_records']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small">System Status</span>
                        <span class="badge bg-<?= $system_health['system_status'] == 'Optimal' ? 'success' : ($system_health['system_status'] == 'Warning' ? 'warning' : 'danger') ?>"><?= $system_health['system_status'] ?></span>
                    </div>
                </div>
                
                <hr>
                
                <h6 class="text-muted mb-3">Recent Activities</h6>
                <div class="timeline-compact">
                    <?php foreach (array_slice($recent_activities, 0, 5) as $activity): ?>
                    <div class="timeline-item-compact mb-2">
                        <div class="d-flex align-items-center">
                            <div class="timeline-dot bg-<?= $activity['color'] ?> me-2"></div>
                            <div class="flex-grow-1">
                                <p class="mb-0 small"><?= $activity['message'] ?></p>
                                <small class="text-muted"><?= date('H:i', strtotime($activity['time'])) ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Tren Keuangan Bulanan</h5>
            </div>
            <div class="card-body">
                <canvas id="keuanganChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Distribusi Mahasiswa</h5>
            </div>
            <div class="card-body">
                <canvas id="mahasiswaChart" height="200"></canvas>
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
.border-left-primary {
    border-left: 4px solid #007bff;
}
.border-left-success {
    border-left: 4px solid #28a745;
}
.border-left-warning {
    border-left: 4px solid #ffc107;
}
.border-left-info {
    border-left: 4px solid #17a2b8;
}
.timeline-marker {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Keuangan Chart
const keuanganCtx = document.getElementById('keuanganChart').getContext('2d');
new Chart(keuanganCtx, {
    type: 'line',
    data: {
        labels: <?= $bulan ?>,
        datasets: [{
            label: 'Pemasukan',
            data: <?= $danaMasuk ?>,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }, {
            label: 'Pengeluaran',
            data: <?= $danaKeluar ?>,
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

// Mahasiswa Chart
const mahasiswaCtx = document.getElementById('mahasiswaChart').getContext('2d');
new Chart(mahasiswaCtx, {
    type: 'doughnut',
    data: {
        labels: [<?php foreach($academic_overview['mahasiswa_per_prodi'] as $prodi): ?>'<?= $prodi['nama_prodi'] ?>',<?php endforeach; ?>],
        datasets: [{
            data: [<?php foreach($academic_overview['mahasiswa_per_prodi'] as $prodi): ?><?= $prodi['jumlah'] ?>,<?php endforeach; ?>],
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

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

// Initialize animations when page loads
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(animateCounters, 500);
    
    // Add pulse animation to important cards
    const importantCards = document.querySelectorAll('.bg-gradient-warning');
    importantCards.forEach(card => {
        if (card.querySelector('.counter') && card.querySelector('.counter').getAttribute('data-target') > 0) {
            card.style.animation = 'pulse 2s infinite';
        }
    });
});
</script>

<style>
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
}
.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.stat-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 1.5rem;
}
.timeline-compact .timeline-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.counter {
    font-weight: 700;
}
.card {
    transition: transform 0.2s ease;
}
.card:hover {
    transform: translateY(-2px);
}
</style>