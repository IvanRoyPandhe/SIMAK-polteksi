<!-- Hero Section -->
<section class="navbar-section">
  <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
  </div>
</section>

<div class="container mt-4 mb-4">
  <div class="card">
    <div class="card-body">
      <h3 class="card-title mb-3"><b><?= $judul ?></b></h3>

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

      <?php if (session()->getFlashdata('errors')): ?>
        <script>
          let errors = `<?php foreach (session()->getFlashdata('errors') as $error): ?><?= $error; ?> <br> <?php endforeach; ?>`;
          Swal.fire({
            title: 'Kesalahan',
            html: errors,
            icon: 'error',
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
        <div class="alert alert-danger" id="flashMessage">
          <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
              <li><?= $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <p class="card-text text-muted">
        Layanan Pengaduan bagi jamaah dan masyarakat sekitar Masjid Agung Al-Muhtaram Kajen yang ingin menyampaikan keluhan dan laporan terkait fasilitas, kegiatan, atau pengelolaan masjid untuk mendukung kenyamanan dan keberlangsungan ibadah.
      </p>
      <div class="d-flex gap-2 mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-tambah">
          <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Ajukan Pengaduan</button>
      </div>
      <h4 class="mb-4 text-center">Tabel Pengaduan</h4>
      <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-sm align-middle" id="example1">
          <thead>
            <tr class="align-middle">
              <th class="text-center">No.</th>
              <th class="text-center" width="20%">Pengadu</th>
              <th class="text-center">Jenis</th>
              <th class="text-center" width="35%">Masalah</th>
              <th class="text-center" width="35%">Jawaban</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($pengaduan)): ?>
              <tr>
                <td colspan="5" class="text-center py-3">
                  <div class="d-flex flex-column align-items-center">
                    <i class="fas fa-info-circle fa-2x text-info mb-2" style="color: #198754 !important;"></i>
                    <span class="font-weight-bold">Data Tidak Tersedia</span>
                  </div>
                </td>
              </tr>
            <?php else: ?>
              <?php
              $no = 1;
              foreach ($pengaduan as $key => $isi_pengaduan) : ?>
                <tr>
                  <td class="text-center"><b><?= $no++ ?></b></td>
                  <td>
                    <?php
                    $nama_pengadu = $isi_pengaduan['nama_pengadu'];
                    $panjang_nama = strlen($nama_pengadu);
                    if ($panjang_nama > 2) {
                      $nama_terpotong = substr($nama_pengadu, 0, 1) . str_repeat('*', $panjang_nama - 2) . substr($nama_pengadu, -1);
                    } else {
                      $nama_terpotong = $nama_pengadu;
                    } ?>
                    <?= $nama_terpotong ?>
                  </td>
                  <td class="text-center"><?= $isi_pengaduan['jenis_masalah'] ?></td>
                  <td>
                    <?= $isi_pengaduan['masalah'] ?>
                    <br>
                    <div style="position: relative; padding-left: 20px;">
                      <i class="far fa-calendar" style="position: absolute; left: 0; top: 2px;"></i>
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
                    </div>
                  </td>
                  <td>
                    <?= $isi_pengaduan['jawaban'] ?>
                    <hr>
                    <?php if ($isi_pengaduan['status'] == '1'): ?>
                      <?php
                      $tanggal = new DateTime($isi_pengaduan['updated_at']);
                      $formatter = IntlDateFormatter::create(
                        'id_ID',
                        IntlDateFormatter::LONG,
                        IntlDateFormatter::NONE
                      );
                      $formatted_date = $formatter->format($tanggal);
                      $formatted_time = $tanggal->format('H.i.s');
                      ?>
                      <div style="position: relative; padding-left: 20px;">
                        <i class="far fa-calendar" style="position: absolute; left: 0; top: 2px;"></i>
                        <?= $formatted_date . ' (' . $formatted_time . ' WIB)' ?>
                      </div>
                    <?php endif; ?>
                    <div class="text-center">
                      <?= $isi_pengaduan['status'] == '0'
                        ? '<span class="badge bg-secondary">Belum Dikonfirmasi</span>'
                        : '<span class="badge bg-primary">Telah Dikonfirmasi</span>' ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- /.modal-create -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
        <h5 class="modal-title"><?= $judul ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open_multipart('Home/InsertPengaduan') ?>
        <div class="mb-3">
          <label for="nama_pengadu" class="form-label">Nama :</label>
          <input type="text" class="form-control" id="nama_pengadu" name="nama_pengadu" placeholder="Masukkan nama anda" maxlength="80" required>
        </div>
        <div class="mb-3">
          <label for="no_hp" class="form-label">
            Nomor HP:
            <p class="text-danger mb-0">*Isi No HP dan Deskripsi untuk balasan pribadi</p>
          </label>
          <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" maxlength="15">
        </div>
        <div class="mb-3">
          <label for="jenis_masalah" class="form-label">Jenis Masalah :</label>
          <select class="form-select" id="jenis_masalah" name="jenis_masalah" required>
            <option value="" selected disabled>Pilih jenis masalah</option>
            <option value="Fasilitas">Fasilitas</option>
            <option value="Kegiatan">Kegiatan</option>
            <option value="Lainnya">Lainnya</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="masalah" class="form-label">Deskripsi Masalah :</label>
          <textarea class="form-control" id="masalah" name="masalah" rows="3" placeholder="Jelaskan masalah yang Anda alami" maxlength="255" required></textarea>
        </div>
        <div class="mb-3">
          <label for="lampiran" class="form-label">
            Lampiran :
            <p class="text-danger mb-0">*Opsional</p>
          </label>
          <div class="input-group">
            <div class="custom-file">
              <input class="form-control custom-file-input" type="file" name="lampiran" id="lampiran" accept="image/*">
              <label class="form-control custom-file-label" for="lampiran" hidden></label>
            </div>
          </div>
          <div id="image-preview" class="mt-3 text-center">
            <img id="preview" src="#" alt="Preview Gambar" class="img-fluid rounded" style="display: none; max-width: 150px; max-height: 150px;">
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<script>
  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileInput = e.target;
    var fileName = fileInput.files[0].name;
    var label = fileInput.nextElementSibling;
    label.innerText = fileName;
    if (fileInput.files && fileInput.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var previewImage = document.getElementById('preview');
        previewImage.src = e.target.result;
        previewImage.style.display = 'block';
      };
      reader.readAsDataURL(fileInput.files[0]);
    }
  });
</script>

<style>
  .navbar-section {
    width: 100%;
    height: 15vh;
  }

  .custom-file {
    width: 100%;
  }

  #image-preview {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 1rem;
  }

  #preview {
    max-width: 150px;
    max-height: 150px;
    display: none;
  }

  #example1_wrapper .dataTables_length {
    /* display: none; */
    margin-bottom: 10px;
  }

  #example1 {
    border-top: 2px solid #dee2e6 !important;
  }

  #example1 thead {
    border-top: 2px solid #dee2e6 !important;
  }

  .card {
    animation: slideInUp 0.6s ease-out;
    transition: all 0.3s ease;
  }

  .card:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .table {
    animation: fadeIn 0.8s ease-out;
  }

  .table thead tr {
    animation: slideInDown 0.5s ease-out;
  }

  .table tbody tr {
    animation: slideInRight 0.5s ease-out;
    animation-fill-mode: both;
  }

  .modal.fade .modal-dialog {
    animation: modalSlideIn 0.4s ease-out;
  }

  .modal-content {
    animation: modalFadeIn 0.5s ease-out;
  }

  .form-control,
  .form-select {
    transition: all 0.3s ease;
  }

  .form-control:focus,
  .form-select:focus {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .btn {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .btn:hover {
    transform: translateY(-2px);
  }

  .btn::after {
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
    transition: 0.6s;
    opacity: 0;
  }

  .btn:hover::after {
    opacity: 1;
    transform: rotate(30deg) translateX(100%);
  }

  .badge {
    animation: badgePulse 2s infinite;
  }

  .d-flex.flex-column.align-items-center {
    animation: bounceIn 1s ease-out;
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

  @keyframes slideInUp {
    from {
      transform: translateY(30px);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
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

  @keyframes slideInDown {
    from {
      transform: translateY(-20px);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  @keyframes slideInRight {
    from {
      transform: translateX(20px);
      opacity: 0;
    }

    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  @keyframes modalSlideIn {
    from {
      transform: translateY(-100px);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  @keyframes modalFadeIn {
    from {
      opacity: 0;
      transform: scale(0.95);
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  @keyframes badgePulse {
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
      transform: scale(0.9);
    }

    100% {
      opacity: 1;
      transform: scale(1);
    }
  }

  .table tbody tr {
    transition: all 0.3s ease;
  }

  .table tbody tr:hover {
    background-color: rgba(25, 135, 84, 0.1);
    transform: scale(1.01);
  }

  @media (prefers-reduced-motion: reduce) {
    * {
      animation: none !important;
      transition: none !important;
    }
  }
</style>