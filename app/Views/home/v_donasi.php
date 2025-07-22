<section class="navbar-section">
  <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
  </div>
</section>

<div class="container my-5 mt-0">
  <div class="row g-4 mt-0">
    <div class="col-md-4">
      <div class="card border-warning shadow-sm">
        <div class="card-header d-flex align-items-center">
          <i class="fas fa-star-and-crescent fa-2x text-warning me-3"></i>
          <h4 class="mb-0"><b><?= $judul ?></b></h4>
        </div>
        <div class="card-body">
          <?php if (empty($rekening)): ?>
            <div class="d-flex flex-column align-items-center">
              <i class="fas fa-info-circle fa-2x text-info mb-2 text-warning"></i>
              <span class="font-weight-bold">Data Tidak Tersedia</span>
            </div>
          <?php else: ?>
            <?php foreach ($rekening as $key => $isi_rekening) : ?>
              <div class="info-box mb-3 shadow-sm">
                <span class="info-box-icon bg-warning text-white me-3"><i class="far fa-credit-card"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><b><?= $isi_rekening['nama_bank'] ?></b></span><br>
                  <i class="far fa-credit-card text-danger me-2"></i><span class="info-box-number"><?= $isi_rekening['no_rek'] ?></span><br>
                  <i class="fas fa-user text-danger me-2"></i><span class="info-box-text text-danger"><?= $isi_rekening['nama_rek'] ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card border-warning shadow-sm">
        <div class="card-header d-flex align-items-center">
          <i class="fas fa-hand-holding-medical fa-2x text-warning me-3"></i>
          <h4 class="mb-0"><b>Konfirmasi Donasi Tunai</b></h4>
        </div>
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
          <?php if (empty($rekening)): ?>
            <div class="d-flex flex-column align-items-center">
              <i class="fas fa-info-circle fa-2x text-info mb-2 text-warning"></i>
              <span class="font-weight-bold text-center">Mohon Maaf Form Donasi Belum Ada Karena Tidak Ada Data Rekening Masjid</span>
            </div>
          <?php else: ?>
            <?= form_open_multipart('Home/InsertDonasi') ?>
            <br>
            <div class="mb-3">
              <label for="rekening_id" class="form-label"><b>Rekening Penerima :</b></label>
              <select class="form-select" name="rekening_id" id="rekening_id" required>
                <option value="" disabled selected>Pilih rekening tujuan</option>
                <?php foreach ($rekening as $key => $isi_rekening) : ?>
                  <option value="<?= $isi_rekening['id_rekening'] ?>" <?= set_select('rekening_id', $isi_rekening['id_rekening']) ?>><?= $isi_rekening['nama_bank'] . ' --- ' . $isi_rekening['no_rek'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <div class="form-group">
                    <label for="nama_p" class="form-label"><b>Nama Pengirim :</b></label>
                    <input type="text" class="form-control" name="nama_p" id="nama_p" placeholder="Silahkan isikan nama pengirim" value="<?= set_value('nama_p') ?>" maxlength="100" required>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <div class="form-group">
                    <label for="nama_bank_p" class="form-label"><b>Nama Bank Pengirim :</b></label>
                    <input type="text" class="form-control" name="nama_bank_p" id="nama_bank_p" placeholder="Silahkan isikan nama bank pengirim" value="<?= set_value('nama_bank_p') ?>" maxlength="100" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <div class="form-group">
                    <label for="no_rek_p" class="form-label"><b>No. Rekening Pengirim :</b></label>
                    <input type="text" class="form-control" name="no_rek_p" id="no_rek_p" placeholder="Silahkan isikan no. rekening pengirim" value="<?= set_value('no_rek_p') ?>" maxlength="25" required>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <div class="form-group">
                    <label for="nama_rek_p" class="form-label"><b>Nama Rekening Pengirim :</b></label>
                    <input type="text" class="form-control" name="nama_rek_p" id="nama_rek_p" placeholder="Silahkan isikan nama rekening pengirim" value="<?= set_value('nama_rek_p') ?>" maxlength="100" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="jumlah" class="form-label"><b>Jumlah Donasi :</b></label>
              <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Silahkan isikan jumlah donasi" value="<?= set_value('jumlah') ?>" min="0" max="2147483647" required>
            </div>
            <div class="mb-3">
              <label for="bukti_transfer" class="form-label"><b>Bukti Transfer :</b></label>
              <div class="input-group">
                <div class="custom-file">
                  <input class="form-control custom-file-input" type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*" required>
                  <label class="form-control custom-file-label" for="bukti_transfer" hidden></label>
                </div>
              </div>
              <div id="image-preview" class="mt-3 text-center">
                <img id="preview" src="#" alt="Preview Gambar" class="img-fluid rounded" style="display: none; max-width: 150px; max-height: 150px;">
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-success w-auto w-sm-100">
                <i class="fas fa-paper-plane me-2"></i>Kirim
              </button>
            </div>
            <?= form_close() ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container my-4">
  <div class="card border-warning shadow-sm">
    <div class="card-header d-flex align-items-center">
      <i class="fa-regular fa-rectangle-list fa-2x text-warning me-3"></i>
      <i class="fa-solid fa-hand-holding-dollar fa-2x text-warning me-3"></i>
      <h4 class="mb-0"><b>Data Donasi Tunai</b></h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-sm" id="example1">
          <thead class="table-light">
            <tr class="text-center">
              <th class="text-center" width="50px">No.</th>
              <th class="text-center">Penerima</th>
              <th class="text-center">Pengirim</th>
              <th class="text-center">Diupload</th>
              <th class="text-center" width="130px">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($donasi)): ?>
              <tr>
                <td colspan="5" class="text-center py-3">
                  <div class="d-flex flex-column align-items-center">
                    <i class="fas fa-info-circle fa-2x text-info mb-2 text-warning"></i>
                    <span class="font-weight-bold">Data Tidak Tersedia</span>
                  </div>
                </td>
              </tr>
            <?php else: ?>
              <?php
              $no = 1;
              foreach ($donasi as $key => $isi_donasi) : ?>
                <tr>
                  <td class="text-center align-middle"><b><?= $no++; ?></b></td>
                  <td class="align-middle">
                    <b class="d-block"><?= $isi_donasi['nama_bank_tujuan'] ?></b>
                    <span class="d-block">
                      <i class="fas fa-credit-card" style="margin-right: 4px;"></i>
                      <small class="text-nowrap"><?= $isi_donasi['no_rek_tujuan'] ?> (<?= $isi_donasi['nama_rek_tujuan'] ?>)</small>
                    </span>
                  </td>
                  <td class="align-middle">
                    <b class="d-block"><?= $isi_donasi['nama_bank_p'] ?></b>
                    <span class="d-block">
                      <?php
                      $nama_rek_p = $isi_donasi['nama_rek_p'];
                      $panjang_nama = strlen($nama_rek_p);
                      if ($panjang_nama > 2) {
                        $nama_terpotong = substr($nama_rek_p, 0, 1) . str_repeat('*', $panjang_nama - 2) . substr($nama_rek_p, -1);
                      } else {
                        $nama_terpotong = $nama_rek_p;
                      } ?>
                      <i class="fas fa-user" style="margin-right: 4px;"></i><small><?= $nama_terpotong ?></small>
                    </span>
                  </td>
                  <td class="text-center align-middle">
                    <?php
                    $tanggal = new DateTime($isi_donasi['created_at']);
                    $formatter = IntlDateFormatter::create(
                      'id_ID',
                      IntlDateFormatter::LONG,
                      IntlDateFormatter::NONE
                    );
                    $formatted_date = $formatter->format($tanggal);
                    $formatted_time = $tanggal->format('H.i.s');
                    echo $formatted_date . ' ' . '(' . $formatted_time . ' WIB)';
                    ?>
                    <br>
                    <?= $isi_donasi['status'] == 'Belum Tervalidasi'
                      ? '<span class="badge bg-warning">Belum Tervalidasi</span>'
                      : '<span class="badge bg-secondary">Telah Tervalidasi</span>' ?>
                  </td>
                  <td class="text-center align-middle">
                    Rp. <?= number_format($isi_donasi['jumlah'], 0) ?>
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

<div class="container my-4">
  <div class="card border-warning shadow-sm">
    <div class="card-header d-flex align-items-center">
      <i class="fa-regular fa-rectangle-list fa-2x text-warning me-3"></i>
      <h4 class="mb-0"><b>Data Donasi Barang</b></h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-sm" id="example2">
          <thead class="table-light">
            <tr class="text-center">
              <th class="text-center" width="50px">No.</th>
              <th class="text-center">Donatur</th>
              <th class="text-center">Penerima</th>
              <th class="text-center" width="300px">Nama Barang</th>
              <th class="text-center">Diupload</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($donasi_db)): ?>
              <tr>
                <td colspan="5" class="text-center py-3">
                  <div class="d-flex flex-column align-items-center">
                    <i class="fas fa-info-circle fa-2x text-info mb-2 text-warning"></i>
                    <span class="font-weight-bold">Data Tidak Tersedia</span>
                  </div>
                </td>
              </tr>
            <?php else: ?>
              <?php
              $no = 1;
              foreach ($donasi_db as $key => $isi_donasi_db) : ?>
                <tr>
                  <td class="text-center align-middle"><b><?= $no++; ?></b></td>
                  <td class="align-middle">
                    <b class="d-block">
                      <i class="fas fa-user" style="margin-right: 4px;"></i><?= $isi_donasi_db['nama_p'] ?>
                    </b>
                  </td>
                  <td class="align-middle">
                    <b class="d-block">
                      <i class="fa-solid fa-mosque" style="margin-right: 4px;"></i><?= $isi_donasi_db['penerima'] ?>
                    </b>
                  </td>
                  <td class="text-center align-middle">
                    <?= $isi_donasi_db['nama_barang'] ?>
                  </td>
                  <td class="text-center align-middle">
                    <?php
                    $tanggal = new DateTime($isi_donasi_db['created_at']);
                    $formatter = IntlDateFormatter::create(
                      'id_ID',
                      IntlDateFormatter::LONG,
                      IntlDateFormatter::NONE
                    );
                    $formatted_date = $formatter->format($tanggal);
                    $formatted_time = $tanggal->format('H.i.s');
                    echo $formatted_date . ' ' . '(' . $formatted_time . ' WIB)';
                    ?>
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

  .card {
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .card-header {
    /* background-color: #f7f7f7; */
    border-bottom: 1px solid #ddd;
  }

  .info-box {
    display: flex;
    align-items: center;
    padding: 10px;
    border-radius: 10px;
    background-color: #f8f9fa;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  }

  .info-box-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #007bff;
    color: white;
    font-size: 20px;
  }

  .btn-success {
    background-color: #28a745;
    border-color: #28a745;
  }

  .container {
    padding-left: 15px;
    padding-right: 15px;
  }

  .row.g-4 {
    margin-top: 30px;
    margin-bottom: 30px;
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

  #example2_wrapper .dataTables_length {
    /* display: none; */
    margin-bottom: 10px;
  }

  #example2 {
    border-top: 2px solid #dee2e6 !important;
  }

  #example2 thead {
    border-top: 2px solid #dee2e6 !important;
  }

  .card {
    animation: fadeInUp 0.6s ease-out;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  }

  .info-box {
    animation: slideIn 0.5s ease-out;
    transition: all 0.3s ease;
  }

  .info-box:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  }

  .card-header i {
    animation: swing 2s infinite;
  }

  .table {
    animation: fadeIn 0.8s ease-out;
  }

  .table tr {
    animation: slideInRight 0.5s ease-out;
    animation-fill-mode: both;
  }

  .d-flex.flex-column.align-items-center {
    animation: bounceIn 1s ease-out;
  }

  .form-control,
  .form-select {
    transition: all 0.3s ease;
  }

  .form-control:focus,
  .form-select:focus {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .btn {
    transition: all 0.3s ease;
    animation: pulseButton 2s infinite;
  }

  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  }

  @keyframes fadeInUp {
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

  @keyframes swing {

    0%,
    100% {
      transform: rotate(0deg);
    }

    20% {
      transform: rotate(15deg);
    }

    40% {
      transform: rotate(-10deg);
    }

    60% {
      transform: rotate(5deg);
    }

    80% {
      transform: rotate(-5deg);
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

  @keyframes slideInRight {
    from {
      opacity: 0;
      transform: translateX(20px);
    }

    to {
      opacity: 1;
      transform: translateX(0);
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

  @keyframes pulseButton {
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

  .table tbody tr {
    transition: all 0.3s ease;
  }

  .table tbody tr:hover {
    background-color: rgba(255, 193, 7, 0.1);
    transform: scale(1.01);
  }

  .badge {
    animation: fadeIn 0.5s ease-out;
    transition: all 0.3s ease;
  }

  .badge:hover {
    transform: scale(1.1);
  }

  @media (prefers-reduced-motion: reduce) {
    * {
      animation: none !important;
      transition: none !important;
    }
  }
</style>