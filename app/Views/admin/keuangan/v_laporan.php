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
                    <select class="form-control" onchange="window.location.href='<?= base_url('KasInternal/Laporan') ?>?periode='+this.value">
                        <?php foreach ($periode_options as $option): ?>
                            <option value="<?= $option['periode'] ?>" <?= $periode == $option['periode'] ? 'selected' : '' ?>>
                                <?= $option['periode_name'] ?>
                            </option>
                        <?php endforeach; ?>
                        <?php if (empty($periode_options)): ?>
                            <option value="">Tidak ada data transaksi</option>
                        <?php endif; ?>
                    </select>
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
                            <h4>Rp <?= number_format($summary['total_masuk'], 0, ',', '.') ?></h4>
                            <p class="mb-0">Total Pemasukan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h4>Rp <?= number_format($summary['total_keluar'], 0, ',', '.') ?></h4>
                            <p class="mb-0">Total Pengeluaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4>Rp <?= number_format($summary['saldo_bersih'], 0, ',', '.') ?></h4>
                            <p class="mb-0">Saldo Bersih</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h4>Rp <?= number_format($saldo_bank, 0, ',', '.') ?></h4>
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
                                    <?php foreach ($pemasukan as $item): ?>
                                    <tr>
                                        <td><?= $item['kategori'] ?? 'Tidak ada kategori' ?></td>
                                        <td class="text-end">Rp <?= number_format($item['total'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($pemasukan)): ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Tidak ada data pemasukan</td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr class="table-success">
                                        <th>Total Pemasukan</th>
                                        <th class="text-end">Rp <?= number_format($summary['total_masuk'], 0, ',', '.') ?></th>
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
                                    <?php foreach ($pengeluaran as $item): ?>
                                    <tr>
                                        <td><?= $item['kategori'] ?? 'Tidak ada kategori' ?></td>
                                        <td class="text-end">Rp <?= number_format($item['total'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($pengeluaran)): ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Tidak ada data pengeluaran</td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr class="table-danger">
                                        <th>Total Pengeluaran</th>
                                        <th class="text-end">Rp <?= number_format($summary['total_keluar'], 0, ',', '.') ?></th>
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
                                <?php 
                                $running_balance = 0;
                                foreach ($transaksi as $item): 
                                    $running_balance += ($item['dana_masuk'] - $item['dana_keluar']);
                                ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($item['tgl'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $item['dana_masuk'] > 0 ? 'success' : 'danger' ?>">
                                            <?= $item['kategori'] ?? 'Tidak ada kategori' ?>
                                        </span>
                                    </td>
                                    <td><?= $item['keterangan'] ?></td>
                                    <td class="text-success">
                                        <?= $item['dana_masuk'] > 0 ? 'Rp ' . number_format($item['dana_masuk'], 0, ',', '.') : '-' ?>
                                    </td>
                                    <td class="text-danger">
                                        <?= $item['dana_keluar'] > 0 ? 'Rp ' . number_format($item['dana_keluar'], 0, ',', '.') : '-' ?>
                                    </td>
                                    <td>Rp <?= number_format($running_balance, 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($transaksi)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada transaksi pada periode ini</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>