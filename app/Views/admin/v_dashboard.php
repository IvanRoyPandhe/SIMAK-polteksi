<?php
if ($kasinternal == null) {
    $pemasukankasinternal[] = 0;
    $pengeluarankasinternal[] = 0;
} else {
    foreach ($kasinternal as $key => $isi_kaskasinternal) {
        $pemasukankasinternal[] = $isi_kaskasinternal['dana_masuk'];
        $pengeluarankasinternal[] = $isi_kaskasinternal['dana_keluar'];
    }
}
$totalkasinternal = array_sum($pemasukankasinternal) - array_sum($pengeluarankasinternal);
$totalkasinternal = number_format($totalkasinternal);
?>

<div class="welcome-section text-white" data-animate="fadeInUp">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div class="mb-3 mb-md-0">
            <h3 class="mb-3 text-white">Selamat Datang, <?= $user['nama'] ?></h3>
            <p class="mb-0 text-white">Selamat datang di SIMAS AL-MUHTARAM - Sistem Informasi Pengelolaan Masjid</p>
        </div>
        <div class="text-end text-md-start">
            <p class="mb-1 text-white"><i class="far fa-calendar me-2"></i>
                <?php
                $date = new DateTime();
                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                $formatter->setPattern('EEEE, dd MMMM yyyy');
                echo $formatter->format($date);
                ?>
            </p>
        </div>
    </div>
</div>

<div class="col-lg-4 col-12">
    <div class="small-box bg-info" data-animate="slideInRight">
        <div class="inner">
            <h5 class="text-white ml-2 mt-2">Total Kas Internal</h5>
            <p>
            <h4 class="text-white ml-2"><b>Rp. <?= $totalkasinternal ?></b></h4>
            </p>
        </div>
        <div class="icon">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="card-footer p-1 bg-info text-center">
            <a href="<?= base_url('KasInternal') ?>" class="text-white">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="col-lg-4 col-12">
    <div class="small-box bg-green" data-animate="slideInRight">
        <div class="inner">
            <h5 class="text-white ml-2 mt-2">Total Dana Masuk</h5>
            <p>
            <h4 class="text-white ml-2"><b>Rp. <?= number_format(array_sum($pemasukankasinternal)) ?></b></h4>
            </p>
        </div>
        <div class="icon">
            <i class="far fa-plus-square"></i>
        </div>
        <div class="card-footer p-1 bg-green text-center">
            <a href="<?= base_url('KasInternal/DanaMasuk') ?>" class="text-white">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="col-lg-4 col-12">
    <div class="small-box bg-red" data-animate="slideInRight">
        <div class="inner">
            <h5 class="text-white ml-2 mt-2">Total Dana Keluar</h5>
            <p>
            <h4 class="text-white ml-2"><b>Rp. <?= number_format(array_sum($pengeluarankasinternal)) ?></b></h4>
            </p>
        </div>
        <div class="icon">
            <i class="far fa-minus-square"></i>
        </div>
        <div class="card-footer p-1 bg-danger text-center">
            <a href="<?= base_url('KasInternal/DanaKeluar') ?>" class="text-white">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="col-lg-6 col-12">
    <div class="card" data-animate="scaleIn">
        <div class="card-header text-center">
            <h4>Keuangan 3 Bulan Akhir</h4>
        </div>
        <div class="card-body">
            <canvas id="kasChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<div class="col-lg-3 col-12">
    <div class="card" data-animate="scaleIn">
        <div class="card-header text-center">
            <h4>Pengumuman dan Kegiatan</h4>
        </div>
        <div class="card-body p-1">
            <canvas id="kegiatanChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<div class="col-lg-3 col-12">
    <div class="card" data-animate="scaleIn">
        <div class="card-header text-center">
            <h4>Jumlah Artikel Diterbitkan</h4>
        </div>
        <div class="card-body p-1">
            <canvas id="artikelChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<div class="col-lg-6 col-12">
    <div class="card complaint-card" data-animate="scaleIn">
        <div class="complaint-header">
            <h5 class="text-white mb-0">Pengaduan Masuk</h5>
            <div class="complaint-badge">
                <a href="<?= base_url('Pengaduan') ?>" class="text-white">
                    <?= count($pengaduan) ?> Aduan
                </a>
            </div>
        </div>
        <div class="card-body complaint-body">
            <div class="direct-chat-messages">
                <?php if (!empty($pengaduan)) : ?>
                    <?php foreach ($pengaduan as $key => $isi_pengaduan) : ?>
                        <a href="<?= base_url('Pengaduan') ?>">
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left text-danger"><?= $isi_pengaduan['nama_pengadu'] ?></span>
                                    <span class="direct-chat-timestamp float-right">
                                        <?php
                                        $tanggal = new DateTime($isi_pengaduan['created_at']);
                                        $formatter = IntlDateFormatter::create(
                                            'id_ID',
                                            IntlDateFormatter::LONG,
                                            IntlDateFormatter::NONE
                                        );
                                        $formatted_date = $formatter->format($tanggal);
                                        $formatted_time = $tanggal->format('H.i.s');
                                        echo $formatted_date . ' ' . '(' . $formatted_time . ' WIB)';
                                        ?>
                                    </span>
                                </div>
                                <div class="direct-chat-text ml-0">
                                    <?= $isi_pengaduan['masalah'] ?? 'Tidak terbaca'; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="text-center">
                        <p><b>Data pengaduan kosong.</b></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6 col-12">
    <div class="card donation-card" data-animate="scaleIn">
        <div class="donation-header">
            <h5 class="text-white mb-0">Donasi Masuk</h5>
            <div class="donation-badge">
                <a href="<?= base_url('Donasi/DonasiMasuk') ?>" class="text-white">
                    <?= count($donasi) ?> Donasi
                </a>
            </div>
        </div>
        <div class="card-body p-2">
            <?php if (empty($donasi)) : ?>
                <div class="text-center py-3">
                    <p class="text-muted mb-0">Tidak ada donasi masuk</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table donation-table table-hover mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>Pengirim</th>
                                <th>Jumlah</th>
                                <th>Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donasi as $key => $isi_donasi) : ?>
                                <tr class="text-center">
                                    <td><?= $isi_donasi['nama_rek_p'] ?></td>
                                    <td>Rp. <?= number_format($isi_donasi['jumlah'], 0) ?></td>
                                    <td><?= $isi_donasi['nama_rekening'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="kas-table-container card card-primary">
    <div class="card-header p-3" style="display: flex; justify-content: center; align-items: center;">
        <?php
        $date = new DateTime();
        $fmt = new IntlDateFormatter('id_ID', IntlDateFormatter::NONE, IntlDateFormatter::LONG);
        $fmt->setPattern('MMMM yyyy'); ?>
        <h4 class="card-title mb-0">Rekapitulasi Keuangan Internal (<?= $fmt->format($date); ?>)</h4>
    </div>
    <div class="card-body pb-0 pt-4">
        <div class="table-responsive">
            <table class="table kas-table">
                <thead>
                    <tr>
                        <th width="50px">No.</th>
                        <th width="120px">Tanggal</th>
                        <th width="150px">Masuk</th>
                        <th width="150px">Keluar</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($kasinternal_MA as $key => $isi_kas) :
                    ?>
                        <tr>
                            <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                <b><?= $no++; ?></b>
                            </td>
                            <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                <?php
                                setlocale(LC_TIME, 'id_ID');
                                $date = new DateTime($isi_kas['tgl']);
                                $formatter = IntlDateFormatter::create(
                                    'id_ID',
                                    IntlDateFormatter::NONE,
                                    IntlDateFormatter::NONE,
                                    null,
                                    null,
                                    'dd MMM yyyy'
                                );
                                echo $formatter->format($date);
                                ?>
                            </td>
                            <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                <?= $isi_kas['dana_masuk'] == 0 ? '' : 'Rp. ' . number_format($isi_kas['dana_masuk'], 0) ?>
                            </td>
                            <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                <?= $isi_kas['dana_keluar'] == 0 ? '' : 'Rp. ' . number_format($isi_kas['dana_keluar'], 0) ?>
                            </td>
                            <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                <?= $isi_kas['keterangan'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="kas-table-footer card-footer">
        <div class="legend-item">
            <i class="fas fa-circle text-success"></i> Dana Masuk
        </div>
        <div class="legend-item">
            <i class="fas fa-circle text-danger"></i> Dana Keluar
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('kasChart').getContext('2d');
    var kasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $bulan ?>,
            datasets: [{
                    label: 'Dana Masuk',
                    data: <?= $danaMasuk ?>,
                    backgroundColor: 'rgba(46, 204, 113, 0.7)',
                    borderColor: 'rgba(39, 174, 96, 1)',
                    borderWidth: 2,
                    borderRadius: 5,
                    borderSkipped: false
                },
                {
                    label: 'Dana Keluar',
                    data: <?= $danaKeluar ?>,
                    backgroundColor: 'rgba(231, 76, 60, 0.7)',
                    borderColor: 'rgba(192, 57, 43, 1)',
                    borderWidth: 2,
                    borderRadius: 5,
                    borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        }
    });
</script>

<script>
    var ctxKegiatan = document.getElementById('kegiatanChart').getContext('2d');
    var kegiatanChart = new Chart(ctxKegiatan, {
        type: 'line',
        data: {
            labels: <?= $kegiatanBulan ?>,
            datasets: [{
                label: 'Jumlah Kegiatan',
                data: <?= $totalKegiatan ?>,
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>

<script>
    var ctxArtikel = document.getElementById('artikelChart').getContext('2d');
    var artikelChart = new Chart(ctxArtikel, {
        type: 'line',
        data: {
            labels: <?= $artikelBulan ?>,
            datasets: [{
                label: 'Jumlah Artikel',
                data: <?= $totalArtikel ?>,
                fill: true,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(153, 102, 255, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(153, 102, 255, 1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const welcomeSection = document.querySelector('.welcome-section');
        if (welcomeSection) welcomeSection.setAttribute('data-animate', 'fadeInUp');
        const smallBoxes = document.querySelectorAll('.small-box');
        smallBoxes.forEach(box => box.setAttribute('data-animate', 'slideInRight'));
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => card.setAttribute('data-animate', 'scaleIn'));
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(row => row.setAttribute('data-animate', 'fadeInUp'));

        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.bottom >= 0 &&
                rect.left <= (window.innerWidth || document.documentElement.clientWidth) &&
                rect.right >= 0
            );
        }

        function handleScrollAnimation() {
            const elements = document.querySelectorAll('[data-animate]');

            elements.forEach(element => {
                if (isElementInViewport(element)) {
                    element.classList.add('animate-visible');
                }
            });
        }
        handleScrollAnimation();
        window.addEventListener('scroll', handleScrollAnimation);
    });
</script>

<style>
    .welcome-section {
        background: linear-gradient(135deg, #ea9a06 0%, #FFA500 100%);
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 576px) {
        .text-end {
            text-align: start !important;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    [data-animate] {
        opacity: 0;
    }

    [data-animate].animate-visible {
        opacity: 1;
    }

    [data-animate="fadeInUp"].animate-visible {
        animation: fadeInUp 0.8s ease forwards;
    }

    [data-animate="slideInRight"].animate-visible {
        animation: slideInRight 0.8s ease forwards;
    }

    [data-animate="scaleIn"].animate-visible {
        animation: scaleIn 0.8s ease forwards;
    }
</style>

<style>
    .complaint-card,
    .donation-card {
        background-color: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .complaint-card:hover,
    .donation-card:hover {
        transform: translateY(-5px);
    }

    .complaint-header,
    .donation-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 15px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .complaint-badge,
    .donation-badge {
        background-color: rgba(255, 255, 255, 0.2);
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: bold;
    }

    .complaint-body {
        max-height: 350px;
        overflow-y: auto;
    }

    .direct-chat-text:hover {
        background-color: rgb(128, 151, 198);
    }

    .donation-table {
        margin-bottom: 0;
    }

    .donation-table thead {
        background-color: #f1f3f5;
    }

    .donation-table tbody tr {
        transition: background-color 0.3s ease;
    }

    .donation-table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    @media (max-width: 768px) {
        .complaint-body {
            max-height: 250px;
        }
    }
</style>

<style>
    .kas-table-container {
        background-color: #f4f6f9;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .kas-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .kas-table thead {
        background-color: #f1f3f5;
        color: #333;
    }

    .kas-table thead th {
        padding: 15px 10px;
        text-align: center;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #dee2e6;
    }

    .kas-table tbody tr {
        transition: background-color 0.3s ease;
    }

    .kas-table tbody tr:nth-child(even) {
        background-color: rgba(0, 0, 0, 0.03);
    }

    .kas-table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .kas-table td {
        padding: 12px 10px;
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .kas-table .text-success {
        color: #28a745 !important;
        font-weight: 500;
    }

    .kas-table .text-danger {
        color: #dc3545 !important;
        font-weight: 500;
    }

    .kas-table-footer {
        background-color: #f8f9fa;
        padding: 10px 15px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        border-top: 1px solid #dee2e6;
    }

    .kas-table-footer .legend-item {
        display: flex;
        align-items: center;
        margin-right: 15px;
    }

    .kas-table-footer .legend-item i {
        margin-right: 5px;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .kas-table {
            font-size: 0.9rem;
        }

        .kas-table td,
        .kas-table th {
            padding: 8px 5px;
        }
    }
</style>