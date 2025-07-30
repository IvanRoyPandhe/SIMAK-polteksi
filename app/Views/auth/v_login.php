<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMAK POLTEKSI | <?= $judul ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('polteksi.ico') ?>">
    <!-- Bootsrap 5 -->
    <link rel="stylesheet" href="<?= base_url('layouting') ?>/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- My Style CSS -->
    <link rel="stylesheet" href="<?= base_url('layouting') ?>/login-style.css">
    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(-45deg, #dc2626, #ef4444, #f87171, #fca5a5);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            height: 100vh;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(220, 38, 38, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(239, 68, 68, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(248, 113, 113, 0.2) 0%, transparent 50%);
            z-index: -1;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .box-area {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
        }

        .left-box {
            position: relative;
            overflow: hidden;
        }

        .left-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
    </style>

</head>

<body>
    <?php if (session()->getFlashdata('info')) : ?>
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('info'); ?>',
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 4000,
            });
        </script>
    <?php endif; ?>
    <!--------------------- Main Container --------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!--------------------- Login Container --------------------->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!--------------------- Left Box --------------------->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);" style="background: #dc2626;">
                <div class="featured-image mb-3">
                    <a href="<?= base_url() ?>"><img src="<?= base_url('pictures') ?>/login-images/1.png" class="img-fluid responsive-img"></a>
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 700;">SIMAK POLTEKSI</p>
                <small class="text-white text-wrap text-center mb-3" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Memudahkan Pengelolaan Kampus, Layanan Mahasiswa, dan Menyebarkan Informasi Akademik.</small>
            </div>
            <!--------------------- Right Box --------------------->
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-2">
                        <h2>Selamat Datang</h2>
                        <p>Silahkan login untuk memulai</p>
                    </div>
                    <?= form_open('Auth/CekUser') ?>
                    <?= csrf_field() ?>
                    <?php
                    $isInvalidEmail = (session()->getFlashdata('errEmail')) ? 'is-invalid' : '';
                    $isInvalidPassword = (session()->getFlashdata('errPassword')) ? 'is-invalid' : '';
                    ?>
                    <div class="input-group mb-2">
                        <input class="form-control form-control-lg bg-light fs-6 <?= $isInvalidEmail ?>" type="email" name="email" placeholder="Masukkan email" value="<?= set_value('email') ?>" maxlength="100" required>
                        <?php if (session()->getFlashdata('errEmail')) : ?>
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= session()->getFlashdata('errEmail') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-4">
                        <input class="form-control form-control-lg bg-light fs-6 <?= $isInvalidPassword ?>" type="password" name="password" placeholder="Masukkan password" maxlength="100" required>
                        <?php if (session()->getFlashdata('errPassword')) : ?>
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= session()->getFlashdata('errPassword') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <button class="btn btn-lg w-100 fs-6" style="background-color: #dc2626;" type="submit">Login</button>
                    </div>
                    <?php form_close() ?>
                    <div class="row">
                        <small>Jika belum memiliki akun silahkan <a href="<?= base_url('Auth/Register') ?>">Register disini</a></small>
                    </div>
                    <div class="row mt-3">
                        <div class="text-center">
                            <a href="<?= base_url() ?>" class="btn btn-outline-secondary btn-sm px-4 py-2">
                                <i class="fas fa-home me-2"></i>Kembali ke Home
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');
            emailInput.focus();
            emailInput.addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    passwordInput.focus();
                }
            });
        });
    </script>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            button.classList.add('loading');
        });
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>

</body>

</html>