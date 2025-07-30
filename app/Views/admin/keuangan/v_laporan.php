<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Laporan Keuangan</h4>
        </div>
        <div class="card-body">
            <!-- Filter Periode -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Pilih Periode</label>
                    <input type="month" class="form-control" value="<?= $periode ?>" onchange="window.location.href='<?= base_url('KasInternal/Laporan') ?>?periode='+this.value">
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <button class="btn btn-success me-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn btn-danger me-2">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4>Rp 50,000,000</h4>
                            <p class="mb-0">Total Pemasukan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h4>Rp 35,000,000</h4>
                            <p class="mb-0">Total Pengeluaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4>Rp 15,000,000</h4>
                            <p class="mb-0">Saldo Bersih</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h4>Rp 90,000,000</h4>
                            <p class="mb-0">Total Saldo Bank</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan per Kategori -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5>Laporan Pemasukan per Kategori</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Uang Kuliah</td>
                                        <td class="text-end">Rp 30,000,000</td>
                                    </tr>
                                    <tr>
                                        <td>Pendaftaran Mahasiswa Baru</td>
                                        <td class="text-end">Rp 15,000,000</td>
                                    </tr>
                                    <tr>
                                        <td>Sertifikasi & Pelatihan</td>
                                        <td class="text-end">Rp 5,000,000</td>
                                    </tr>
                                    <tr class="table-success">
                                        <th>Total Pemasukan</th>
                                        <th class="text-end">Rp 50,000,000</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5>Laporan Pengeluaran per Kategori</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Gaji & Tunjangan Dosen</td>
                                        <td class="text-end">Rp 20,000,000</td>
                                    </tr>
                                    <tr>
                                        <td>Operasional Kampus</td>
                                        <td class="text-end">Rp 10,000,000</td>
                                    </tr>
                                    <tr>
                                        <td>Pemeliharaan & Perbaikan</td>
                                        <td class="text-end">Rp 5,000,000</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <th>Total Pengeluaran</th>
                                        <th class="text-end">Rp 35,000,000</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Transaksi -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Detail Transaksi Periode <?= date('F Y', strtotime($periode . '-01')) ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Keterangan</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01/12/2024</td>
                                    <td><span class="badge bg-success">Uang Kuliah</span></td>
                                    <td>Pembayaran SPP Mahasiswa</td>
                                    <td class="text-success">Rp 10,000,000</td>
                                    <td>-</td>
                                    <td>Rp 10,000,000</td>
                                </tr>
                                <tr>
                                    <td>02/12/2024</td>
                                    <td><span class="badge bg-danger">Gaji Dosen</span></td>
                                    <td>Gaji Bulan Desember</td>
                                    <td>-</td>
                                    <td class="text-danger">Rp 5,000,000</td>
                                    <td>Rp 5,000,000</td>
                                </tr>
                                <tr>
                                    <td>03/12/2024</td>
                                    <td><span class="badge bg-success">Pendaftaran</span></td>
                                    <td>Pendaftaran Mahasiswa Baru</td>
                                    <td class="text-success">Rp 3,000,000</td>
                                    <td>-</td>
                                    <td>Rp 8,000,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>