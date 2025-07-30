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
      <div class="table-responsive">
        <table class="table table-hover" id="example2">
          <thead>
            <tr class="text-center">
              <th>No.</th>
              <th width="140px">Pengadu</th>
              <th width="30%">Masalah</th>
              <th width="30%">Jawaban</th>
              <th width="110px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($pengaduan as $key => $isi_pengaduan) :
            ?>
              <tr>
                <td class="text-center align-middle"><b><?= $no++; ?></b></td>
                <td class="align-middle">
                  <i class="fas fa-user text-orange" style="margin-right: 8px;"></i><?= $isi_pengaduan['nama_pengadu'] ?><br>
                  <p class="mb-0"><?= $isi_pengaduan['no_hp'] ?></p>
                </td>
                <td class="align-middle">
                  <i class="fas fa-list text-orange" style="margin-right: 8px;"></i><?= $isi_pengaduan['jenis_masalah'] ?>
                  <hr class="m-1">
                  <?= $isi_pengaduan['masalah'] ?>
                  <hr class="m-1">
                  <div class="text-center">
                    <a data-toggle="modal" data-target="#modal-lg-<?= $key ?>">
                      <img src="<?= base_url('uploaded/lampiran_pengaduan/' . $isi_pengaduan['lampiran']) ?>" alt="Gambar Lampiran Pengaduan" title="Klik untuk diperbesar" style="width: 60px; height: 60px;">
                    </a>
                  </div>
                </td>
                <td class="align-middle">
                  <?= $isi_pengaduan['jawaban'] ?? 'Belum dijawab' ?>
                  <?php if (!empty($isi_pengaduan['jawaban'])): ?>
                    <hr class="m-1">
                    <i class="fas fa-user text-orange" style="margin-right: 8px;"></i>
                    <?= $isi_pengaduan['nama_penjawab'] ?? 'Admin' ?>
                  <?php endif; ?>
                </td>
                <td class="text-center align-middle">
                  <?php if ($isi_pengaduan['status'] != '1'): ?>
                    <!-- Tombol Validasi (Jika ≠ 1) -->
                    <button class="btn btn-primary btn-sm" onclick="validasiButton(<?= $isi_pengaduan['id_pengaduan'] ?>)">
                      <i class="bi bi-check2 fs-6"></i>
                    </button>
                  <?php else: ?>
                    <!-- Tombol Selesai (Jika Status = 1) -->
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit<?= $isi_pengaduan['id_pengaduan'] ?>">
                      <i class="fas fa-plus-square fs-6"></i>
                    </button>
                  <?php endif; ?>
                  <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_pengaduan['id_pengaduan'] ?>" data-name="<?= $isi_pengaduan['nama_pengadu'] . ' dibuat pada ' . $isi_pengaduan['created_at'] ?>" data-type="pengaduan">
                    <i class="bi bi-trash fs-6"></i>
                  </button>
                  <br>
                  <?= $isi_pengaduan['status'] == '0' ? '<span class="right badge badge-warning">Belum Terkonfirmasi</span>' : '<span class="right badge badge-success">Terkonfirmasi</span>' ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php foreach ($pengaduan as $key => $isi_pengaduan) : ?>
  <!-- /.modal-detail -->
  <div class="modal fade" id="modal-lg-<?= $key ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header justify-content-center text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class=" modal-title">Lampiran dari "<?= $isi_pengaduan['nama_pengadu'] ?>"</h4>
        </div>
        <div class="modal-body text-center">
          <img src="<?= base_url('uploaded/lampiran_pengaduan/' . $isi_pengaduan['lampiran']) ?>" style="max-width: 100%; height: auto;" width="350px" alt="Gambar Lampiran Pengaduan" title="<?= $isi_pengaduan['lampiran'] ?>">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-warning btn-block" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<?php foreach ($pengaduan as $key => $isi_pengaduan) : ?>
  <!-- /.modal-edit -->
  <div class="modal fade" id="modal-edit<?= $isi_pengaduan['id_pengaduan'] ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class="modal-title">Ubah <?= $judul ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('Pengaduan/JawabPengaduan/' . $isi_pengaduan['id_pengaduan']) ?>
          <div class="form-group">
            <label for="nama_pengadu">Nama Pengadu : </label>
            <input class="form-control" type="text" name="nama_pengadu" id="nama_pengadu" value="<?= $isi_pengaduan['nama_pengadu'] ?>" disabled>
          </div>
          <div class="form-group">
            <label for="masalah">Masalah : </label>
            <input class="form-control" type="text" name="masalah" id="masalah" value="<?= $isi_pengaduan['masalah'] ?>" disabled>
          </div>
          <div class="form-group">
            <label for="jawaban">Jawaban : </label>
            <textarea class="form-control" name="jawaban" id="jawaban" maxlength="255" placeholder="Silahkan isikan jawaban" required><?= $isi_pengaduan['jawaban'] ?></textarea>
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

<script>
  function validasiButton(id_pengaduan) {
    Swal.fire({
      title: 'Apakah data sudah benar?',
      text: "Anda tidak akan bisa mengubahnya setelah konfirmasi!",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#ff0000',
      cancelButtonColor: '#f0ad4e',
      confirmButtonText: 'OK',
      cancelButtonText: 'Tutup',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('Pengaduan/ValidasiPengaduan/') ?>' + id_pengaduan;
      }
    });
  }
</script>