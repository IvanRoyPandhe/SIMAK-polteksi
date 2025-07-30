<div class="col-md-12">
  <div class="card card-outline card-orange">
    <div class="card-header">
      <button type="button" class="btn btn-success d-inline" onclick="location.href='<?= base_url('Artikel/indexInsertArtikel') ?>'"> <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah Data
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
      <div class="table-responsive">
        <table class="table" id="example2">
          <thead>
            <tr class="text-center">
              <th width="50px">No.</th>
              <th>Judul</th>
              <th width="120px">Kategori</th>
              <th width="180px">Penulis</th>
              <th width="150px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($artikel as $key => $isi_artikel) : ?>
              <tr class="text-center">
                <td><b><?= $no++; ?></b></td>
                <td class="text-left">
                  <h5><b><?= $isi_artikel['judul'] ?></b></h5>
                </td>
                <td><?= $isi_artikel['nama_kategori'] ?></td>
                <td class="text-left">
                  <span class="">
                    <i class="fas fa-edit text-orange" style="margin-right: 4px;"></i><b><?= $isi_artikel['penulis'] ?></b><br>
                    <i class="far fa-calendar-alt text-orange" style="margin-right: 4px;"></i><small><?= $isi_artikel['created_at']; ?></small><br>
                  </span>
                </td>
                <td>
                  <button class="btn btn-primary btn-sm" onclick="location.href='<?= base_url('Artikel/indexEditArtikel/' . $isi_artikel['id_artikel']) ?>'">
                    <i class="bi bi-pencil fs-6"></i>
                  </button>
                  <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_artikel['id_artikel'] ?>" data-name="<?= $isi_artikel['judul'] ?>" data-type="artikel">
                    <i class="bi bi-trash fs-6"></i>
                  </button>
                  <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-detail<?= $isi_artikel['id_artikel'] ?>">
                    <i class="bi bi-eye-fill text-white fs-6"></i>
                  </button>
                  <br>
                  <?= $isi_artikel['status'] == 'Publish' ?
                    '<span class="right badge badge-primary">Publikasi</span>' : ($isi_artikel['status'] == 'Private' ?
                      '<span class="right badge badge-secondary">Privat</span>' :
                      '<span class="right badge badge-warning">Draft</span>') ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php foreach ($artikel as $key => $isi_artikel) : ?>
  <!-- Modal Detail -->
  <div class="modal fade" id="modal-detail<?= $isi_artikel['id_artikel'] ?>">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class="modal-title"><?= $isi_artikel['judul'] ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-4">
            <img src="<?= base_url('uploaded/thumbnail_artikel/' . $isi_artikel['thumbnail']) ?>" alt="Thumbnail <?= $isi_artikel['judul'] ?>" class="img-fluid img-thumbnail" style="width: 300px;">
          </div>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Penulis</th>
                <td><?= $isi_artikel['penulis'] ?></td>
              </tr>
              <tr>
                <th>Kategori</th>
                <td><?= $isi_artikel['nama_kategori'] ?></td>
              </tr>
              <tr>
                <th>Status</th>
                <td><?= $isi_artikel['status'] ?></td>
              </tr>
            </tbody>
          </table>
          <p class="text-center"><b>Isi Artikel</b></p>
          <hr>
          <?= $isi_artikel['isi'] ?>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-warning btn-block" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>