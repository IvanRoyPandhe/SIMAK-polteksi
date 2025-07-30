<!-- Hero Section -->
<section class="navbar-section">
    <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
    </div>
</section>

<div class="container my-4">
    <div class="card border-orange">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);-light border-orange">
            <div class="d-flex align-items-center">
                <i class="fas fa-mosque fa-2x text-orange me-3"></i>
                <?php
                $dateFormatter = new IntlDateFormatter(
                    'id_ID',
                    IntlDateFormatter::FULL,
                    IntlDateFormatter::NONE
                );
                $dateFormatter->setPattern('MMMM yyyy'); ?>
                <h4 class="mb-0 text-orange">
                    <b>Jadwal <?= $judul ?> (<?= $dateFormatter->format(new DateTime()); ?>)</b>
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if (empty($kegiatan)): ?>
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-info-circle fa-2x text-info mb-2" style="color: #dc2626 !important;"></i>
                        <span class="font-weight-bold">Data Tidak Tersedia</span>
                    </div>
                <?php else: ?>
                    <?php
                    $no = 1;
                    foreach ($kegiatan as $key => $isi_kegiatan) :
                    ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                            <div class="info-box d-flex align-items-start bg-light p-3 border rounded">
                                <div class="info-box-icon-orange">
                                    <?= $no++; ?>
                                </div>
                                <div class="ms-3">
                                    <h6 class="info-box-number fw-bold mb-1"><?= $isi_kegiatan['nama'] ?></h6>
                                    <?php
                                    $dateTime = new DateTime($isi_kegiatan['jam']);
                                    $formattedTime = $dateTime->format('H:i');
                                    ?>
                                    <p class="small text-muted mb-0">
                                        <i class="far fa-calendar-alt text-orange me-1"></i><?= $isi_kegiatan['tgl']; ?>
                                        <i class="fas fa-clock text-orange ms-2 me-1"></i><?= $formattedTime ?> - selesai
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="card border-green">
        <div class="card-header bg-green-light border-green">
            <div class="d-flex align-items-center">
                <i class="fas fa-bullhorn fa-2x text-green me-3"></i>
                <?php
                $dateFormatter = new IntlDateFormatter(
                    'id_ID',
                    IntlDateFormatter::FULL,
                    IntlDateFormatter::NONE
                );
                $dateFormatter->setPattern('EEEE, d MMMM yyyy');
                ?>
                <h4 class="mb-0 text-green">
                    <b>Pengumuman (<?= $dateFormatter->format(new DateTime()); ?>)</b>
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if (empty($kegiatan)): ?>
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-info-circle fa-2x text-info mb-2" style="color: #28a745 !important;"></i>
                        <span class="font-weight-bold">Data Tidak Tersedia</span>
                    </div>
                <?php else: ?>
                    <?php
                    $no = 1;
                    foreach ($pengumuman as $key => $isi_pengumuman) : ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                            <div class="info-box d-flex flex-column bg-light p-3 border rounded">
                                <div class="d-flex align-items-start">
                                    <div class="info-box-icon-green">
                                        <?= $no++; ?>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="info-box-number fw-bold mb-1"><?= $isi_pengumuman['nama'] ?></h6>
                                        <p class="small text-muted mb-0">
                                            <i class="far fa-calendar-alt text-green me-1"></i><?= $isi_pengumuman['tgl']; ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <p class="mb-1"><b>Keterangan :</b></p>
                                <p class="mt-2"><?= $isi_pengumuman['keterangan'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Kegiatan */
    .text-orange {
        color: #dc2626 !important;
    }

    .text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);-light {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(239, 68, 68, 0.1));
    }

    .border-orange {
        border-color: #dc2626 !important;
    }

    .info-box {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .info-box:hover {
        transform: scale(1.03);
    }

    .info-box-icon-orange {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: #fff;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-box-content h6 {
        color: #dc2626;
    }

    .progress-description i {
        margin-right: 4px;
    }

    /* Pengumuman  */
    .text-green {
        color: #28a745 !important;
    }

    .bg-green-light {
        background-color: #e8f5e9;
    }

    .border-green {
        border-color: #28a745 !important;
    }

    .info-box-icon-green {
        background-color: #28a745;
        color: #fff;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .info-box-content h6 {
        color: #28a745;
    }

    .navbar-section {
        width: 100%;
        height: 15vh;
    }

    .card {
        animation: slideIn 0.5s ease-out;
    }

    .card-header {
        animation: fadeIn 0.7s ease-out;
    }

    .info-box {
        animation: scaleIn 0.5s ease-out;
        animation-fill-mode: both;
    }

    .fa-2x {
        animation: swing 2s infinite;
    }

    .d-flex.flex-column.align-items-center {
        animation: bounceIn 1s ease-out;
    }

    .info-box-icon-orange,
    .info-box-icon-green {
        animation: pulse 2s infinite;
    }

    .col-lg-6:nth-child(odd) .info-box {
        animation-delay: 0.2s;
    }

    .col-lg-6:nth-child(even) .info-box {
        animation-delay: 0.4s;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes swing {

        0%,
        100% {
            transform: rotate(0deg);
        }

        20% {
            transform: rotate(8deg);
        }

        40% {
            transform: rotate(-8deg);
        }

        60% {
            transform: rotate(4deg);
        }

        80% {
            transform: rotate(-4deg);
        }
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }

        50% {
            opacity: 0.9;
            transform: scale(1.1);
        }

        80% {
            opacity: 1;
            transform: scale(0.89);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .info-box:hover .info-box-icon-orange,
    .info-box:hover .info-box-icon-green {
        animation: none;
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transition: all 0.3s ease;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .info-box-number {
        transition: color 0.3s ease;
    }

    .info-box:hover .info-box-number {
        color: #dc2626;
    }

    * {
        transition: background-color 0.3s ease,
            color 0.3s ease,
            transform 0.3s ease,
            box-shadow 0.3s ease;
    }

    @media (prefers-reduced-motion: reduce) {
        * {
            animation: none !important;
            transition: none !important;
        }
    }
</style>