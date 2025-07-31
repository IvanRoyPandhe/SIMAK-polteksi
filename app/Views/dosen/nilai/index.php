<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="card-title mb-0">Input Nilai - <?= $mata_kuliah['nama_matkul'] ?></h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Kode:</strong> <?= $mata_kuliah['kode_matkul'] ?></p>
                    <p><strong>SKS:</strong> <?= $mata_kuliah['sks'] ?></p>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-warning" onclick="finalisasiNilai(<?= $mata_kuliah['id_matkul'] ?>)">
                        <i class="fas fa-check"></i> Finalisasi Nilai
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($mahasiswa)): ?>
                            <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                                <tr id="row-<?= $mhs['id_mahasiswa'] ?>">
                                    <td><?= $no++ ?></td>
                                    <td><?= $mhs['nim'] ?></td>
                                    <td><?= $mhs['nama'] ?></td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" 
                                               min="0" max="100" 
                                               value="<?= $mhs['nilai_tugas'] ?? '' ?>"
                                               onchange="updateNilai(<?= $mhs['id_mahasiswa'] ?>, 'tugas', this.value)">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" 
                                               min="0" max="100" 
                                               value="<?= $mhs['nilai_uts'] ?? '' ?>"
                                               onchange="updateNilai(<?= $mhs['id_mahasiswa'] ?>, 'uts', this.value)">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" 
                                               min="0" max="100" 
                                               value="<?= $mhs['nilai_uas'] ?? '' ?>"
                                               onchange="updateNilai(<?= $mhs['id_mahasiswa'] ?>, 'uas', this.value)">
                                    </td>
                                    <td class="text-center fw-bold" id="nilai-akhir-<?= $mhs['id_mahasiswa'] ?>">
                                        <?= $mhs['nilai_akhir'] ?? '-' ?>
                                    </td>
                                    <td class="text-center" id="nilai-huruf-<?= $mhs['id_mahasiswa'] ?>">
                                        <?php if ($mhs['nilai_huruf']): ?>
                                            <span class="badge bg-primary"><?= $mhs['nilai_huruf'] ?></span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada mahasiswa terdaftar</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
let nilaiData = {};

function updateNilai(mahasiswaId, jenis, nilai) {
    if (!nilaiData[mahasiswaId]) {
        nilaiData[mahasiswaId] = {};
    }
    nilaiData[mahasiswaId][jenis] = parseFloat(nilai) || 0;
    
    // Auto save after 1 second delay
    clearTimeout(nilaiData[mahasiswaId].timeout);
    nilaiData[mahasiswaId].timeout = setTimeout(() => {
        saveNilai(mahasiswaId);
    }, 1000);
}

function saveNilai(mahasiswaId) {
    const data = nilaiData[mahasiswaId];
    if (!data) return;
    
    $.ajax({
        url: '<?= base_url('dosen/nilai/update') ?>',
        method: 'POST',
        data: {
            matkul_id: <?= $mata_kuliah['id_matkul'] ?>,
            mahasiswa_id: mahasiswaId,
            nilai_tugas: data.tugas || 0,
            nilai_uts: data.uts || 0,
            nilai_uas: data.uas || 0
        },
        success: function(response) {
            if (response.status === 'success') {
                $('#nilai-akhir-' + mahasiswaId).text(response.nilai_akhir);
                $('#nilai-huruf-' + mahasiswaId).html('<span class="badge bg-primary">' + response.nilai_huruf + '</span>');
            }
        },
        error: function() {
            alert('Gagal menyimpan nilai');
        }
    });
}

function finalisasiNilai(matkulId) {
    Swal.fire({
        title: 'Finalisasi Nilai?',
        text: 'Setelah difinalisasi, nilai tidak dapat diubah lagi',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Finalisasi',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('dosen/nilai/finalisasi') ?>',
                method: 'POST',
                data: { matkul_id: matkulId },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Berhasil!', response.message, 'success');
                        location.reload();
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                }
            });
        }
    });
}
</script>