<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul ?> | Al-Muhtaram</title>

    <link rel="shortcut icon" type="image/png" href="<?= base_url('simas.ico') ?>">

    <style>
        .sidebar-item.active .sidebar-link {
            background-color: orange !important;
            color: white !important;
        }

        /* Summernote */
        .note-editor .dropdown-toggle::after {
            all: unset;
        }

        .note-editor .note-dropdown-menu {
            box-sizing: content-box;
        }

        .note-editor .note-modal-footer {
            box-sizing: content-box;
        }

        /* Summernote BG */
        .note-editor.note-frame {
            background-color: white !important;
            opacity: 1 !important;
        }

        .note-editable {
            background-color: white !important;
        }

        .note-editor.note-frame.fullscreen {
            background-color: white !important;
            opacity: 1 !important;
        }
    </style>

    <!-- ========== Start AdminLTE ========== -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/dist/css/adminlte.min.css">
    <!-- ========== End AdminLTE ========== -->

    <!-- ========== Start Mazer ========== -->
    <link rel="stylesheet" href="<?= base_url('Mazer') ?>/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= base_url('Mazer') ?>/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="<?= base_url('Mazer') ?>/assets/compiled/css/iconly.css">
    <!-- Summernote -->
    <link rel="stylesheet" href="<?= base_url('Mazer') ?>/assets/extensions/summernote/summernote-lite.css">
    <link rel="stylesheet" href="<?= base_url() ?>/layouting/summernote-image-list.min.css">
    <!-- ========== End Mazer ========== -->

    <!-- ========== Start CDN ========== -->
    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ========== End CDN ========== -->
</head>

<body>
    <?php
    $db = \Config\Database::connect();
    $web = $db->table('tb_setting')->get()->getRowArray();
    ?>
    <script src="<?= base_url('Mazer') ?>/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="<?= base_url('Admin') ?>"><img src="<?= base_url('pictures') ?>/logos/simas2.png" alt="Logo" srcset="" style="width: 120px; height: 60px;"></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--system-uicons" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item <?= $menu == 'dashboard' ? 'active' : '' ?>">
                            <a href=" <?= base_url('Admin') ?>" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-title">Keuangan</li>
                        <?php if (session()->get('level') == 1): ?>
                            <li class="sidebar-item <?= $menu == 'kas-internal' ? 'active' : '' ?> has-sub">
                                <a href="#" class='sidebar-link'>
                                    <i class="fas fa-wallet"></i>
                                    <span>Kas Internal</span>
                                </a>
                                <ul class="submenu <?= $menu == 'kas-internal' ? 'active submenu-open' : '' ?>">
                                    <li class="submenu-item <?= $submenu == 'dana-masuk-internal' ? 'active' : '' ?>">
                                        <a href="<?= base_url('KasInternal/DanaMasuk') ?>" class="submenu-link"><i class="nav-icon far fa-circle text-success" style="margin-right: 8px;"></i>Dana Masuk</a>
                                    </li>
                                    <li class="submenu-item <?= $submenu == 'dana-keluar-internal' ? 'active' : '' ?>">
                                        <a href="<?= base_url('KasInternal/DanaKeluar') ?>" class="submenu-link"><i class="nav-icon far fa-circle text-danger" style="margin-right: 8px;"></i>Dana Keluar</a>
                                    </li>
                                    <li class="submenu-item <?= $submenu == 'rekap-kas-internal' ? 'active' : '' ?>">
                                        <a href="<?= base_url('KasInternal') ?>" class="submenu-link"><i class="nav-icon far fa-circle" style="margin-right: 8px;"></i>Rekapitulasi</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (session()->get('level') == 1): ?>
                            <li class="sidebar-item <?= $menu == 'donasi' ? 'active' : '' ?> has-sub">
                                <a href="#" class='sidebar-link'>
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>Donasi</span>
                                </a>
                                <ul class="submenu <?= $menu == 'donasi' ? 'active submenu-open' : '' ?>">
                                    <li class="submenu-item <?= $submenu == 'donasi-rekening' ? 'active' : '' ?>">
                                        <a href="<?= base_url('Donasi/Rekening') ?>" class="submenu-link"><i class="nav-icon fab fa-cc-visa text-secondary" style="margin-right: 8px;"></i>Rekening Masjid</a>
                                    </li>
                                    <li class="submenu-item <?= $submenu == 'donasi-masuk' ? 'active' : '' ?>">
                                        <a href="<?= base_url('Donasi/DonasiMasuk') ?>" class="submenu-link"><i class="nav-icon fas fa-hand-holding-medical text-secondary" style="margin-right: 8px;"></i>Donasi Masuk</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (session()->get('level') == 1): ?>
                            <li class="sidebar-item <?= $menu == 'bisyaroh' ? 'active' : '' ?>">
                                <a href=" <?= base_url('Bisyaroh') ?>" class='sidebar-link'>
                                    <i class="fas fa-handshake"></i>
                                    <span>Bisyaroh</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (session()->get('level') == 1): ?>
                            <li class="sidebar-item <?= $menu == 'inventaris' ? 'active' : '' ?>">
                                <a href=" <?= base_url('Inventaris') ?>" class='sidebar-link'>
                                    <i class="bi bi-archive-fill"></i>
                                    <span>Inventaris</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="sidebar-item <?= $menu == 'laporan' ? 'active' : '' ?> has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-book"></i>
                                <span>Laporan Keuangan</span>
                            </a>
                            <ul class="submenu <?= $menu == 'laporan-kas' ? 'active submenu-open' : '' ?>">
                                <li class="submenu-item <?= $submenu == 'laporan-kas-internal' ? 'active' : '' ?>">
                                    <a href="<?= base_url('Laporan/LaporanKas') ?>" class="submenu-link"><i class="nav-icon far bi bi-wallet" style="margin-right: 8px;"></i>Kas Internal</a>
                                </li>
                                <li class="submenu-item <?= $submenu == 'laporan-bisyaroh' ? 'active' : '' ?>">
                                    <a href="<?= base_url('Laporan/LaporanBisyaroh') ?>" class="submenu-link"><i class="nav-icon far fa-handshake text-secondary" style="margin-right: 8px;"></i>Bisyaroh</a>
                                </li>
                                <li class="submenu-item <?= $submenu == 'laporan-inventaris' ? 'active' : '' ?>">
                                    <a href="<?= base_url('Laporan/LaporanInventaris') ?>" class="submenu-link"><i class="nav-icon bi bi-archive" style="margin-right: 8px;"></i>Inventaris</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-title">Kegiatan</li>
                        <li class="sidebar-item <?= $menu == 'kegiatan' ? 'active' : '' ?>">
                            <a href=" <?= base_url('Kegiatan') ?>" class='sidebar-link'>
                                <i class="fas fa-calendar-check"></i>
                                <span>Pengumuman</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?= $menu == 'artikel' ? 'active' : '' ?> has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-newspaper"></i>
                                <span>Artikel</span>
                            </a>
                            <ul class="submenu <?= $menu == 'artikel' ? 'active submenu-open' : '' ?>">
                                <li class="submenu-item <?= $submenu == 'kategori-artikel' ? 'active' : '' ?>">
                                    <a href="<?= base_url('Artikel/Kategori') ?>" class="submenu-link">
                                        <i class="nav-icon fas fa-list" style="margin-right: 8px;"></i>
                                        Kategori
                                    </a>
                                </li>
                                <li class="submenu-item <?= $submenu == 'artikel-sub' ? 'active' : '' ?>">
                                    <a href="<?= base_url('Artikel') ?>" class="submenu-link">
                                        <i class="nav-icon fas fa-file-alt text-secondary" style="margin-right: 8px;"></i>
                                        Artikel
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item <?= $menu == 'pengaduan' ? 'active' : '' ?>">
                            <a href="<?= base_url('Pengaduan') ?>" class='sidebar-link'>
                                <i class="fas fa-question-circle"></i>
                                <span>Pengaduan</span>
                            </a>
                        </li>
                        <?php if (session()->get('level') == 1): ?>
                            <li class="sidebar-title">Setting</li>
                            <li class="sidebar-item <?= $menu == 'user-setting' ? 'active' : '' ?>">
                                <a href=" <?= base_url('User') ?>" class='sidebar-link'>
                                    <i class="fas fa-user-cog"></i>
                                    <span>User</span>
                                </a>
                            </li>
                            <li class="sidebar-item <?= $menu == 'web-setting' ? 'active' : '' ?>">
                                <a href=" <?= base_url('Admin/Setting') ?>" class='sidebar-link'>
                                    <i class="fas fa-cog"></i>
                                    <span>Web Profil</span>
                                </a>
                            </li>
                            <div class="sidebar-bottom-spacer"></div>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main" class='layout-navbar navbar-fixed'>
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600"><?= $user['nama'] ?></h6>
                                            <p class="mb-0 text-sm text-gray-600">
                                                <?php
                                                $levels = [1 => "Super Admin", 2 => "Admin", 3 => "Petugas", 4 => "Masyarakat"];
                                                echo $levels[$user['level_id']] ?? "Level tidak dikenali";
                                                ?>
                                            </p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="<?= base_url('uploaded/profil_user/' . $user['profil']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                                    <li><a class="dropdown-item" href="<?= base_url() ?>"><i class="icon-mid bi bi-house-door me-2"></i>
                                            Home</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('Auth/MyProfile/' . session()->get('user_id')) ?>"><i class="icon-mid bi bi-person me-2"></i> My
                                            Profile</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('Auth/Logout') ?>"><i
                                                class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <div class="page-heading">
                                    <h3><?= $judul; ?></h3>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= base_url('Admin') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $judul ?></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="row">
                            <?php if ($page) {
                                echo view($page);
                            } ?>
                        </div>
                    </section>
                </div>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted text-center">
                    <p><?= date('Y') ?> &copy; MASJID <?= $web['nama_masjid'] ?>. All Rights Reserved.</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- ========== Start AdminLTE ========== -->
    <!-- jQuery -->
    <script src="<?= base_url('AdminLTE') ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('AdminLTE') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="<?= base_url('AdminLTE') ?>/plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url('AdminLTE') ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('AdminLTE') ?>/dist/js/adminlte.min.js"></script>
    <!-- ========== End AdminLTE ========== -->

    <!-- ========== Start Mazer ========== -->
    <script src="<?= base_url('Mazer') ?>/assets/static/js/components/dark.js"></script>
    <script src="<?= base_url('Mazer') ?>/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('Mazer') ?>/assets/compiled/js/app.js"></script>
    <!-- Summernote -->
    <script src="<?= base_url('Mazer') ?>/assets/extensions/summernote/summernote-lite.min.js"></script>
    <script src="<?= base_url('Mazer') ?>/assets/static/js/pages/summernote.js"></script>
    <script src="<?= base_url() ?>/layouting/summernote-image-list.min.js"></script>
    <!-- ========== End Mazer ========== -->

    <!-- Initialize DataTables Elements -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "paging": true,
                "responsive": false,
                "lengthChange": true,
                "autoWidth": false,
            });
            $('.dataTables_length select').css('width', '60px');
            $("#example2").DataTable({
                "paging": true,
                "responsive": false,
                "lengthChange": true,
                "autoWidth": false,
            });
            $('.dataTables_length select').css('width', '60px');
        });
    </script>

    <!-- Initialize Summernote Elements -->
    <script>
        $('.summernote').summernote({
            placeholder: 'Silahkan diisi',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'imageList', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            dialogsInBody: true,
            imageList: {
                endpoint: "<?php echo site_url('Artikel/listGambar') ?>",
                fullUrlPrefix: "<?php echo base_url('uploaded/summernote') ?>/",
                thumbUrlPrefix: "<?php echo base_url('uploaded/summernote') ?>/"
            },
            callbacks: {
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        $.upload(files[i]);
                    }
                },
                onMediaDelete: function(target) {
                    $.delete(target[0].src);
                }
            },
        });
        $.upload = function(file) {
            let out = new FormData();
            out.append('file', file, file.name);
            $.ajax({
                method: 'POST',
                url: '<?php echo site_url('Artikel/uploadGambar') ?>',
                contentType: false,
                cache: false,
                processData: false,
                data: out,
                success: function(img) {
                    $('.summernote').summernote('insertImage', img);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };
        $.delete = function(src) {
            $.ajax({
                method: 'POST',
                url: '<?php echo site_url('Artikel/deleteGambar') ?>',
                cache: false,
                data: {
                    src: src
                },
                success: function(response) {
                    console.log(response);
                }
            });
        };
    </script>

    <!-- Initialize Select2 Elements -->
    <script>
        $(function() {
            $('.select2').select2({
                width: '100%'
            })
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>

    <!-- flashMessage -->
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

    <!-- SweetAlert2 Delete -->
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.closest('.delete-btn')) {
                const button = event.target.closest('.delete-btn');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const type = button.getAttribute('data-type');
                let message = '';
                let url = '';
                switch (type) {
                    case 'kegiatan':
                        message = `Kegiatan "${name}" akan dihapus!`;
                        url = `<?= base_url('Kegiatan/DeleteData/') ?>/${id}`;
                        break;
                    case 'kasinternal-masuk':
                    case 'kasinternal-keluar':
                        message = `Dana ${type === 'kasinternal-masuk' ? 'masuk' : 'keluar'} "${name}" akan dihapus!`;
                        url = `<?= base_url('KasInternal/DeleteData/') ?>/${id}/${type}`;
                        break;
                    case 'rekening':
                        message = `Data "${name}" akan dihapus!`;
                        url = `<?= base_url('Donasi/DeleteRekening/') ?>/${id}`;
                        break;
                    case 'donasimasuk':
                        message = `Data donasi "${name}" akan dihapus!`;
                        url = `<?= base_url('Donasi/DeleteDonasiMasuk/') ?>/${id}`;
                        break;
                    case 'user':
                        message = `User dengan email "${name}" akan dihapus!`;
                        url = `<?= base_url('User/DeleteUser/') ?>/${id}`;
                        break;
                    case 'bisyaroh':
                        message = `Data "${name}" akan dihapus!`;
                        url = `<?= base_url('Bisyaroh/DeleteData/') ?>/${id}`;
                        break;
                    case 'inventaris-masuk':
                        message = `Data "${name}" akan dihapus!`;
                        url = `<?= base_url('Inventaris/DeleteData/') ?>/${id}`;
                        break;
                    case 'inventaris-keluar':
                        message = `Data "${name}" akan dihapus!`;
                        url = `<?= base_url('Inventaris/DeleteDataKeluar/') ?>/${id}`;
                        break;
                    case 'kategori-artikel':
                        message = `Data "${name}" akan dihapus!`;
                        url = `<?= base_url('Artikel/DeleteKategori/') ?>/${id}`;
                        break;
                    case 'artikel':
                        message = `Data "${name}" akan dihapus!`;
                        url = `<?= base_url('Artikel/DeleteArtikel/') ?>/${id}`;
                        break;
                    case 'pengaduan':
                        message = `Data "${name}" akan dihapus!`;
                        url = `<?= base_url('Pengaduan/DeletePengaduan/') ?>/${id}`;
                        break;
                    case 'donasimasuk-barang':
                        message = `Data "${name}" akan dihapus!`;
                        url = `<?= base_url('Donasi/DeleteDonasiMasukBarang/') ?>/${id}`;
                        break;
                    default:
                        console.log('Tipe data tidak dikenal');
                        return;
                }
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff0000',
                    cancelButtonColor: '#f0ad4e',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Tutup',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }
        });
    </script>

    <style>
        .sidebar-bottom-spacer {
            height: 60px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .sidebar-bottom-spacer {
                height: 100px;
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