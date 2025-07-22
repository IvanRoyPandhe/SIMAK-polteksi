<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Al-Muhtaram | <?= $judul ?></title>

    <link rel="shortcut icon" type="image/png" href="<?= base_url('simas.ico') ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Font: Poppins for better typography -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=fallback">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="<?= base_url('layouting') ?>/home-style.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .cta-button {
            margin-top: 20px;
            padding: 15px 30px;
            font-size: 18px;
            background-color: #f8a500;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #d68400;
        }

        .service-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
        }

        .service-icon {
            font-size: 50px;
            color: #f8a500;
        }
    </style>
</head>

<body>
    <?php
    $db = \Config\Database::connect();
    $web = $db->table('tb_setting')->get()->getRowArray();
    ?>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand me-auto" href="<?= base_url() ?>"><img src="<?= base_url('pictures') ?>/logos/simas2.png" alt="Logo" srcset="" style="width: 120px; height: 60px;"></a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="<?= base_url('pictures') ?>/logos/simas2.png" alt="Logo" srcset="" style="width: 120px; height: 60px;"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?= $menu == 'home' ? 'active' : '' ?>" aria-current="page" href="<?= base_url() ?>">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link mx-lg-2 dropdown-toggle <?= $menu == 'keuangan' ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Keuangan
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('Home/RekapKeuangan') ?>#kasinternal">Kas Internal</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('Home/RekapKeuangan') ?>#inventaris">Inventaris</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?= $menu == 'kegiatan' ? 'active' : '' ?>" href="<?= base_url('Home/Kegiatan') ?>">Pengumuman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?= $menu == 'donasi' ? 'active' : '' ?>" href="<?= base_url('Home/Donasi') ?>">Donasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?= $menu == 'pengaduan' ? 'active' : '' ?>" href="<?= base_url('Home/Pengaduan') ?>">Pengaduan</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link mx-lg-2 dropdown-toggle <?= $menu == 'tentang' ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tentang
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('Home/ProfilMasjid') ?>">Profil Masjid</a></li>
                                <?php if (in_array(session()->get('level'), [1, 2])) : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('Admin') ?>">Dashboard</a></li>
                                <?php endif; ?>
                                <?php if (session()->get('user_id')) : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('Auth/MyProfile') . '/' . session()->get('user_id') ?>">My Profile</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if (session()->get('user_id')): ?>
                <a href="<?= base_url('Auth/Logout') ?>" class="logout-button">Logout</a>
            <?php else: ?>
                <a href="<?= base_url('Auth/Login') ?>" class="login-button">Login</a>
            <?php endif; ?>
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <?php
    if ($page) {
        echo view($page);
    }
    ?>
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-column">
                    <h5 class="footer-title">MASJID <?= $web['nama_masjid'] ?></h5>
                    <p class="footer-description">
                        Mewujudkan Keseimbangan Spiritual dan Sosial
                    </p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/masjidalmuhtaram/?locale=id_ID" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/watch?v=mjaw05ahdlw" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-4 footer-column">
                    <h5 class="footer-title">Link Cepat</h5>
                    <ul class="footer-links">
                        <li><a href="<?= base_url('Home/RekapKeuangan') ?>">Keuangan</a></li>
                        <li><a href="<?= base_url('Home/Kegiatan') ?>">Pengumuman</a></li>
                        <li><a href="<?= base_url('Home/Donasi') ?>">Donasi</a></li>
                        <li><a href="<?= base_url('Home/Pengaduan') ?>">Pengaduan</a></li>
                    </ul>
                </div>
                <div class="col-md-4 footer-column">
                    <h5 class="footer-title">Kontak Kami</h5>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt me-4"></i> <?= $web['alamat_masjid'] ?></li>
                        <li><i class="fas fa-phone-square-alt me-4"></i> - </li>
                        <li><i class="fas fa-envelope me-4"></i> - </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="copyright-text">
                            &copy; <?= date('Y') ?> MASJID <?= $web['nama_masjid'] ?>. All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Section -->
    <button id="scrollToTop" class="scroll-to-top" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 1000; width: 50px; height: 50px; border: none; border-radius: 50%; background-color: #ff9800; color: white; display: flex; justify-content: center; align-items: center; cursor: pointer;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="19" x2="12" y2="5"></line>
            <polyline points="5 12 12 5 19 12"></polyline>
        </svg>
    </button>
    <!-- End Scroll to Top -->

    <!-- REQUIRED SCRIPTS -->
    <!-- JS jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JS DataTables -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Optional SweetAlert2 for popup alerts -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                var flashMessage = document.getElementById('flashMessage');
                if (flashMessage) {
                    flashMessage.style.display = 'none';
                }
            }, 10000);
        };
    </script>

    <!-- Initialize DataTables Elements -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "paging": true,
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "searching": true,
                "lengthMenu": [
                    [10, -1],
                    [10, "All"]
                ]
            });
            $('.dataTables_length select').css('width', '60px');
        });
        $(function() {
            $("#example2").DataTable({
                "paging": true,
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "searching": true,
                "lengthMenu": [
                    [10, -1],
                    [10, "All"]
                ]
            });
            $('.dataTables_length select').css('width', '60px');
        });
    </script>

    <!-- Scroll to Top -->
    <script>
        const scrollToTopBtn = document.getElementById("scrollToTop");
        let isScrolling;
        window.addEventListener("scroll", () => {
            clearTimeout(isScrolling);
            isScrolling = setTimeout(() => {
                if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                    scrollToTopBtn.style.display = "flex";
                } else {
                    scrollToTopBtn.style.display = "none";
                }
            }, 100);
        });

        function smoothScrollToTop(duration = 800) {
            const start = document.documentElement.scrollTop || document.body.scrollTop;
            const startTime = performance.now();

            function scrollStep(timestamp) {
                const elapsedTime = timestamp - startTime;
                const progress = Math.min(elapsedTime / duration, 1);
                const ease = progress < 0.5 ?
                    2 * progress * progress :
                    -1 + (4 - 2 * progress) * progress;
                const position = start * (1 - ease);
                window.scrollTo(0, position);
                if (progress < 1) {
                    window.requestAnimationFrame(scrollStep);
                }
            }
            window.requestAnimationFrame(scrollStep);
        }
        scrollToTopBtn.addEventListener("click", () => {
            smoothScrollToTop(1200);
        });
    </script>

    <style>
        .footer-section {
            background-color: #ff9800;
            color: #fff;
            padding: 60px 0 0;
            margin-top: 0px;
        }

        .footer-column {
            margin-bottom: 10px;
        }

        .footer-title {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            text-align: center;
        }

        .footer-title:after {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: #004d40;
        }

        .footer-description {
            color: #ffffff99;
            line-height: 1.8;
        }

        .social-links {
            margin-top: 20px;
            text-align: center;
        }

        .social-link {
            display: inline-block;
            width: 35px;
            height: 35px;
            background-color: rgba(255, 255, 255, 0.1);
            text-align: center;
            line-height: 35px;
            border-radius: 50%;
            color: #fff;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: #004d40;
            color: #fff;
            transform: translateY(-3px);
        }

        .footer-links {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #ffffff99;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #004d40;
            padding-left: 5px;
        }

        .contact-info {
            list-style: none;
            padding: 0;
        }

        .contact-info li {
            color: #ffffff99;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .contact-info li i {
            margin-right: 10px;
            color: #004d40;
        }

        .footer-bottom {
            background-color: rgb(207, 124, 0);
            padding: 20px 0;
            margin-top: 10px;
        }

        .copyright-text {
            color: white;
            text-align: center;
            margin: 0;
        }

        @media (max-width: 768px) {
            .footer-column {
                text-align: center;
            }

            .footer-title:after {
                left: 50%;
                transform: translateX(-50%);
            }

            .social-links {
                text-align: center;
            }

            .contact-info li {
                justify-content: center;
            }
        }
    </style>

</body>

<!-- 
|======================================================|
| * SISTEM INFORMASI MASJID AGUNG AL-MUHTARAM KAJEN    |
| * Copyright © 2024 - MASJID AGUNG AL-MUHTARAM KAJEN  |
| * By MNV26x                                          |
| * Github: https://github.com/naufallevi              |
|======================================================|
-->

</html>