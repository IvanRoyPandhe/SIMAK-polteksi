<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Mahasiswa Bimbingan Akademik</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-konsultasi">
                    <i class="fas fa-plus"></i> Buat Konsultasi
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <select class="form-select" id="filter-angkatan">
                        <option value="">Semua Angkatan</option>
                        <option value="2021">Angkatan 2021</option>
                        <option value="2022">Angkatan 2022</option>
                        <option value="2023">Angkatan 2023</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filter-prodi">
                        <option value="">Semua Prodi</option>
                        <option value="TI">Teknologi Informasi</option>
                        <option value="TM">Teknologi Mesin</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th>Angkatan</th>
                            <th>IPK</th>
                            <th>Status KRS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2021001</td>
                            <td>Budi Santoso</td>
                            <td>D3 Teknologi Informasi</td>
                            <td>2021</td>
                            <td><span class="badge bg-success">3.45</span></td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail1">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-comments"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2021002</td>
                            <td>Sari Dewi</td>
                            <td>D3 Teknologi Informasi</td>
                            <td>2021</td>
                            <td><span class="badge bg-success">3.67</span></td>
                            <td><span class="badge bg-success">Disetujui</span></td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail2">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-comments"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>2022001</td>
                            <td>Ahmad Rizki</td>
                            <td>D3 Teknologi Informasi</td>
                            <td>2022</td>
                            <td><span class="badge bg-warning">2.89</span></td>
                            <td><span class="badge bg-success">Disetujui</span></td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-comments"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h3>15</h3>
                            <p class="mb-0">Total Mahasiswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h3>12</h3>
                            <p class="mb-0">KRS Disetujui</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h3>3</h3>
                            <p class="mb-0">KRS Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Mahasiswa -->
<div class="modal fade" id="modal-detail1" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title">Detail Mahasiswa - Budi Santoso</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>NIM</strong></td>
                                <td>: 2021001</td>
                            </tr>
                            <tr>
                                <td><strong>Nama</strong></td>
                                <td>: Budi Santoso</td>
                            </tr>
                            <tr>
                                <td><strong>Program Studi</strong></td>
                                <td>: D3 Teknologi Informasi</td>
                            </tr>
                            <tr>
                                <td><strong>Angkatan</strong></td>
                                <td>: 2021</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>IPK</strong></td>
                                <td>: 3.45</td>
                            </tr>
                            <tr>
                                <td><strong>SKS Lulus</strong></td>
                                <td>: 108 SKS</td>
                            </tr>
                            <tr>
                                <td><strong>Semester</strong></td>
                                <td>: 6</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: Aktif</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6 class="mt-3">Riwayat Konsultasi</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Topik</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>15 Des 2024</td>
                                <td>Konsultasi KRS Semester 6</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                            <tr>
                                <td>10 Des 2024</td>
                                <td>Diskusi Tugas Akhir</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Buat Konsultasi</button>
            </div>
        </div>
    </div>
</div>