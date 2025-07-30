<!-- Dashboard Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Pemasukan Bulan Ini</h6>
                        <h3>Rp <?= number_format($stats['pemasukan_bulan_ini'], 0, ',', '.') ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-arrow-up fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Pengeluaran Bulan Ini</h6>
                        <h3>Rp <?= number_format($stats['pengeluaran_bulan_ini'], 0, ',', '.') ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-arrow-down fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-<?= $stats['saldo_bersih'] >= 0 ? 'primary' : 'warning' ?> text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Saldo Bersih</h6>
                        <h3>Rp <?= number_format($stats['saldo_bersih'], 0, ',', '.') ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-balance-scale fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Saldo Bank</h6>
                        <h3>Rp <?= number_format($stats['total_saldo_bank'], 0, ',', '.') ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-university fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Cash Flow Chart -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Tren Cash Flow (6 Bulan Terakhir)</h5>
            </div>
            <div class="card-body">
                <canvas id="cashFlowChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Kategori & Quick Actions -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Top Kategori Pengeluaran</h5>
            </div>
            <div class="card-body">
                <?php foreach ($top_kategori as $kategori): ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong><?= $kategori['nama_kategori'] ?></strong>
                    </div>
                    <div>
                        <span class="badge bg-danger">Rp <?= number_format($kategori['total'], 0, ',', '.') ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('KasInternal/DanaMasuk') ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Pemasukan
                    </a>
                    <a href="<?= base_url('KasInternal/DanaKeluar') ?>" class="btn btn-danger">
                        <i class="fas fa-minus"></i> Tambah Pengeluaran
                    </a>
                    <a href="<?= base_url('KasInternal/Anggaran') ?>" class="btn btn-primary">
                        <i class="fas fa-calculator"></i> Kelola Anggaran
                    </a>
                    <a href="<?= base_url('KasInternal/Laporan') ?>" class="btn btn-info">
                        <i class="fas fa-file-invoice"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Transaksi Terbaru</h5>
                    <?php if ($stats['pending_approval'] > 0): ?>
                        <span class="badge bg-warning"><?= $stats['pending_approval'] ?> Menunggu Approval</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Pemasukan</th>
                                <th>Pengeluaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($recent_transactions, 0, 10) as $transaksi): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($transaksi['tgl'])) ?></td>
                                <td>
                                    <span class="badge bg-secondary"><?= $transaksi['nama_kategori'] ?? $transaksi['kategori'] ?></span>
                                </td>
                                <td><?= $transaksi['keterangan'] ?></td>
                                <td class="text-success">
                                    <?= $transaksi['dana_masuk'] > 0 ? 'Rp ' . number_format($transaksi['dana_masuk'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-danger">
                                    <?= $transaksi['dana_keluar'] > 0 ? 'Rp ' . number_format($transaksi['dana_keluar'], 0, ',', '.') : '-' ?>
                                </td>
                                <td>
                                    <span class="badge bg-success">Approved</span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Cash Flow Chart
const ctx = document.getElementById('cashFlowChart').getContext('2d');
const cashFlowChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php foreach($cashflow_trend as $trend): ?>'<?= $trend['bulan'] ?>',<?php endforeach; ?>],
        datasets: [{
            label: 'Pemasukan',
            data: [<?php foreach($cashflow_trend as $trend): ?><?= $trend['pemasukan'] ?>,<?php endforeach; ?>],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }, {
            label: 'Pengeluaran',
            data: [<?php foreach($cashflow_trend as $trend): ?><?= $trend['pengeluaran'] ?>,<?php endforeach; ?>],
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.1
        }, {
            label: 'Saldo',
            data: [<?php foreach($cashflow_trend as $trend): ?><?= $trend['saldo'] ?>,<?php endforeach; ?>],
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Tren Keuangan 6 Bulan Terakhir'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value, index, values) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>