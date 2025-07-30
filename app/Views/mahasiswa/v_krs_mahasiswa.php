<div class="col-md-12">
    <!-- Header Info -->
    <div class="card mb-3">
        <div class="card-body bg-gradient-primary text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">Kartu Rencana Studi (KRS)</h4>
                    <p class="mb-0 opacity-75">Semester <?= $mahasiswa['semester_aktif'] ?> - <?= $mahasiswa['nama_prodi'] ?></p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="me-3">
                            <small class="opacity-75">Status KRS</small><br>
                            <?php if ($status_krs == 'Draft'): ?>
                                <span class="badge bg-warning">Draft</span>
                            <?php elseif ($status_krs == 'Menunggu Persetujuan'): ?>
                                <span class="badge bg-info">Menunggu Persetujuan</span>
                            <?php elseif ($status_krs == 'Disetujui'): ?>
                                <span class="badge bg-success">Disetujui</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Quick Info -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-light border-0">
                        <div class="card-body text-center py-3">
                            <h5 class="mb-1"><?= $mahasiswa['nim'] ?></h5>
                            <small class="text-muted">NIM</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light border-0">
                        <div class="card-body text-center py-3">
                            <h5 class="mb-1 text-<?= $mahasiswa['ipk'] >= 3.5 ? 'success' : ($mahasiswa['ipk'] >= 3.0 ? 'warning' : 'danger') ?>"><?= number_format($mahasiswa['ipk'], 2) ?></h5>
                            <small class="text-muted">IPK</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light border-0">
                        <div class="card-body text-center py-3">
                            <h5 class="mb-1 text-primary"><?= $max_sks ?></h5>
                            <small class="text-muted">Max SKS</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light border-0">
                        <div class="card-body text-center py-3">
                            <h5 class="mb-1 text-info" id="display-total-sks"><?= array_sum(array_column($krs_existing, 'sks')) ?></h5>
                            <small class="text-muted">SKS Dipilih</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form KRS -->
            <?= form_open('Dashboard/SubmitKRS') ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-primary mb-0">Pilih Mata Kuliah</h6>
                        <span class="badge bg-info">Semester <?= $mahasiswa['semester_aktif'] ?></span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th width="60px" class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label" for="selectAll">
                                                <small>Pilih</small>
                                            </label>
                                        </div>
                                    </th>
                                    <th width="100px">Kode MK</th>
                                    <th>Mata Kuliah</th>
                                    <th width="80px" class="text-center">SKS</th>
                                    <th width="100px" class="text-center">Semester</th>
                                    <th width="100px" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($matkul_tersedia as $mk): 
                                    $isSelected = in_array($mk['id_matkul'], array_column($krs_existing, 'mata_kuliah_id'));
                                ?>
                                <tr class="matkul-row <?= $isSelected ? 'table-success' : '' ?>" data-matkul-id="<?= $mk['id_matkul'] ?>">
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <input type="checkbox" name="matkul[]" value="<?= $mk['id_matkul'] ?>" 
                                                   data-sks="<?= $mk['sks'] ?>" class="form-check-input matkul-checkbox"
                                                   id="matkul_<?= $mk['id_matkul'] ?>"
                                                   <?= $isSelected ? 'checked disabled' : '' ?>>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6"><?= $mk['kode_matkul'] ?></span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0"><?= $mk['nama_matkul'] ?></h6>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info"><?= $mk['sks'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= $mk['semester'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($isSelected): ?>
                                            <span class="badge bg-success"><i class="fas fa-check"></i> Dipilih</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">Tersedia</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Progress SKS -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Progress SKS</h6>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-primary" id="progress-sks" style="width: <?= ($max_sks > 0) ? (array_sum(array_column($krs_existing, 'sks')) / $max_sks) * 100 : 0 ?>%">
                                    <span id="progress-text"><?= array_sum(array_column($krs_existing, 'sks')) ?>/<?= $max_sks ?> SKS</span>
                                </div>
                            </div>
                            <small class="text-muted">Sisa: <span id="sisa-sks"><?= $max_sks - array_sum(array_column($krs_existing, 'sks')) ?></span> SKS</small>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <?php if ($status_krs != 'Disetujui'): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" id="submit-krs">
                                    <i class="fas fa-paper-plane"></i> Submit KRS
                                </button>
                            </div>
                            <small class="text-muted mt-2 d-block text-center">Pastikan pilihan mata kuliah sudah benar</small>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- KRS yang sudah dipilih -->
                    <?php if (!empty($krs_existing)): ?>
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-check-circle me-2"></i>Mata Kuliah Terpilih</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($krs_existing as $krs): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?= $krs['kode_matkul'] ?></h6>
                                        <small class="text-muted"><?= $krs['nama_matkul'] ?></small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?= $krs['sks'] ?> SKS</span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.matkul-checkbox');
    const submitBtn = document.getElementById('submit-krs');
    const maxSks = <?= $max_sks ?>;
    const existingSks = <?= array_sum(array_column($krs_existing, 'sks')) ?>;
    const matkulCards = document.querySelectorAll('.matkul-card');

    function updateSKS() {
        let totalSks = existingSks;
        
        checkboxes.forEach(checkbox => {
            if (checkbox.checked && !checkbox.disabled) {
                totalSks += parseInt(checkbox.dataset.sks);
            }
        });

        // Update displays
        document.getElementById('display-total-sks').textContent = totalSks;
        document.getElementById('sisa-sks').textContent = maxSks - totalSks;
        document.getElementById('progress-text').textContent = totalSks + '/' + maxSks + ' SKS';
        
        // Update progress bar
        const progressBar = document.getElementById('progress-sks');
        const percentage = (totalSks / maxSks) * 100;
        progressBar.style.width = percentage + '%';
        
        if (percentage > 100) {
            progressBar.classList.remove('bg-primary');
            progressBar.classList.add('bg-danger');
        } else {
            progressBar.classList.remove('bg-danger');
            progressBar.classList.add('bg-primary');
        }

        // Update row appearance and disable if needed
        const matkulRows = document.querySelectorAll('.matkul-row');
        matkulRows.forEach(row => {
            const checkbox = row.querySelector('.matkul-checkbox');
            if (!checkbox.checked && !checkbox.disabled) {
                const wouldExceed = totalSks + parseInt(checkbox.dataset.sks) > maxSks;
                checkbox.disabled = wouldExceed;
                
                if (wouldExceed) {
                    row.classList.add('table-warning', 'opacity-50');
                    row.style.pointerEvents = 'none';
                } else {
                    row.classList.remove('table-warning', 'opacity-50');
                    row.style.pointerEvents = 'auto';
                }
            }
            
            // Update row class based on selection
            if (checkbox.checked) {
                row.classList.add('table-success');
            } else {
                row.classList.remove('table-success');
            }
        });

        // Update submit button
        submitBtn.disabled = totalSks > maxSks || totalSks === 0;
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSKS);
    });
    
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    selectAllCheckbox.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = selectAllCheckbox.checked;
            }
        });
        updateSKS();
    });

    updateSKS();
});

// Add CSS for better table styling
const style = document.createElement('style');
style.textContent = `
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.1);
    }
    .matkul-row {
        transition: all 0.2s ease;
    }
    .opacity-50 {
        opacity: 0.5;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.9rem;
    }
`;
document.head.appendChild(style);
</script>