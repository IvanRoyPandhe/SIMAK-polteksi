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
      <?= form_open_multipart('Artikel/EditArtikel') ?>
      <input type="hidden" name="id_artikel" value="<?= $artikel['id_artikel'] ?>">
      <div class="form-group">
        <label for="penulis">Penulis</label>
        <input type="text" id="penulis" class="form-control" name="penulis" value="<?= set_value('penulis', $artikel['penulis']) ?>" placeholder="Masukkan nama penulis" maxlength="50" required>
      </div>
      <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" id="judul" class="form-control" name="judul" value="<?= set_value('judul', $artikel['judul']) ?>" placeholder="Masukkan judul" maxlength="100" required>
      </div>
      <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" id="slug" class="form-control" name="slug" value="<?= set_value('slug', $artikel['slug']) ?>" placeholder="Masukkan slug" maxlength="100" required>
      </div>
      <label for="thumbnail">Thumbnail</label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-image"></i></span>
        </div>
        <div class="custom-file">
          <input class="custom-file-input" type="file" name="thumbnail" accept="image/*">
          <label class="form-control custom-file-label" for="thumbnail">Upload Foto (Kosongkan jika tidak ingin mengubah)</label>
        </div>
      </div>
      <div id="image-preview" style="margin-top: 10px; display: flex; justify-content: center;">
        <img id="preview" src="<?= base_url('uploaded/thumbnail_artikel/' . $artikel['thumbnail']) ?>" alt="Preview Gambar" class="img-fluid" style="max-width: 65px; max-height: 65px;">
      </div>
      <div class="form-group">
        <label for="isi">Isi Konten</label>
        <textarea class="summernote" name="isi"><?= set_value('isi', $artikel['isi']) ?></textarea>
      </div>
      <label for="kategori">Kategori</label>
      <div class="input-group mb-3">
        <select class="form-select" name="kategori" required>
          <option value="" disabled selected>Pilih kategori</option>
          <?php foreach ($kat_artikel as $isi_kat_artikel): ?>
            <option value="<?= $isi_kat_artikel['id_kat_artikel'] ?>" <?= set_select('kategori', $isi_kat_artikel['id_kat_artikel'], $artikel['kat_artikel_id'] == $isi_kat_artikel['id_kat_artikel']); ?>>
              <?= $isi_kat_artikel['nama'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="status">Status</label>
        <select class="form-select" name="status" required>
          <option value="" disabled selected>Pilih status</option>
          <option value="Publish" <?= set_select('status', 'Publish', $artikel['status'] == 'Publish'); ?>>Publikasi</option>
          <option value="Private" <?= set_select('status', 'Private', $artikel['status'] == 'Private'); ?>>Privat</option>
          <option value="Draft" <?= set_select('status', 'Draft', $artikel['status'] == 'Draft'); ?>>Draft</option>
        </select>
      </div>
      <br>
      <div class="d-flex justify-content-between mt-3">
        <a href="<?= base_url('Artikel') ?>" class="btn btn-outline-warning">Kembali</a>
        <button type="submit" class="btn btn-primary">Ubah</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<script>
  document.getElementById('judul').addEventListener('input', function() {
    const judul = this.value;
    const slug = judul
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
    document.getElementById('slug').value = slug;
  });
</script>

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