<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Jadwal Mengajar</h4>
                <button class="btn btn-light btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Jadwal
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Kelas</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Ruang</th>
                            <th>Jumlah Mahasiswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($jadwal as $j): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="badge bg-primary"><?= $j['kode_matkul'] ?></span></td>
                            <td><?= $j['nama_matkul'] ?></td>
                            <td class="text-center"><?= $j['sks'] ?></td>
                            <td><?= $j['nama_kelas'] ?? 'Kelas A' ?></td>
                            <td><?= $j['hari'] ?? 'Senin' ?></td>
                            <td><?= $j['jam_mulai'] ?? '08:00' ?> - <?= $j['jam_selesai'] ?? '10:00' ?></td>
                            <td><?= $j['ruang'] ?? 'Lab Komputer 1' ?></td>
                            <td class="text-center">
                                <span class="badge bg-info"><?= rand(20, 35) ?></span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-success" title="Presensi">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info" title="Daftar Mahasiswa">
                                        <i class="fas fa-users"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="Input Nilai">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Schedule View -->
<div class="col-md-12 mt-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Jadwal Mingguan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th width="100px">Jam</th>
                            <th>Senin</th>
                            <th>Selasa</th>
                            <th>Rabu</th>
                            <th>Kamis</th>
                            <th>Jumat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">08:00-10:00</td>
                            <td class="bg-light">
                                <div class="schedule-item">
                                    <strong>Algoritma Pemrograman</strong><br>
                                    <small>Kelas A - Lab Komputer 1</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-light">
                                <div class="schedule-item">
                                    <strong>Struktur Data</strong><br>
                                    <small>Kelas B - Lab Komputer 2</small>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">10:30-12:30</td>
                            <td></td>
                            <td class="bg-light">
                                <div class="schedule-item">
                                    <strong>Basis Data</strong><br>
                                    <small>Kelas A - Lab Komputer 1</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-light">
                                <div class="schedule-item">
                                    <strong>Pemrograman Web</strong><br>
                                    <small>Kelas C - Lab Komputer 3</small>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">14:00-16:00</td>
                            <td class="bg-warning bg-opacity-25">
                                <div class="schedule-item">
                                    <strong>Bimbingan Akademik</strong><br>
                                    <small>Ruang Dosen</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-warning bg-opacity-25">
                                <div class="schedule-item">
                                    <strong>Bimbingan Akademik</strong><br>
                                    <small>Ruang Dosen</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-warning bg-opacity-25">
                                <div class="schedule-item">
                                    <strong>Konsultasi</strong><br>
                                    <small>Ruang Dosen</small>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.schedule-item {
    padding: 5px;
    border-radius: 4px;
}
.table td {
    vertical-align: middle;
    height: 80px;
}
@media print {
    .btn {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>