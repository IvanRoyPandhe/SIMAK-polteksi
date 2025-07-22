<div class="col-md-12">
  <div class="card card-outline rounded-card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><b><?= $judul ?></b></h4>
    </div>
    <div class="card-body">
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
      <?= form_open_multipart('User/InsertUser') ?>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
        </div>
        <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= set_value('nama'); ?>" maxlength="50" required>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        </div>
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= set_value('email'); ?>" maxlength="100" autocomplete="email" required>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
        </div>
        <input type="password" name="password" class="form-control" placeholder="Password" maxlength="100" autocomplete="new-password" required>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
        </div>
        <input type="password" name="konfirmasi_password" class="form-control" placeholder="Konfirmasi Password" maxlength="100" maxlength="100" autocomplete="new-password" required>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-users"></i></span>
        </div>
        <select class="form-select" name="jabatan" required>
          <option value="" disabled selected>Pilih jabatan</option>
          <optgroup label="Pengurus">
            <option value="Ketua" <?= set_select('jabatan', 'Ketua'); ?>>Ketua</option>
            <option value="Sekretaris" <?= set_select('jabatan', 'Sekretaris'); ?>>Sekretaris</option>
            <option value="Bendahara" <?= set_select('jabatan', 'Bendahara'); ?>>Bendahara</option>
          </optgroup>
          <optgroup label="Bidang">
            <option value="PHBI, Dakwah dan Pengajian Rutin" <?= set_select('jabatan', 'PHBI, Dakwah dan Pengajian Rutin'); ?>>PHBI, Dakwah dan Pengajian Rutin</option>
            <option value="Pendidikan dan Remaja" <?= set_select('jabatan', 'Pendidikan dan Remaja'); ?>>Pendidikan dan Remaja</option>
            <option value="Pemeliharaan, Sarana dan Prasarana" <?= set_select('jabatan', 'Pemeliharaan, Sarana dan Prasarana'); ?>>Pemeliharaan, Sarana dan Prasarana</option>
            <option value="Keamanan dan Ketertiban" <?= set_select('jabatan', 'Keamanan dan Ketertiban'); ?>>Keamanan dan Ketertiban</option>
          </optgroup>
          <optgroup label="Masyarakat">
            <option value="Jemaah" <?= set_select('jabatan', 'Jemaah'); ?>>Jemaah</option>
          </optgroup>
        </select>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
        </div>
        <select class="form-select" name="level_id" required>
          <option value="" disabled selected>Pilih roles</option>
          <?php foreach ($level_user as $key => $isi_level_user) : ?>
            <option value="<?= $isi_level_user['id_level'] ?>" <?= set_select('level_id', $isi_level_user['id_level']); ?>><?= $isi_level_user['nama_level'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-image"></i></span>
        </div>
        <div class="custom-file">
          <input class="custom-file-input" type="file" name="profil" accept="image/*">
          <label class="form-control custom-file-label" for="profil">Upload Profil Gambar (<b>*opsional</b>)</label>
        </div>
      </div>
      <div id="image-preview" style="margin-top: 10px; display: flex; justify-content: center;">
        <img id="preview" src="#" alt="Preview Gambar" class="img-circle img-fluid" style="display: none; width: 65px; height: 65px; object-fit: cover;" />
      </div>
      <div class="d-flex justify-content-between mt-3">
        <a href="<?= base_url('User') ?>" class="btn btn-outline-warning">Kembali</a>
        <button type="submit" class="btn btn-success">Tambah</button>
      </div>
      <?= form_close(); ?>
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
  .rounded-card {
    border-radius: 20px;
  }
</style>