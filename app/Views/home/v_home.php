<?php if (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            title: 'Error!',
            text: '<?= session()->getFlashdata('error'); ?>',
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 4000,
        });
    </script>
<?php endif; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title animate-fade-up">SIMAK <span class="highlight">POLTEKSI</span></h1>
            <p class="hero-subtitle animate-fade-up delay-200">Memudahkan Pengelolaan Kampus, Layanan Mahasiswa, dan Menyebarkan Informasi Akademik.</p>
            <div class="cta-wrapper animate-fade-up delay-300">
                <a href="#artikel" class="cta-button">
                    Baca Artikel
                    <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Info Akademik -->
<div class="container-fluid py-4 bg-light pb-2">
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-4">
            <div class="text-center mb-3 mb-lg-0">
                <h4 class="mb-2"><i class="fas fa-graduation-cap me-2" style="color: #dc2626;"></i>Info Akademik</h4>
                <p class="fw-bold mb-0" style="color: #128C7E">
                    <?= $jadwal_akademik['semester_aktif'] ?>
                </p>
                <div class="text-muted">
                    <i class="fas fa-calendar-alt me-1"></i>
                    <span><?= $jadwal_akademik['minggu_ke'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="text-center text-white p-3 rounded-3" style="background-color: #128C7E;">
                <small class="d-block">Tahun Akademik</small>
                <span class="fs-5 fw-bold"><?= $jadwal_akademik['tahun_akademik'] ?></span>
                <div class="small">Semester Aktif</div>
            </div>
        </div>
    </div>
</div>


<!-- Bar Section -->
<section class="bar-section-1 bg-light">
    <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
    </div>
</section>

<!-- Running Text Pengumuman dan Kegiatan -->
<div class="container-fluid bg-light">
    <div class="announcement-container">
        <div class="announcement-text">
            <?php if (!empty($kegiatan)) : ?>
                <?php foreach ($kegiatan as $key => $isi_kegiatan) : ?>
                    <i class="fas fa-university announcement-icon"></i>
                    <?= $isi_kegiatan['judul'] ?> (<?= $isi_kegiatan['tgl'] ?> <?= isset($isi_kegiatan['waktu']) ? $isi_kegiatan['waktu'] : '' ?>)
                <?php endforeach; ?>
                <?php foreach ($pengumuman as $key => $isi_pengumuman) : ?>
                    <i class="fas fa-bullhorn announcement-icon"></i>
                    <?= $isi_pengumuman['judul'] ?> (<?= $isi_pengumuman['tgl'] ?>)
                <?php endforeach; ?>
                <i class="fa-solid fa-paperclip announcement-icon"></i>
                Untuk detail cek halaman Pengumuman
                <i class="fa-solid fa-paperclip announcement-icon"></i>
            <?php else : ?>
                <i class="fa-solid fa-circle-xmark announcement-icon"></i>
                Tidak ada Pengumuman atau Kegiatan
                <i class="fa-solid fa-circle-xmark announcement-icon"></i>
                Tidak ada Pengumuman atau Kegiatan
                <i class="fa-solid fa-circle-xmark announcement-icon"></i>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bar Section -->
<section class="bar-section bg-light">
    <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
    </div>
</section>

<!-- Layanan Section -->
<section class="services-section pt-0">
    <div class="container">
        <h2 class="section-title">Layanan Kami</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="service-card animate-fade-up">
                    <div class="service-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3 class="service-title">Kelola Pengaduan</h3>
                    <p class="service-description">Kelola pengaduan mahasiswa dengan cepat dan terstruktur untuk meningkatkan pelayanan di kampus.</p>
                    <a href="<?= base_url('Home/Pengaduan') ?>" class="service-link">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card animate-fade-up">
                    <div class="service-icon">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h3 class="service-title">Keuangan Kampus</h3>
                    <p class="service-description">Kelola dan pantau kas kampus secara transparan dan akuntabel. Laporan keuangan yang detail dan mudah diakses.</p>
                    <a href="<?= base_url('Home/RekapKeuangan') ?>" class="service-link">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card animate-fade-up">
                    <div class="service-icon">
                        <i class="fas fa-hand-holding-medical"></i>
                    </div>
                    <h3 class="service-title">Donasi & Beasiswa</h3>
                    <p class="service-description">Donasi untuk kampus dan beasiswa mahasiswa secara online dengan metode pembayaran yang aman.</p>
                    <a href="<?= base_url('Home/Beasiswa') ?>" class="service-link">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bar Section -->
<section class="bar-section">
    <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column" id="artikel">
    </div>
</section>

<!-- Artikel -->
<section class="article-section pt-0">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Artikel Terbaru</h2>
            <?php if (session()->get('user_id')) : ?>
                <p class="section-subtitle">
                    Temukan berbagai kegiatan, berita, dan artikel menarik seputar kampus.
                </p>
            <?php else : ?>
                <p class="section-subtitle">
                    Temukan berbagai kegiatan, berita, dan artikel menarik seputar kampus.
                    (Jika ingin informasi lebih, silakan <a href="<?= base_url('Auth/Login') ?>">Login</a> untuk melihat artikel private)
                </p>
            <?php endif; ?>
        </div>
        <?= form_open('Home' . '#artikel', ['class' => 'mb-4', 'id' => 'filterForm', 'method' => 'POST']) ?>
        <div class="row">
            <div class="col-md-4 mb-3">
                <select name="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kat_artikel as $kat) : ?>
                        <option value="<?= $kat['id_kat_artikel'] ?>" <?= ($kategori == $kat['id_kat_artikel']) ? 'selected' : '' ?>>
                            <?= esc($kat['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <div class="input-group">
                    <input type="search" name="search" class="form-control w-100" aria-label="Search" id="searchInput" placeholder="Cari artikel..." value="<?= esc($search) ?>">
                </div>
            </div>
            <div class="col-12 col-md-2 mb-3">
                <button class="btn btn-primary w-100" type="submit" id="searchButton">
                    <i class="fas fa-search" style="margin-right: 8px;"></i>Cari
                </button>
            </div>
        </div>
        <?= form_close() ?>
        <div id="artikelContainer">
            <div class="row g-4" id="articlesList">
                <?php if (!empty($artikel)) : ?>
                    <?php foreach ($artikel as $key => $isi_artikel) : ?>
                        <input hidden type="text" value="<?= $isi_artikel['slug'] ?>">
                        <?php
                        $tgl = new DateTime($isi_artikel['created_at']);
                        $tgl_format = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE); ?>
                        <?php
                        $is_private = $isi_artikel['status'] === 'Private';
                        $user_id = session()->get('user_id');
                        ?>
                        <?php if (!$is_private || ($is_private && $user_id)) : ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="article-card animate-fade-in">
                                    <div class="article-image">
                                        <span class="article-category" style="background: linear-gradient(135deg, #dc2626, #ef4444);"><?= $isi_artikel['nama_kategori'] ?></span>
                                        <a href="<?= base_url('Home/DetailArtikel/') . $isi_artikel['slug'] ?>"><img src="<?= base_url('uploaded/thumbnail_artikel/' . $isi_artikel['thumbnail']) ?>" alt="<?= $isi_artikel['judul'] ?>" class="img-fluid"></a>
                                    </div>
                                    <div class="article-content">
                                        <div class="article-date">
                                            <i class="far fa-calendar-alt"></i>
                                            <?= $tgl_format->format($tgl); ?>
                                            <?= $isi_artikel['status'] == 'Publish'
                                                ? '<span class="badge bg-success ms-2">Publikasi</span>'
                                                : '<span class="badge bg-primary ms-2">Privat</span>' ?>
                                        </div>
                                        <h3 class="article-title"><?= $isi_artikel['judul'] ?></h3>
                                        <a href="<?= base_url('Home/DetailArtikel/') . $isi_artikel['slug'] ?>" class="article-link">
                                            Baca Selengkapnya<i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Tidak ada artikel yang ditemukan.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer d-flex justify-content-between mt-4">
                <div>Total Artikel: <span id="totalArtikel"><?= $total_artikel ?></span></div>
                <div class="ml-auto" id="paginationContainer">
                    <?= $pager->links('artikel', 'pagination') ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('kategoriSelect').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        if (this.value === '') {
            document.getElementById('filterForm').submit();
        }
    });
</script>

<script>
    document.querySelectorAll('#paginationContainer a').forEach(function(link) {
        link.href = link.href + '#artikel';
    });
    window.addEventListener('hashchange', function() {
        var artikelSection = document.getElementById('artikel');
        if (artikelSection) {
            artikelSection.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll(
            '.service-card, .article-card, .prayer-time, .animate-fade-up, .animate-fade-in, .animate-slide-right'
        );

        function checkScroll() {
            animatedElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;
                const isVisible = (elementTop < window.innerHeight) && (elementBottom >= 0);
                if (isVisible && !element.classList.contains('has-animated')) {
                    element.classList.add('has-animated');
                    element.style.visibility = 'visible';
                }
            });
        }
        checkScroll();
        window.addEventListener('scroll', checkScroll);
    });
</script>

<!-- CSS Custom -->
<style>
    .icon-gradient-info {
        background: linear-gradient(to right, #17a2b8, #ffc107);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .bar-section {
        width: 100%;
        height: 5vh;
        background-color: #f8f9fa;
    }

    .bar-section-1 {
        width: 100%;
        height: 1vh;
        background-color: #f8f9fa;
    }
</style>