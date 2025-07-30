<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile | <?= $setting['nama_kampus'] ?? 'SIMAK POLTEKSI' ?></title>

  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('polteksi.ico') ?>">
  <link rel="stylesheet" href="<?= base_url('layouting') ?>/myprofile-style.css">
  <!-- ========== Start AdminLTE ========== -->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/dist/css/adminlte.min.css">
  <!-- ========== End AdminLTE ========== -->

  <!-- ========== Start Mazer ========== -->
  <link rel="stylesheet" href="<?= base_url('Mazer') ?>/assets/compiled/css/app.css">
  <link rel="stylesheet" href="<?= base_url('Mazer') ?>/assets/compiled/css/app-dark.css">
  <link rel="stylesheet" href="<?= base_url('Mazer') ?>/assets/compiled/css/iconly.css">
  <!-- ========== End Mazer ========== -->

  <!-- ========== Start CDN ========== -->
  <!-- SweetAlert2 CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- jQuery dan Bootstrap CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- ========== End CDN ========== -->

</head>

<body>
  <script src="<?= base_url('Mazer') ?>/assets/static/js/initTheme.js"></script>
  <div class="container mt-5">
    <div class="col-md-12 mx-auto">
      <div class="page-heading">
        <div class="page-title">
          <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3><?= $judul ?></h3>
              <p class="text-subtitle text-muted">Kelola dan perbarui informasi profil Anda dengan mudah</p>
            </div>
          </div>
        </div>
        <section class="section">
          <div class="row">
            <div class="col-12 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-2xl">
                      <img src="<?= base_url('uploaded/profil_user/' . session()->get('profil')) ?>" alt="Avatar">
                    </div>
                    <h3 class="mt-3 text-center"><?= session()->get('nama') ?></h3>
                    <p class="text-small"><?= session()->get('jabatan') ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-8">
              <div class="card">
                <div class="card-body">
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

                  <?php if (session()->getFlashdata('info')): ?>
                    <div class="alert bg-info" id="flashMessage">
                      <?= session()->getFlashdata('info'); ?>
                    </div>
                  <?php endif; ?>

                  <?php if (session()->getFlashdata('errors')): ?>
                    <script>
                      let errors = `<?php foreach (session()->getFlashdata('errors') as $error): ?><?= $error; ?> <br> <?php endforeach; ?>`;
                      Swal.fire({
                        title: 'Kesalahan!',
                        html: errors,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        timer: 4000,
                      });
                    </script>
                  <?php endif; ?>

                  <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger" id="flashMessage">
                      <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                          <li><?= $error; ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endif; ?>
                  <br>
                  <?= form_open_multipart('Auth/EditProfile') ?>
                  <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                    </div>
                    <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= set_value('nama', $user['nama']) ?>" maxlength="50" required>
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= set_value('email', $user['email']) ?>" maxlength="100" autocomplete="email" required>
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password lama (Optional ganti)" maxlength="100" data-initial autocomplete="current-password">
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password_baru" class="form-control" placeholder="Password baru (Optional ganti)" maxlength="100" data-initial autocomplete="new-password">
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-file-image"></i></span>
                    </div>
                    <div class="custom-file">
                      <input class="custom-file-input" type="file" name="profil" accept="image/*">
                      <label class="custom-file-label">Upload Foto</label>
                    </div>
                  </div>
                  <div id="image-preview" class="text-center">
                    <img id="preview" src="<?= base_url('uploaded/profil_user/' . $user['profil']) ?>" alt="Preview Gambar">
                  </div>
                  <div class="d-flex justify-content-between mt-4">
                    <?php $level = session()->get('level'); ?>
                    <div class="d-flex">
                      <?php if ($level == 1 || $level == 2): ?>
                        <a href="<?= base_url('admin') ?>" class="btn btn-outline-warning me-2" role="button">
                          Dashboard
                        </a>
                        <a href="<?= base_url() ?>" class="btn btn-outline-warning" role="button">
                          Home
                        </a>
                      <?php endif; ?>
                      <?php if ($level == 3): ?>
                        <a href="<?= base_url() ?>" class="btn btn-outline-warning" role="button">
                          Home
                        </a>
                      <?php endif; ?>
                    </div>
                    <button id="btn-ubah" type="submit" class="btn btn-primary" disabled>Ubah</button>
                  </div>
                  <?= form_close(); ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <!-- ========== Start AdminLTE ========== -->
  <!-- jQuery -->
  <script src="<?= base_url('AdminLTE') ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('AdminLTE') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('AdminLTE') ?>/dist/js/adminlte.min.js"></script>
  <!-- ========== End AdminLTE ========== -->

  <!-- ========== Start Mazer ========== -->
  <script src="<?= base_url('Mazer') ?>/assets/static/js/components/dark.js"></script>
  <script src="<?= base_url('Mazer') ?>/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="<?= base_url('Mazer') ?>/assets/compiled/js/app.js"></script>
  <!-- ========== End Mazer ========== -->

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

  <!-- Scripts -->
  <script>
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
      var fileName = e.target.files[0]?.name || 'Upload Foto';
      this.nextElementSibling.innerText = fileName;
      if (e.target.files && e.target.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('preview').src = e.target.result;
        };
        reader.readAsDataURL(e.target.files[0]);
      }
    });
  </script>

  <script>
    function checkChanges() {
      let hasChanged = false;
      document.querySelectorAll('[data-initial]').forEach(input => {
        if (input.type === 'file') {
          if (input.files.length > 0) {
            hasChanged = true;
          }
        } else if (input.value !== input.dataset.initial) {
          hasChanged = true;
        }
      });
      const btnUbah = document.getElementById('btn-ubah');
      btnUbah.disabled = !hasChanged;
    }
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('input, select, textarea').forEach(input => {
        if (input.type !== 'file') {
          input.dataset.initial = input.value;
        }
      });
      document.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('input', checkChanges);
      });
      const fileInput = document.querySelector('.custom-file-input');
      fileInput.addEventListener('change', function() {
        fileInput.dataset.initial = fileInput.files.length > 0 ? 'file-selected' : '';
        checkChanges();
      });
      document.querySelector('.custom-file-input').addEventListener('change', checkChanges);
    });
    document.getElementById('btn-ubah').addEventListener('click', function(e) {
      if (this.disabled) {
        e.preventDefault();
        Swal.fire({
          title: 'Tidak ada perubahan!',
          text: 'Silakan ubah data terlebih dahulu sebelum menyimpan.',
          icon: 'warning',
          confirmButtonText: 'OK',
        });
      }
    });
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (document.getElementById('btn-ubah').disabled) {
        Swal.fire({
          title: 'Tidak ada perubahan!',
          text: 'Silakan ubah data terlebih dahulu sebelum menyimpan.',
          icon: 'info',
          confirmButtonText: 'OK',
        });
      } else {
        Swal.fire({
          title: 'Konfirmasi',
          text: 'Anda yakin ingin menyimpan perubahan?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Simpan',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      }
    });
  </script>

  <script>
    document.querySelector('form').addEventListener('submit', function(e) {
      if (!document.getElementById('btn-ubah').disabled) {
        document.querySelector('.card-body').style.opacity = '0.7';
        document.querySelector('.card-body').style.pointerEvents = 'none';
      }
    });
    document.addEventListener('DOMContentLoaded', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
    document.querySelectorAll('.input-group').forEach(group => {
      group.addEventListener('mouseover', function() {
        this.querySelector('.input-group-text').style.backgroundColor = '#f8f9fa';
      });
      group.addEventListener('mouseout', function() {
        this.querySelector('.input-group-text').style.backgroundColor = '#e6eef5';
      });
    });
  </script>

  <style>
    .avatar-2xl {
      width: 150px;
      height: 150px;
    }

    .avatar-2xl img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>

</body>

</html>