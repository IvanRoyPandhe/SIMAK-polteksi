<div class="col-md-12">
  <div class="card card-outline card-orange">
    <div class="card-header">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-tambah">
        <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah Data
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

      <?php
      $tahunArray = array_unique(array_column($bisyaroh, 'tahun'));
      foreach ($tahunArray as $tahun) : ?>
        <hr>
        <h3 class="text-center mt-4">Data Tahun <?= $tahun ?></h3>
        <?php
        $ada_status_kosong = array_filter($bisyaroh, function ($data) use ($tahun) {
          return $data['tahun'] == $tahun && $data['status'] == '0';
        });
        if ($ada_status_kosong) : ?>
          <?= form_open('Bisyaroh/ValidasiBisyaroh') ?>
          <input hidden type="text" name="bulan_id" id="bulan_id" value="<?= $bulan['id_bulan_bisyaroh'] ?>">
          <input hidden type="text" name="tahun_konfirmasi" value="<?= $tahun ?>">
          <button class="btn btn-primary konfirmasi-btn" data-tahun="<?= $tahun ?>">
            <i class="bi bi-check2 fs-6" style="margin-right: 8px;"></i> Konfirmasi
          </button>
          <?= form_close() ?>
        <?php endif; ?>
        <br>
        <div class="table-responsive">
          <table class="table" id="bisyaroh">
            <thead>
              <tr class="text-center">
                <th width="50px">No.</th>
                <th>Tahun</th>
                <th>Nama</th>
                <th>Tugas</th>
                <th>Sumbangan Transport</th>
                <th width="110px">Action</th>
              </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($bisyaroh as $key => $isi_bisyaroh) :
              if ($isi_bisyaroh['tahun'] == $tahun) : ?>
                <tbody>
                  <tr class="text-center">
                    <td class="align-middle"><b><?= $no++; ?></b></td>
                    <td><?= $isi_bisyaroh['tahun'] ?></td>
                    <td><?= $isi_bisyaroh['nama'] ?></td>
                    <td><?= $isi_bisyaroh['tugas'] ?></td>
                    <td>Rp.
                      <?= number_format($isi_bisyaroh['sumbangan_transport'], 0) ?>
                    </td>
                    <td class="align-middle">
                      <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $bulan['id_bulan_bisyaroh'] . '/' . $isi_bisyaroh['id_bisyaroh'] ?>" data-name="<?= $isi_bisyaroh['nama'] ?>" data-type="bisyaroh">
                        <i class="bi bi-trash fs-6"></i>
                      </button>
                      <br>
                      <?= $isi_bisyaroh['status'] == '0' ? '<span class="right badge badge-warning">Belum Masuk Kas</span>' : '<span class="right badge badge-secondary">Sudak Masuk</span>' ?>
                    </td>
                  </tr>
                </tbody>
            <?php
              endif;
            endforeach; ?>
            <tfoot>
              <tr class="text-center">
                <th colspan="4">Jumlah Semua</th>
                <td>Rp. <?= number_format($totalPerTahun[$tahun], 0) ?></td>
              </tr>
              <tr class="text-center">
                <th colspan="4">Jumlah Belum Terkonfirmasi</th>
                <td>Rp. <?= number_format($totalPerTahunKonfirmasi[$tahun], 0) ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <br>
      <?php endforeach; ?>
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
        <?= form_open('Bisyaroh/InsertData') ?>
        <input hidden type="text" name="bulan_id" id="bulan_id" value="<?= $bulan['id_bulan_bisyaroh'] ?>" required>
        <div class="form-group">
          <label for="tahun">Tahun Bisyaroh : </label>
          <input class="form-control" type="text" name="tahun" id="tahun" placeholder="Silahkan isikan tahun" maxlength="4" required>
        </div>
        <div class="form-group">
          <label for="nama">Nama : </label>
          <input class="form-control" type="text" name="nama" id="nama" placeholder="Silahkan isikan nama" maxlength="50" required>
        </div>
        <div class="form-group">
          <label for="tugas">Tugas : </label>
          <input class="form-control" type="text" name="tugas" id="tugas" placeholder="Silahkan isikan tugas" maxlength="100" required>
        </div>
        <div class="form-group">
          <label for="sumbangan_transport">Sumbangan Transport : </label>
          <input class="form-control" type="text" name="sumbangan_transport" id="sumbangan_transport" value="0" placeholder="Silahkan isikan jumlah sumbangan transport" class="form-control" min="0" max="2147483647" required>
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

<script>
  document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('konfirmasi-btn')) {
      e.preventDefault();
      const tahun = e.target.getAttribute('data-tahun');
      Swal.fire({
        title: `Apakah data untuk tahun ${tahun} sudah benar?`,
        text: "Anda akan mengonfirmasi data ini dan memasukkannya ke dalam kas keluar tanpa menambah data baru.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff0000',
        cancelButtonColor: '#f0ad4e',
        confirmButtonText: 'OK',
        cancelButtonText: 'Tutup',
      }).then((result) => {
        if (result.isConfirmed) {
          e.target.closest('form').submit();
        }
      });
    }
  });
</script>