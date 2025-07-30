<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Kartu Rencana Studi (KRS)</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle"></i> Informasi KRS</h5>
                <p class="mb-1"><strong>Semester:</strong> Ganjil 2024/2025</p>
                <p class="mb-1"><strong>Status Periode KRS:</strong> <span class="badge bg-success">Buka</span></p>
                <p class="mb-0"><strong>Batas Pengisian:</strong> 31 Desember 2024</p>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6>Total SKS Diambil</h6>
                            <h3 class="text-primary">18 SKS</h3>
                            <small class="text-muted">Maksimal: 24 SKS</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6>Status KRS</h6>
                            <h3 class="text-warning">Draft</h3>
                            <small class="text-muted">Belum diajukan</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Kelas</th>
                            <th>Dosen</th>
                            <th>Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>TI301</td>
                            <td>Pemrograman Web</td>
                            <td>3</td>
                            <td>A</td>
                            <td>Dr. Ahmad Fauzi</td>
                            <td>Senin, 08:00-10:30</td>
                            <td>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>TI302</td>
                            <td>Basis Data</td>
                            <td>3</td>
                            <td>B</td>
                            <td>Dr. Siti Nurhaliza</td>
                            <td>Selasa, 10:30-13:00</td>
                            <td>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-matkul">
                    <i class="fas fa-plus"></i> Tambah Mata Kuliah
                </button>
                <div>
                    <button class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Ajukan KRS
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-print"></i> Cetak KRS
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Mata Kuliah -->
<div class="modal fade" id="modal-tambah-matkul" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Tambah Mata Kuliah</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Kelas</th>
                                <th>Dosen</th>
                                <th>Jadwal</th>
                                <th>Kapasitas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>TI303</td>
                                <td>Jaringan Komputer</td>
                                <td>3</td>
                                <td>A</td>
                                <td>Dr. Budi Santoso</td>
                                <td>Rabu, 08:00-10:30</td>
                                <td>25/30</td>
                                <td>
                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Ambil
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>TI304</td>
                                <td>Sistem Operasi</td>
                                <td>3</td>
                                <td>B</td>
                                <td>Dr. Rina Sari</td>
                                <td>Kamis, 13:00-15:30</td>
                                <td>30/30</td>
                                <td>
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-times"></i> Penuh
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>