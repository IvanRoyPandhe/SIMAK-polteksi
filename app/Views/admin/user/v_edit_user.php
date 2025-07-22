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
      <?= form_open_multipart('User/EditUser') ?>
      <input type="hidden" name="id_user" value="<?= $users['id_user'] ?>">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
        </div>
        <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= set_value('nama', $users['nama']) ?>" maxlength="50" required>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        </div>
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= set_value('email', $users['email']) ?>" maxlength="100" autocomplete="email" required>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
        </div>
        <input type="password" name="password" class="form-control" placeholder="Password (Kosongkan jika tidak ingin mengubah)" maxlength="100" autocomplete="new-password">
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
        </div>
        <input type="password" name="konfirmasi_password" class="form-control" placeholder="Konfirmasi Password (Kosongkan jika tidak ingin mengubah)" maxlength="100" autocomplete="new-password">
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-users"></i></span>
        </div>
        <select class="form-select" name="jabatan" required>
          <option value="" disabled selected>Pilih jabatan</option>
          <optgroup label="Pengurus">
            <option value="Ketua" <?= set_select('jabatan', 'Ketua', $users['jabatan'] == 'Ketua'); ?>>Ketua</option>
            <option value="Sekretaris" <?= set_select('jabatan', 'Sekretaris', $users['jabatan'] == 'Sekretaris'); ?>>Sekretaris</option>
            <option value="Bendahara" <?= set_select('jabatan', 'Bendahara', $users['jabatan'] == 'Bendahara'); ?>>Bendahara</option>
          </optgroup>
          <optgroup label="Bidang">
            <option value="PHBI, Dakwah dan Pengajian Rutin" <?= set_select('jabatan', 'PHBI, Dakwah dan Pengajian Rutin', $users['jabatan'] == 'PHBI, Dakwah dan Pengajian Rutin'); ?>>PHBI, Dakwah dan Pengajian Rutin</option>
            <option value="Pendidikan dan Remaja" <?= set_select('jabatan', 'Pendidikan dan Remaja', $users['jabatan'] == 'Pendidikan dan Remaja'); ?>>Pendidikan dan Remaja</option>
            <option value="Pemeliharaan, Sarana dan Prasarana" <?= set_select('jabatan', 'Pemeliharaan, Sarana dan Prasarana', $users['jabatan'] == 'Pemeliharaan, Sarana dan Prasarana'); ?>>Pemeliharaan, Sarana dan Prasarana</option>
            <option value="Keamanan dan Ketertiban" <?= set_select('jabatan', 'Keamanan dan Ketertiban', $users['jabatan'] == 'Keamanan dan Ketertiban'); ?>>Keamanan dan Ketertiban</option>
          </optgroup>
          <optgroup label="Masyarakat">
            <option value="Jemaah" <?= set_select('jabatan', 'Jemaah', $users['jabatan'] == 'Jemaah'); ?>>Jemaah</option>
          </optgroup>
        </select>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
        </div>
        <select class="form-select" name="level_id" required>
          <option value="" disabled selected>Pilih roles</option>
          <?php foreach ($level_user as $isi_level_user) : ?>
            <option value="<?= $isi_level_user['id_level'] ?>" <?= (set_value('level_id', $users['level_id']) == $isi_level_user['id_level']) ? 'selected' : '' ?>><?= $isi_level_user['nama_level'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-image"></i></span>
        </div>
        <div class="custom-file">
          <input class="custom-file-input" type="file" name="profil" accept="image/*">
          <label class="form-control custom-file-label" for="profil">Upload Foto (Kosongkan jika tidak ingin mengubah)</label>
        </div>
      </div>
      <div id="image-preview" style="margin-top: 10px; display: flex; justify-content: center;">
        <img id="preview" src="<?= base_url('uploaded/profil_user/' . $users['profil']) ?>" alt="Preview Gambar" class="img-circle img-fluid" style="width: 65px; height: 65px; object-fit: cover;">
      </div>
      <div class="d-flex justify-content-between mt-3">
        <a href="<?= base_url('User') ?>" class="btn btn-outline-warning">Kembali</a>
        <button id="btn-ubah" type="submit" class="btn btn-primary" disabled>Ubah</button>
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
        text: 'Anda yakin ingin menyimpan perubahan? Untuk ubah profil sendiri silahkan ubah di menu My Profile atau Logout terlebih dahulu',
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

<style>
  .rounded-card {
    border-radius: 20px;
  }
</style>