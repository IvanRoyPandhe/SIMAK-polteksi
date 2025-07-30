<?php
if ($kas == null) {
    $pemasukankasinternal[] = 0;
    $pengeluarankasinternal[] = 0;
} else {
    foreach ($kas as $key => $isi_kaskasinternal) {
        $pemasukankasinternal[] = $isi_kaskasinternal['dana_masuk'];
        $pengeluarankasinternal[] = $isi_kaskasinternal['dana_keluar'];
    }
}
$totalkasinternal = array_sum($pemasukankasinternal) - array_sum($pengeluarankasinternal);
$totalkasinternal = number_format($totalkasinternal);
?>

<!-- Hero Section -->
<section class="navbar-section" id="kasinternal">
    <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
    </div>
</section>

<div class="container my-4">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white text-center">
            <?php
            $date = new DateTime();
            $fmt = new IntlDateFormatter('id_ID', IntlDateFormatter::NONE, IntlDateFormatter::LONG);
            $fmt->setPattern('MMMM yyyy'); ?>
            <h4 class="card-title mb-0 p-2"><?= $judul ?> (<?= $fmt->format($date); ?>)</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead>
                        <tr class="align-middle">
                            <th style="width: 50px;">No.</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Dana Masuk</th>
                            <th>Dana Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kas)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-info-circle fa-2x text-info mb-2"></i>
                                        <span class="font-weight-bold">Data Tidak Tersedia</span>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            foreach ($kas as $key => $isi_kas) :
                            ?>
                                <tr class="<?= $isi_kas['status'] == 'Masuk' ? 'table-success' : 'table-danger' ?>">
                                    <td><b><?= $no++; ?></b></td>
                                    <td>
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
                                    <td><?= $isi_kas['keterangan'] ?></td>
                                    <td class="text-start">
                                        <?= $isi_kas['dana_masuk'] == 0 ? '' : 'Rp. ' . number_format($isi_kas['dana_masuk'], 0) ?>
                                    </td>
                                    <td class="text-start">
                                        <?= $isi_kas['dana_keluar'] == 0 ? '' : 'Rp. ' . number_format($isi_kas['dana_keluar'], 0) ?>
                                    </td>
                                </tr>
                    </tbody>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($kas)): ?>
                <tfoot>
                    <tr>
                        <th colspan="3">Jumlah</th>
                        <td class="text-start table-success">Rp. <?= number_format(array_sum($pemasukankasinternal)) ?></td>
                        <td class="text-start table-danger">Rp. <?= number_format(array_sum($pengeluarankasinternal)) ?></td>
                    </tr>
                </tfoot>
            <?php endif; ?>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-start align-items-center">
            <div>
                <i class="fas fa-circle text-success me-2"></i><span class="me-3">Dana Masuk</span>
                <i class="fas fa-circle text-danger me-2"></i><span>Dana Keluar</span>
            </div>
        </div>
    </div>
</div>

<!-- Bar Section -->
<section class="bar-section">
    <div id="inventaris" class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
    </div>
</section>

<div class="container my-4">
    <div class="card shadow-lg">
        <div class="card-header text-white text-center" style="background-color: #dc2626;">
            <h4 class="card-title mb-0 p-2"><?= $judul_inventaris ?></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <h3 class="card-title text-center mb-4">
                    <span class="bg-gradient-to-r from-info to-primary p-2 rounded-lg shadow-md">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        <span class="fw-bold" style="background: linear-gradient(45deg, #0dcaf0, #0d6efd); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Inventaris Masuk
                        </span>
                    </span>
                </h3>
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="50px">No.</th>
                            <th>Nama</th>
                            <th width="100px">Jumlah</th>
                            <th width="100px">Kondisi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kategoriList_masuk)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-info-circle fa-2x text-info mb-2" style="color: #0d6efd !important;"></i>
                                        <span class="font-weight-bold">Data Tidak Tersedia</span>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            foreach ($kategoriList_masuk as $kategori) : ?>
                                <tr class="bg-light">
                                    <td colspan="5" class="text-center text-secondary"><strong><?= $kategori ?></strong></td>
                                </tr>
                                <?php foreach ($inventaris_masuk as $item) :
                                    if ($item['kategori'] == $kategori) : ?>
                                        <tr class="text-center">
                                            <td><b><?= $no++; ?></b></td>
                                            <td class="text-start"><?= $item['nama'] ?></td>
                                            <td><?= $item['jumlah'] ?> <?= $item['satuan'] ?></td>
                                            <td><?= $item['kondisi'] ?></td>
                                            <td class="text-start"><?= $item['keterangan'] ?></td>
                                        </tr>
                                <?php endif;
                                endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <h3 class="card-title text-center mb-4">
                <span class="bg-gradient-to-r from-danger to-warning p-2 rounded-lg shadow-md">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    <span class="fw-bold" style="background: linear-gradient(45deg, #dc3545, #ffc107); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Inventaris Keluar
                    </span>
                </span>
            </h3>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="50px">No.</th>
                            <th>Nama</th>
                            <th width="100px">Jumlah</th>
                            <th width="100px">Kondisi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kategoriList_keluar)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-info-circle fa-2x text-info mb-2" style="color: #dc3545 !important;"></i>
                                        <span class="font-weight-bold">Data Tidak Tersedia</span>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            foreach ($kategoriList_keluar as $kategori) : ?>
                                <tr class="bg-light">
                                    <td colspan="5" class="text-center text-secondary"><strong><?= $kategori ?></strong></td>
                                </tr>
                                <?php foreach ($inventaris_keluar as $item) :
                                    if ($item['kategori'] == $kategori) : ?>
                                        <tr class="text-center">
                                            <td><b><?= $no++; ?></b></td>
                                            <td class="text-start"><?= $item['nama'] ?></td>
                                            <td><?= $item['jumlah'] ?> <?= $item['satuan'] ?></td>
                                            <td><?= $item['kondisi'] ?></td>
                                            <td class="text-start"><?= $item['keterangan'] ?></td>
                                        </tr>
                                <?php endif;
                                endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <i class="fas fa-clock text-warning me-2"></i>
                    <span>
                        <?php
                        if (!empty($last_update)) {
                            $update_time = new DateTime($last_update['updated_at']);
                            $formatter = IntlDateFormatter::create(
                                'id_ID',
                                IntlDateFormatter::LONG,
                                IntlDateFormatter::SHORT,
                                null,
                                null,
                                'dd MMMM yyyy, HH:mm:ss'
                            );
                            echo "Data terakhir diupdate pada: " . $formatter->format($update_time) . " WIB";
                        } else {
                            echo "Belum ada update data";
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .navbar-section {
        width: 100%;
        height: 15vh;
    }

    .bar-section {
        background-color: #fff;
        width: 100%;
        height: 15vh;
    }
</style>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            transform: scale(0.95);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .card {
        animation: scaleIn 0.5s ease-out;
    }

    .table thead tr {
        animation: slideIn 0.6s ease-out;
    }

    .table tbody tr {
        animation: fadeIn 0.5s ease-out;
        animation-fill-mode: both;
    }

    .table tbody tr:nth-child(1) {
        animation-delay: 0.1s;
    }

    .table tbody tr:nth-child(2) {
        animation-delay: 0.2s;
    }

    .table tbody tr:nth-child(3) {
        animation-delay: 0.3s;
    }

    .table tbody tr:nth-child(4) {
        animation-delay: 0.4s;
    }

    .table tbody tr:nth-child(5) {
        animation-delay: 0.5s;
    }

    .table tbody tr:nth-child(n+6) {
        animation-delay: 0.6s;
    }

    .card-footer {
        animation: fadeIn 0.8s ease-out;
    }

    .table tbody tr {
        transition: transform 0.2s ease-out;
    }

    .table tbody tr:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    tr.bg-light {
        animation: scaleIn 0.7s ease-out;
        animation-fill-mode: both;
    }

    td.text-start:not(:empty) {
        transition: color 0.3s ease;
    }

    td.text-start:not(:empty):hover {
        color: #0d6efd;
    }

    .card-header {
        position: relative;
        overflow: hidden;
    }

    .card-header::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0) 100%);
        transform: rotate(30deg);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        from {
            transform: translateX(-100%) rotate(30deg);
        }

        to {
            transform: translateX(100%) rotate(30deg);
        }
    }

    .table-bordered {
        border: 1px solid #dee2e6 !important;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6 !important;
    }

    .table-hover tbody tr:hover {
        border: 1px solid #dee2e6 !important;
    }

    .table-hover tbody tr:hover td {
        border-color: #dee2e6 !important;
    }

    .table-bordered thead th,
    .table-bordered tbody tr.bg-light td {
        border: 1px solid #dee2e6 !important;
    }

    .table-bordered> :not(caption)>*>* {
        border-width: 1px !important;
    }

    .table-responsive {
        position: relative;
        z-index: 1;
    }

    .table {
        position: relative;
        z-index: 2;
    }

    .table-bordered {
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    .table tbody tr td[colspan] {
        padding: 2rem !important;
    }

    .table tbody tr td[colspan] .fas {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .table tbody tr td[colspan] .font-weight-bold {
        color: #495057;
        font-size: 1.1rem;
    }

    .table tbody tr td[colspan]>div {
        animation: fadeIn 0.5s ease-out;
    }
</style>