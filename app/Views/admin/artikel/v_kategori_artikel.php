<div class="col-md-12">
  <div class="card card-outline card-orange">
    <div class="card-header">
      <button type="button" class="btn btn-success d-inline" data-toggle="modal" data-target="#modal-tambah"> <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah Data
      </button>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
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

      <?php if (session()->getFlashdata('errors_relation')) : ?>
        <script>
          Swal.fire({
            title: 'Gagal!',
            text: '<?= session()->getFlashdata('errors_relation'); ?>',
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
      <table class="table" id="example1">
        <thead>
          <tr class="text-center">
            <th width="50px">No.</th>
            <th>Nama Kategori Artikel</th>
            <th width="150px">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($kat_artikel as $key => $isi_kat_artikel) : ?>
            <tr class="text-center">
              <td><b><?= $no++; ?></b></td>
              <td><?= $isi_kat_artikel['nama'] ?></td>
              <td>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $isi_kat_artikel['id_kat_artikel'] ?>">
                  <i class="bi bi-pencil fs-6"></i>
                </button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_kat_artikel['id_kat_artikel'] ?>" data-name="<?= $isi_kat_artikel['nama'] ?>" data-type="kategori-artikel">
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

<!-- /.modal-create -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
        <h4 class="modal-title">Tambah <?= $judul ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('Artikel/InsertKategori') ?>
        <div class="form-group">
          <label for="nama">Nama: </label>
          <input class="form-control" type="text" name="nama" id="nama" maxlength="100" placeholder="Silahkan isikan nama" required>
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

<?php foreach ($kat_artikel as $key => $isi_kat_artikel) : ?>
  <!-- /.modal-edit -->
  <div class="modal fade" id="modal-edit<?= $isi_kat_artikel['id_kat_artikel'] ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class="modal-title">Ubah <?= $judul ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('Artikel/EditKategori/' . $isi_kat_artikel['id_kat_artikel']) ?>
          <div class="form-group">
            <label for="nama">Nama: </label>
            <input class="form-control" type="text" name="nama" id="nama" maxlength="100" value="<?= $isi_kat_artikel['nama'] ?>" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Ubah</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>