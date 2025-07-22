<?php
if ($kas == null) {
  $pengeluaran[] = 0;
} else {
  foreach ($kas as $key => $isi_kas) {
    $pengeluaran[] = $isi_kas['dana_keluar'];
  }
}
?>

<div class="col-md-12">
  <div class="alert bg-light-danger alert-dismissible">
    <h5><i class="far fa-money-bill-alt" style="margin-right: 8px;"></i><b>Total <?= $subjudul ?></b></h5>
    <hr>
    <h5>Saldo: <b>Rp. <?= number_format(array_sum($pengeluaran), 0) ?></b></h5>
  </div>
</div>
<div class="col-md-12">
  <div class="card card-outline card-danger">
    <div class="card-header">
      <button type="button" class="btn btn-success d-inline" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah Data
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
            title: 'Kesalahan!',
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
        <table class="table" id="example1">
          <thead>
            <tr class="text-center">
              <th width="50px">No.</th>
              <th width="80px">Tanggal</th>
              <th width="130px">Jumlah</th>
              <th width="150px">Kategori</th>
              <th width="300px">Keterangan</th>
              <th width="110px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($kas as $key => $isi_kas) : ?>
              <tr class="text-center">
                <td><b><?= $no++; ?></b></td>
                <td><?= $isi_kas['tgl'] ?></td>
                <td>Rp. <?= number_format($isi_kas['dana_keluar'], 0) ?></td>
                <td><?= $isi_kas['kategori'] ?></td>
                <td><?= $isi_kas['keterangan'] ?></td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $isi_kas['id_keuangan'] ?>">
                    <i class="bi bi-pencil fs-6"></i>
                  </button>
                  <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_kas['id_keuangan'] ?>" data-name="<?= $isi_kas['keterangan'] ?>" data-type="kasinternal-keluar">
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

<!-- /.modal-create -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light-danger">
        <h4 class="modal-title">Dana Keluar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('KasInternal/InsertDanaKeluar') ?>
        <div class="form-group">
          <label for="kategori">Kategori :</label>
          <select name="kategori_select" id="kategori_select" class="form-select" required>
            <option value="" disabled selected>Pilih kategori</option>
            <?php foreach ($kategoriList as $kategori) : ?>
              <option value="<?= $kategori ?>"><?= $kategori ?> [<?= isset($jumlahKategori[$kategori]) ? $jumlahKategori[$kategori] : 0 ?>]</option>
            <?php endforeach; ?>
            <option class="font-weight-bold text-danger" value="new">+ Tambahkan Kategori Baru</option>
          </select>
          <input type="text" name="kategori_input" id="kategori_input" class="form-control mt-2 d-none" placeholder="Masukkan kategori baru" maxlength="50" required>
        </div>
        <div class="form-group">
          <label for="tanggal">Tanggal :</label>
          <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="dana_keluar">Jumlah :</label>
          <input type="number" name="dana_keluar" id="dana_keluar" value="0" placeholder="Silahkan isikan jumlah dana masuk" class="form-control" min="1" max="2147483647" required>
        </div>
        <div class="form-group">
          <label for="keterangan">Keterangan :</label><br>
          <textarea name="keterangan" id="keterangan" placeholder="Silahkan isikan keterangan" class="form-control" maxlength="255" required></textarea>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>

<?php foreach ($kas as $key => $isi_kas) : ?>
  <!-- /.modal-edit -->
  <div class="modal fade" id="modal-edit<?= $isi_kas['id_keuangan'] ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-light-danger">
          <h4 class="modal-title">Ubah Dana Keluar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('KasInternal/EditDanaKeluar/' . $isi_kas['id_keuangan']) ?>
          <div class="form-group">
            <label for="kategori_select">Kategori :</label>
            <select name="kategori_select" id="kategori_select<?= $isi_kas['id_keuangan'] ?>" class="form-select" required>
              <option value="" disabled selected>Pilih kategori</option>
              <?php foreach ($kategoriList as $kategori) : ?>
                <option value="<?= $kategori ?>" <?= ($kategori === $isi_kas['kategori']) ? 'selected' : '' ?>><?= $kategori ?> [<?= isset($jumlahKategori[$kategori]) ? $jumlahKategori[$kategori] : 0 ?>]</option>
              <?php endforeach; ?>
              <option class="font-weight-bold text-danger" value="new">+ Tambahkan Kategori Baru</option>
            </select>
            <input type="text" name="kategori_input" id="kategori_input<?= $isi_kas['id_keuangan'] ?>" class="form-control mt-2 d-none" placeholder="Masukkan kategori baru" maxlength="50">
          </div>
          <div class="form-group">
            <label for="tanggal">Tanggal :</label>
            <input type="date" name="tanggal" id="tanggal" value="<?= $isi_kas['tgl'] ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="dana_keluar">Jumlah :</label>
            <input type="number" name="dana_keluar" id="dana_keluar" value="<?= $isi_kas['dana_keluar'] ?>" placeholder="Silahkan isikan jumlah dana keluar" class="form-control" min="1" max="2147483647" required>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan :</label><br>
            <textarea name="keterangan" id="keterangan" placeholder="Silahkan isikan keterangan" class="form-control" maxlength="255" required><?= $isi_kas['keterangan'] ?></textarea>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Ubah</button>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<script>
  // Create
  document.getElementById('kategori_select').addEventListener('change', function() {
    const inputField = document.getElementById('kategori_input');
    const kategoriSelectValue = this.value;
    if (kategoriSelectValue === 'new') {
      inputField.classList.remove('d-none');
      inputField.required = true;
    } else {
      inputField.classList.add('d-none');
      inputField.required = false;
      inputField.value = '';
    }
  });
  // Edit
  <?php foreach ($kas as $key => $isi_kas) : ?>
    document.getElementById('kategori_select<?= $isi_kas['id_keuangan'] ?>').addEventListener('change', function() {
      const inputField = document.getElementById('kategori_input<?= $isi_kas['id_keuangan'] ?>');
      if (this.value === 'new') {
        inputField.classList.remove('d-none');
        inputField.required = true;
      } else {
        inputField.classList.add('d-none');
        inputField.required = false;
        inputField.value = this.value;
      }
    });
  <?php endforeach; ?>
</script>