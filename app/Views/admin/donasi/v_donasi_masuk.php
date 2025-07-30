<div class="col-md-12">
  <div class="card card-outline card-orange">
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
        <div class="alert alert-info" id="flashMessage">
          <?= session()->getFlashdata('info'); ?>
        </div>
      <?php endif; ?>
      <div class="table-responsive">
        <table class="table table-hover" id="example1">
          <thead>
            <tr class="text-center">
              <th width="50px">No.</th>
              <th class="text-left">Penerima</th>
              <th class="text-left">Pengirim</th>
              <th width="130px">Jumlah</th>
              <th>Bukti</th>
              <th width="110px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($donasi as $key => $isi_donasi) :
            ?>
              <tr>
                <td class="text-center align-middle"><b><?= $no++; ?></b></td>
                <td class="align-middle">
                  <b class="text-center">
                    <?= $isi_donasi['nama_bank_tujuan'] ?>
                  </b>
                  <br>
                  <span>
                    <i class="fas fa-credit-card text-orange" style="margin-right: 4px;"></i><small><?= $isi_donasi['no_rek_tujuan'] ?> (<?= $isi_donasi['nama_rek_tujuan'] ?>)</small>
                  </span>
                </td>
                <td class="align-middle">
                  <b class="text-center"><?= $isi_donasi['nama_bank_p'] ?></b>
                  <br>
                  <span>
                    <i class="fas fa-credit-card text-orange" style="margin-right: 4px;"></i><small><?= $isi_donasi['no_rek_p'] ?> (<?= $isi_donasi['nama_rek_p'] ?>)</small><br>
                    <i class="far fa-calendar text-orange" style="margin-right: 4px;"></i>
                    <small>
                      <?php
                      $tanggal = new DateTime($isi_donasi['created_at']);
                      $formatter = IntlDateFormatter::create(
                        'id_ID',
                        IntlDateFormatter::LONG,
                        IntlDateFormatter::NONE
                      );
                      $formatted_date = $formatter->format($tanggal);
                      $formatted_time = $tanggal->format('H.i.s');
                      echo $formatted_date . ' ' . '(' . $formatted_time . ')';
                      ?>
                    </small>
                  </span>
                </td>
                <td class="text-center align-middle">
                  Rp. <?= number_format($isi_donasi['jumlah'], 0) ?>
                </td>
                <td class="align-middle">
                  <a data-toggle="modal" data-target="#modal-lg-<?= $key ?>">
                    <img src="<?= base_url('uploaded/bukti_transfer/' . $isi_donasi['bukti_transfer']) ?>" alt="Gambar Bukti Donasi" title="Klik untuk diperbesar" style="width: 60px; height: 60px;">
                  </a>
                </td>
                <td class="text-center align-middle">
                  <?php if ($isi_donasi['status'] != 'Telah Tervalidasi'): ?>
                    <button class="btn btn-primary btn-sm" onclick="validasiButton(<?= $isi_donasi['id_donasi'] ?>)">
                      <i class="bi bi-check2 fs-6"></i>
                    </button>
                  <?php endif; ?>
                  <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_donasi['id_donasi'] ?>" data-name="<?= $isi_donasi['nama_rek_p'] . ' dibuat pada ' . $isi_donasi['created_at'] ?>" data-type="donasimasuk">
                    <i class="bi bi-trash fs-6"></i>
                  </button>
                  <br>
                  <?= $isi_donasi['status'] == 'Belum Tervalidasi' ? '<span class="right badge badge-warning">Belum Tervalidasi</span>' : '<span class="right badge badge-secondary">Telah Tervalidasi</span>' ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div id="donasibarang" class="page-heading">
  <h3>Donasi Barang</h3>
</div>
<div class="col-md-12">
  <div class="card card-outline card-orange">
    <div class="card-header">
      <button type="button" class="btn btn-success d-inline" data-toggle="modal" data-target="#modal-tambah">
        <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah Data
      </button>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      <?php if (session()->getFlashdata('info_db')) : ?>
        <script>
          Swal.fire({
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('info_db'); ?>',
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 4000,
          });
        </script>
      <?php endif; ?>

      <?php if (session()->getFlashdata('errors_db')): ?>
        <script>
          let errors = `<?php foreach (session()->getFlashdata('errors_db') as $error): ?><?= $error; ?> <br> <?php endforeach; ?>`;
          Swal.fire({
            title: 'Kesalahan',
            html: errors,
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 4000,
          });
        </script>
      <?php endif; ?>

      <?php if (session()->getFlashdata('info_db')): ?>
        <div class="alert bg-info" id="flashMessage">
          <?= session()->getFlashdata('info_db'); ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('errors_db')): ?>
        <div class="alert alert-danger" id="flashMessage">
          <ul>
            <?php foreach (session()->getFlashdata('errors_db') as $error): ?>
              <li><?= $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <div class="table-responsive">
        <table class="table" id="example2">
          <thead>
            <tr class="text-center">
              <th width="50px">No.</th>
              <th>Donatur</th>
              <th>Penerima</th>
              <th>Nama Barang</th>
              <th>Bukti</th>
              <th width="110px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($donasibarang as $key => $isi_donasibarang) : ?>
              <tr class="text-center">
                <td><b><?= $no++; ?></b></td>
                <td><?= $isi_donasibarang['nama_p'] ?></td>
                <td>
                  <?= $isi_donasibarang['penerima'] ?>
                  <br>
                  <i class="far fa-calendar text-orange" style="margin-right: 4px;"></i>
                  <small>
                    <?php
                    $tanggal = new DateTime($isi_donasibarang['created_at']);
                    $formatter = IntlDateFormatter::create(
                      'id_ID',
                      IntlDateFormatter::LONG,
                      IntlDateFormatter::NONE
                    );
                    $formatted_date = $formatter->format($tanggal);
                    $formatted_time = $tanggal->format('H.i.s');
                    echo $formatted_date . ' ' . '(' . $formatted_time . ')';
                    ?>
                  </small>
                </td>
                <td><?= $isi_donasibarang['nama_barang'] ?></td>
                <td class="align-middle">
                  <a data-toggle="modal" data-target="#db-modal-lg-<?= $key ?>">
                    <img src="<?= base_url('uploaded/bukti_transfer/' . $isi_donasibarang['bukti_transfer']) ?>" alt="Gambar Bukti Donasi" title="Klik untuk diperbesar" style="width: 60px; height: 60px;">
                  </a>
                </td>
                <td>
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $isi_donasibarang['id_donasi'] ?>">
                    <i class="bi bi-pencil fs-6"></i>
                  </button>
                  <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_donasibarang['id_donasi'] ?>" data-name="<?= $isi_donasibarang['nama_p'] . ' dibuat pada ' . $isi_donasibarang['created_at'] ?>" data-type="donasimasuk-barang">
                    <i class="bi bi-trash fs-6"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- /.modal-create Donasi Barang -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #dc2626;">
        <h5 class="modal-title"><?= $judul ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open_multipart('Donasi/InsertDonasiBarang') ?>
      <div class="modal-body">
        <div class="mb-3">
          <label for="nama_p" class="form-label">Donatur :</label>
          <input type="text" class="form-control" id="nama_p" name="nama_p" placeholder="Masukkan nama donatur" maxlength="100" required>
        </div>
        <div class="mb-3">
          <label for="penerima" class="form-label">Penerima :</label>
          <input type="text" class="form-control" id="penerima" name="penerima" placeholder="Masukkan nama donatur" maxlength="100" required>
        </div>
        <div class="mb-3">
          <label for="nama_barang" class="form-label">Nama Barang :</label>
          <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" maxlength="150" required>
        </div>
        <label for="bukti">Bukti</label>
        <div class="input-group mb-3">
          <div class="custom-file">
            <input class="custom-file-input" type="file" name="bukti" accept="image/*" required>
            <label class="form-control custom-file-label" for="bukti">Upload Bukti</label>
          </div>
        </div>
        <div id="image-preview" style="margin-top: 10px; display: flex; justify-content: center;">
          <img id="preview" src="#" alt="Preview Gambar" class="img-fluid" style="display: none; max-width: 65px; max-height: 65px;" />
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<?php foreach ($donasibarang as $key => $isi_donasibarang) : ?>
  <!-- /.modal-edit Donasi Barang -->
  <div class="modal fade" id="modal-edit<?= $isi_donasibarang['id_donasi'] ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class="modal-title">Ubah <?= $judul ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open_multipart('Donasi/EditDonasiBarang') ?>
          <input type="hidden" name="id_donasi" value="<?= $isi_donasibarang['id_donasi'] ?>">
          <div class="mb-3">
            <label for="nama_p" class="form-label">Donatur :</label>
            <input type="text" class="form-control" id="nama_p" name="nama_p" value="<?= $isi_donasibarang['nama_p'] ?>" maxlength="100" required>
          </div>
          <div class="mb-3">
            <label for="penerima" class="form-label">Penerima :</label>
            <input type="text" class="form-control" id="penerima" name="penerima" value="<?= $isi_donasibarang['penerima'] ?>" maxlength="100" required>
          </div>
          <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang :</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $isi_donasibarang['nama_barang'] ?>" maxlength="150" required>
          </div>
          <label for="bukti">Bukti</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-file-image"></i></span>
            </div>
            <div class="custom-file">
              <input class="custom-file-input" type="file" name="bukti" accept="image/*">
              <label class="form-control custom-file-label" for="bukti">Upload Foto (Kosongkan jika tidak ingin mengubah)</label>
            </div>
          </div>
          <div id="image-preview" style="margin-top: 10px; display: flex; justify-content: center;">
            <img id="preview" src="<?= base_url('uploaded/bukti_transfer/' . $isi_donasibarang['bukti_transfer']) ?>" alt="Preview Gambar" class="img-fluid" style="max-width: 65px; max-height: 65px;">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- /.modal-detail Gambar Donasi Tunai -->
<?php foreach ($donasi as $key => $isi_donasi) : ?>
  <div class="modal fade" id="modal-lg-<?= $key ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header justify-content-center text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class=" modal-title">Bukti dari "<?= $isi_donasi['nama_rek_p'] ?>"</h4>
        </div>
        <div class="modal-body text-center">
          <img src="<?= base_url('uploaded/bukti_transfer/' . $isi_donasi['bukti_transfer']) ?>" style="max-width: 100%; height: auto;" width="350px" alt="Gambar Bukti Donasi" title="<?= $isi_donasi['bukti_transfer'] ?>">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-warning btn-block" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- /.modal-detail Gambar Donasi Barang -->
<?php foreach ($donasibarang as $key => $isi_donasibarang) : ?>
  <div class="modal fade" id="db-modal-lg-<?= $key ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header justify-content-center text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class=" modal-title">Bukti dari "<?= $isi_donasibarang['nama_p'] ?>"</h4>
        </div>
        <div class="modal-body text-center">
          <img src="<?= base_url('uploaded/bukti_transfer/' . $isi_donasibarang['bukti_transfer']) ?>" style="max-width: 100%; height: auto;" width="350px" alt="Gambar Bukti Donasi" title="<?= $isi_donasibarang['bukti_transfer'] ?>">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-warning btn-block" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<script>
  function validasiButton(id_donasi) {
    Swal.fire({
      title: 'Apakah data sudah benar?',
      text: "Anda tidak akan bisa mengubahnya setelah validasi!",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#ff0000',
      cancelButtonColor: '#f0ad4e',
      confirmButtonText: 'OK',
      cancelButtonText: 'Tutup',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('Donasi/ValidasiDonasiMasuk/') ?>' + id_donasi;
      }
    });
  }
</script>

<script>
  document.querySelectorAll('.custom-file-input').forEach(function(input) {
    input.addEventListener('change', function(e) {
      var fileInput = e.target;
      var fileName = fileInput.files[0].name;
      var label = fileInput.nextElementSibling;
      label.innerText = fileName;
      if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          var modal = fileInput.closest('.modal');
          var previewImage = modal.querySelector('#preview');
          previewImage.src = e.target.result;
          previewImage.style.display = 'block';
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    });
  });
</script>

<style>
  .custom-file {
    width: 100%;
  }
</style>