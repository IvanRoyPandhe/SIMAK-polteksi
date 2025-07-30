<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-success text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Kartu Hasil Studi (KHS)</h4>
                <button class="btn btn-light btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print KHS
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Info Mahasiswa -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150px"><strong>NIM</strong></td>
                            <td>: <?= $mahasiswa['nim'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>: <?= $mahasiswa['nama'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Program Studi</strong></td>
                            <td>: <?= $mahasiswa['nama_prodi'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Semester</strong></td>
                            <td>: <?= $mahasiswa['semester_aktif'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-end">
                    <img src="<?= base_url('uploaded/mahasiswa/' . ($mahasiswa['foto'] ?? 'default.jpg')) ?>" 
                         class="img-fluid rounded border" style="width: 100px; height: 120px; object-fit: cover;">
                </div>
            </div>

            <!-- Filter Semester -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light border-0">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-filter text-primary me-2"></i>
                                <div class="flex-grow-1">
                                    <label class="form-label mb-1 small">Filter Semester</label>
                                    <select class="form-select form-select-sm" onchange="filterBySemester(this.value)">
                                        <option value="">Semua Semester</option>
                                        <?php for($i = 1; $i <= 8; $i++): ?>
                                            <option value="<?= $i ?>">Semester <?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-primary text-white border-0">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-chart-line me-2"></i>
                                <div>
                                    <small class="opacity-75">IPK Saat Ini</small>
                                    <h5 class="mb-0"><?= number_format($mahasiswa['ipk'], 2) ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Cards -->
            <div id="nilai-container">
                <?php 
                $total_sks_semester = [];
                $total_bobot_semester = [];
                $grouped_nilai = [];
                
                foreach ($nilai as $data): 
                    if ($data['status'] == 'Final') {
                        $sem = $data['semester'];
                        if (!isset($grouped_nilai[$sem])) {
                            $grouped_nilai[$sem] = [];
                            $total_sks_semester[$sem] = 0;
                            $total_bobot_semester[$sem] = 0;
                        }
                        $grouped_nilai[$sem][] = $data;
                        $total_sks_semester[$sem] += $data['sks'];
                        $total_bobot_semester[$sem] += ($data['bobot'] * $data['sks']);
                    }
                endforeach;
                
                foreach ($grouped_nilai as $semester => $nilai_semester):
                    $ips = $total_sks_semester[$semester] > 0 ? $total_bobot_semester[$semester] / $total_sks_semester[$semester] : 0;
                ?>
                <div class="semester-group mb-4" data-semester="<?= $semester ?>">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-gradient-success text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Semester <?= $semester ?></h6>
                                <div class="text-end">
                                    <small class="opacity-75">IPS: <?= number_format($ips, 2) ?></small><br>
                                    <small class="opacity-75">SKS: <?= $total_sks_semester[$semester] ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <?php foreach ($nilai_semester as $data): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 h-100">
                                        <div class="card-body p-3 border-end">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1 text-primary"><?= $data['kode_matkul'] ?></h6>
                                                    <p class="mb-0 small text-muted"><?= $data['nama_matkul'] ?></p>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge bg-<?= $data['nilai_huruf'] == 'A' ? 'success' : ($data['nilai_huruf'] == 'B' || $data['nilai_huruf'] == 'B+' || $data['nilai_huruf'] == 'A-' ? 'primary' : ($data['nilai_huruf'] == 'C' || $data['nilai_huruf'] == 'C+' || $data['nilai_huruf'] == 'B-' ? 'warning' : 'danger')) ?>">
                                                        <?= $data['nilai_huruf'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted"><?= $data['sks'] ?> SKS</small>
                                                <small class="fw-bold"><?= number_format($data['nilai_akhir'], 1) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Summary per Semester -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Ringkasan per Semester</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Semester</th>
                                            <th>SKS</th>
                                            <th>IPS</th>
                                            <th>IPK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $total_sks_kumulatif = 0;
                                        $total_bobot_kumulatif = 0;
                                        foreach ($total_sks_semester as $sem => $sks): 
                                            $ips = $sks > 0 ? $total_bobot_semester[$sem] / $sks : 0;
                                            $total_sks_kumulatif += $sks;
                                            $total_bobot_kumulatif += $total_bobot_semester[$sem];
                                            $ipk = $total_sks_kumulatif > 0 ? $total_bobot_kumulatif / $total_sks_kumulatif : 0;
                                        ?>
                                        <tr>
                                            <td>Semester <?= $sem ?></td>
                                            <td><?= $sks ?></td>
                                            <td><?= number_format($ips, 2) ?></td>
                                            <td><?= number_format($ipk, 2) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6 class="card-title">Ringkasan Keseluruhan</h6>
                            <table class="table table-borderless text-white table-sm">
                                <tr>
                                    <td>Total SKS</td>
                                    <td>: <strong><?= $total_sks_kumulatif ?></strong></td>
                                </tr>
                                <tr>
                                    <td>IPK</td>
                                    <td>: <strong><?= number_format($mahasiswa['ipk'], 2) ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>: <strong><?= $mahasiswa['status_akademik'] ?></strong></td>
                                </tr>
                            </table>
                            
                            <div class="mt-3">
                                <h6>Progress Studi</h6>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: <?= ($total_sks_kumulatif / 144) * 100 ?>%"></div>
                                </div>
                                <small><?= number_format(($total_sks_kumulatif / 144) * 100, 1) ?>% dari 144 SKS</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterBySemester(semester) {
    const semesterGroups = document.querySelectorAll('.semester-group');
    
    semesterGroups.forEach(group => {
        if (semester === '' || group.dataset.semester === semester) {
            group.style.display = 'block';
            group.style.animation = 'fadeIn 0.3s ease';
        } else {
            group.style.display = 'none';
        }
    });
}

// Enhanced styles
const style = document.createElement('style');
style.textContent = `
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .semester-group {
        animation: fadeIn 0.5s ease;
    }
    
    @media print {
        .btn, .card-header .btn {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        body {
            font-size: 12px;
        }
        .semester-group {
            break-inside: avoid;
            margin-bottom: 20px;
        }
    }
`;
document.head.appendChild(style);
</script>