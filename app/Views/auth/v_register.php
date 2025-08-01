<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>POLTEKSI | <?= $judul ?></title>

  <link rel="shortcut icon" type="image/png" href="<?= base_url('simas.ico') ?>">
  <!-- Bootsrap 5 -->
  <link rel="stylesheet" href="<?= base_url('layouting') ?>/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <!-- My Style CSS -->
  <link rel="stylesheet" href="<?= base_url('layouting') ?>/login-style.css">
  <!-- SweetAlert2 CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-image: url('<?= base_url('pictures') ?>/bg.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      height: 100vh;
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
      <div class="col-md-6 right-box">
        <div class="row align-items-center">
          <div class="header-text mb-1">
            <h2>Daftar Akun Baru</h2>
            <p>Silakan buat akun untuk memulai</p>
          </div>
          <?= form_open('Auth/InsertRegister') ?>
          <?= csrf_field() ?>
          <?php
          $isInvalidNama = (session()->getFlashdata('errNama')) ? 'is-invalid' : '';
          $isInvalidEmail = (session()->getFlashdata('errEmail')) ? 'is-invalid' : '';
          $isInvalidPassword = (session()->getFlashdata('errPassword')) ? 'is-invalid' : '';
          $isInvalidConfirmPassword = (session()->getFlashdata('errConfirmPassword')) ? 'is-invalid' : '';
          ?>
          <div class="input-group mb-2">
            <input class="form-control form-control-lg bg-light fs-6 <?= $isInvalidNama ?>" type="text" name="nama" placeholder="Masukkan nama lengkap" value="<?= set_value('nama') ?>" maxlength="50" required>
            <?php if (session()->getFlashdata('errNama')) : ?>
              <div id="validationServer03Feedback" class="invalid-feedback">
                <?= session()->getFlashdata('errNama') ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="input-group mb-2">
            <input class="form-control form-control-lg bg-light fs-6 <?= $isInvalidEmail ?>" type="email" name="email" placeholder="Masukkan email" value="<?= set_value('email') ?>" maxlength="100" required>
            <?php if (session()->getFlashdata('errEmail')) : ?>
              <div id="validationServer03Feedback" class="invalid-feedback">
                <?= session()->getFlashdata('errEmail') ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="input-group mb-2">
            <input class="form-control form-control-lg bg-light fs-6 <?= $isInvalidPassword ?>" type="password" name="password" placeholder="Masukkan password" maxlength="100" required>
            <?php if (session()->getFlashdata('errPassword')) : ?>
              <div id="validationServer03Feedback" class="invalid-feedback">
                <?= session()->getFlashdata('errPassword') ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="input-group mb-3">
            <input class="form-control form-control-lg bg-light fs-6 <?= $isInvalidConfirmPassword ?>" type="password" name="confirm_password" placeholder="Konfirmasi password" maxlength="100" required>
            <?php if (session()->getFlashdata('errConfirmPassword')) : ?>
              <div id="validationServer03Feedback" class="invalid-feedback">
                <?= session()->getFlashdata('errConfirmPassword') ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="input-group mb-3">
            <button class="btn btn-lg w-100 fs-6" style="background-color: #dc2626;" type="submit">Register</button>
          </div>
          <?php form_close() ?>
          <div class="row">
            <small>Jika sudah memiliki akun silahkan <a href="<?= base_url('Auth/Login') ?>">Login disini</a></small>
          </div>
        </div>
      </div>
      <!--------------------- Right Box --------------------->
      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);" style="background: #dc2626;">
        <div class="featured-image mb-3">
          <img src="<?= base_url('pictures') ?>/login-images/1.png" class="img-fluid responsive-img">
        </div>
        <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 700;">SIMAK POLTEKSI</p>
        <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Memudahkan Pengelolaan Kampus, Layanan Mahasiswa, dan Menyebarkan Informasi Akademik.</small>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const namaInput = document.querySelector('input[name="nama"]');
      const emailInput = document.querySelector('input[name="email"]');
      const passwordInput = document.querySelector('input[name="password"]');
      const confirmpasswordInput = document.querySelector('input[name="confirm_password"]');
      namaInput.focus();
      namaInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          emailInput.focus();
          passwordInput.focus();
          confirmpasswordInput.focus();
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