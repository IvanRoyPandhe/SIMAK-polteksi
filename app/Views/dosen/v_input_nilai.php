<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="card-title mb-0">Input & Pengelolaan Nilai</h4>
        </div>
        <div class="card-body">
            <!-- Filter Kelas -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Pilih Kelas</label>
                    <select class="form-select" id="kelasSelect" onchange="loadMahasiswa(this.value)">
                        <option value="">Pilih Kelas</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['id_kelas'] ?>"><?= $k['kode_matkul'] ?> - <?= $k['nama_matkul'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Komponen Nilai</label>
                    <select class="form-select" id="komponenSelect">
                        <option value="tugas">Tugas</option>
                        <option value="uts">UTS</option>
                        <option value="uas">UAS</option>
                        <option value="final">Nilai Akhir</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button class="btn btn-primary" onclick="tampilkanNilai()">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabel Input Nilai -->
            <div id="tabelNilai" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Input Nilai - <span id="infoKelas"></span></h5>
                    <div>
                        <button class="btn btn-success" onclick="simpanNilai()">
                            <i class="fas fa-save"></i> Simpan Nilai
                        </button>
                        <button class="btn btn-warning" onclick="finalisasiNilai()">
                            <i class="fas fa-check"></i> Finalisasi
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-success">
                            <tr>
                                <th width="50px">No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th width="100px">Tugas (30%)</th>
                                <th width="100px">UTS (30%)</th>
                                <th width="100px">UAS (40%)</th>
                                <th width="100px">Nilai Akhir</th>
                                <th width="80px">Huruf</th>
                                <th width="100px">Status</th>
                            </tr>
                        </thead>
                        <tbody id="daftarMahasiswa">
                            <!-- Data akan dimuat via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Distribusi Nilai -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Distribusi Nilai</h6>
                                <div class="row text-center">
                                    <div class="col">
                                        <h4 class="text-success">5</h4>
                                        <small>A</small>
                                    </div>
                                    <div class="col">
                                        <h4 class="text-primary">8</h4>
                                        <small>B</small>
                                    </div>
                                    <div class="col">
                                        <h4 class="text-warning">10</h4>
                                        <small>C</small>
                                    </div>
                                    <div class="col">
                                        <h4 class="text-danger">2</h4>
                                        <small>D</small>
                                    </div>
                                    <div class="col">
                                        <h4 class="text-dark">0</h4>
                                        <small>E</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-title">Statistik Kelas</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Rata-rata: <strong>78.5</strong></small><br>
                                        <small>Tertinggi: <strong>95</strong></small><br>
                                        <small>Terendah: <strong>45</strong></small>
                                    </div>
                                    <div class="col-6">
                                        <small>Lulus: <strong>23 (92%)</strong></small><br>
                                        <small>Tidak Lulus: <strong>2 (8%)</strong></small><br>
                                        <small>Total: <strong>25</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Nilai -->
<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Import Nilai dari Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Upload File Excel</label>
                    <input type="file" class="form-control" accept=".xlsx,.xls">
                    <small class="text-muted">Format: NIM, Nama, Tugas, UTS, UAS</small>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Download template Excel <a href="#" class="alert-link">di sini</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</div>

<script>
function tampilkanNilai() {
    const kelas = document.getElementById('kelasSelect').value;
    
    if (!kelas) {
        alert('Pilih kelas terlebih dahulu');
        return;
    }
    
    document.getElementById('tabelNilai').style.display = 'block';
    document.getElementById('infoKelas').textContent = document.getElementById('kelasSelect').selectedOptions[0].text;
    
    // Load mahasiswa data via AJAX
    fetch(`<?= base_url('Dashboard/Dosen/getMahasiswaByKelas') ?>/${kelas}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            
            let html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="9" class="text-center">Tidak ada mahasiswa terdaftar di kelas ini</td></tr>';
            } else {
                data.forEach((mahasiswa, index) => {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${mahasiswa.nim}</td>
                            <td>${mahasiswa.nama}</td>
                            <td><input type="number" class="form-control form-control-sm" name="nilai[${mahasiswa.id_mahasiswa}][tugas]" min="0" max="100" value="" onchange="hitungNilaiAkhir(this)"></td>
                            <td><input type="number" class="form-control form-control-sm" name="nilai[${mahasiswa.id_mahasiswa}][uts]" min="0" max="100" value="" onchange="hitungNilaiAkhir(this)"></td>
                            <td><input type="number" class="form-control form-control-sm" name="nilai[${mahasiswa.id_mahasiswa}][uas]" min="0" max="100" value="" onchange="hitungNilaiAkhir(this)"></td>
                            <td class="text-center fw-bold nilai-akhir">-</td>
                            <td class="text-center nilai-huruf">-</td>
                            <td class="text-center"><span class="badge bg-warning">Draft</span></td>
                        </tr>
                    `;
                });
            }
            document.getElementById('daftarMahasiswa').innerHTML = html;
        })
        .catch(error => {
            console.error('Error details:', error);
            alert(`Gagal memuat data mahasiswa: ${error.message}`);
            // Show sample data as fallback
            const fallbackHtml = `
                <tr>
                    <td colspan="9" class="text-center text-muted">
                        <i class="fas fa-exclamation-triangle"></i><br>
                        Gagal memuat data dari database<br>
                        <small>Error: ${error.message}</small>
                    </td>
                </tr>
            `;
            document.getElementById('daftarMahasiswa').innerHTML = fallbackHtml;
        });
}

function hitungNilaiAkhir(input) {
    const row = input.closest('tr');
    const tugas = parseFloat(row.cells[3].querySelector('input').value) || 0;
    const uts = parseFloat(row.cells[4].querySelector('input').value) || 0;
    const uas = parseFloat(row.cells[5].querySelector('input').value) || 0;
    
    const nilaiAkhir = (tugas * 0.3) + (uts * 0.3) + (uas * 0.4);
    row.cells[6].textContent = nilaiAkhir.toFixed(1);
    
    // Update grade
    let grade = 'E';
    let badgeClass = 'bg-danger';
    
    if (nilaiAkhir >= 85) { grade = 'A'; badgeClass = 'bg-success'; }
    else if (nilaiAkhir >= 80) { grade = 'A-'; badgeClass = 'bg-success'; }
    else if (nilaiAkhir >= 75) { grade = 'B+'; badgeClass = 'bg-primary'; }
    else if (nilaiAkhir >= 70) { grade = 'B'; badgeClass = 'bg-primary'; }
    else if (nilaiAkhir >= 65) { grade = 'B-'; badgeClass = 'bg-primary'; }
    else if (nilaiAkhir >= 60) { grade = 'C+'; badgeClass = 'bg-warning'; }
    else if (nilaiAkhir >= 55) { grade = 'C'; badgeClass = 'bg-warning'; }
    else if (nilaiAkhir >= 50) { grade = 'C-'; badgeClass = 'bg-warning'; }
    else if (nilaiAkhir >= 45) { grade = 'D'; badgeClass = 'bg-danger'; }
    
    row.cells[7].innerHTML = `<span class="badge ${badgeClass}">${grade}</span>`;
}

function simpanNilai() {
    const kelas = document.getElementById('kelasSelect').value;
    if (!kelas) {
        alert('Pilih kelas terlebih dahulu');
        return;
    }
    
    Swal.fire({
        title: 'Simpan Nilai?',
        text: 'Nilai akan disimpan sebagai draft',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('kelas_id', kelas);
            
            // Collect all nilai data
            const inputs = document.querySelectorAll('#daftarMahasiswa input[type="number"]');
            inputs.forEach(input => {
                if (input.value) {
                    formData.append(input.name, input.value);
                }
            });
            
            fetch('<?= base_url("Dashboard/Dosen/SaveNilai") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Tersimpan!', data.message, 'success');
                } else {
                    Swal.fire('Error!', 'Gagal menyimpan nilai', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan', 'error');
            });
        }
    });
}

function loadMahasiswa(kelasId) {
    // Function for future implementation
    console.log('Loading mahasiswa for kelas:', kelasId);
}

function finalisasiNilai() {
    Swal.fire({
        title: 'Finalisasi Nilai?',
        text: 'Setelah difinalisasi, nilai tidak dapat diubah lagi',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Finalisasi',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Berhasil!', 'Nilai berhasil difinalisasi', 'success');
        }
    });
}
</script>