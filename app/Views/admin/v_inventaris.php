<div class="col-md-12">
  <div class="card card-outline card-info">
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
      <h4 class="mb-3 fw-bold text-center">
        <i class="bi bi-box-arrow-in-right text-info me-2"></i>
        <b>Inventaris Masuk</b>
      </h4>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr class="text-center">
              <th width="50px">No.</th>
              <th>Nama</th>
              <th>Jumlah</th>
              <th>Satuan</th>
              <th>Kondisi</th>
              <th width="200px">Keterangan</th>
              <th width="130px">Harga Satuan</th>
              <th width="110px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $kategoriData_masuk = [];
            foreach ($inventaris_masuk as $isi_inventaris_masuk) {
              $kategoriData_masuk[$isi_inventaris_masuk['kategori']][] = $isi_inventaris_masuk;
            }
            foreach ($kategoriData_masuk as $kategori_masuk => $isi_kategori_masuk) : ?>
              <tr class="bg-light">
                <td colspan="9" class="text-center text-secondary"><strong><?= $kategori_masuk ?></strong></td>
              </tr>
              <?php foreach ($isi_kategori_masuk as $isi_inventaris_masuk) : ?>
                <tr class="text-center">
                  <td class="text-center"><b><?= $no++; ?></b></td>
                  <td><?= $isi_inventaris_masuk['nama_barang'] ?></td>
                  <td><?= $isi_inventaris_masuk['jumlah'] ?></td>
                  <td><?= $isi_inventaris_masuk['satuan'] ?></td>
                  <td><?= $isi_inventaris_masuk['kondisi'] ?></td>
                  <td><?= $isi_inventaris_masuk['keterangan'] ?></td>
                  <td>-</td>
                  <td class="text-center">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $isi_inventaris_masuk['id_inventaris'] ?>">
                      <i class="bi bi-pencil fs-6"></i>
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_inventaris_masuk['id_inventaris'] ?>" data-name="<?= $isi_inventaris_masuk['nama_barang'] . ' dengan Kategori ' . $isi_inventaris_masuk['kategori']  ?>" data-type="inventaris-masuk">
                      <i class="bi bi-trash fs-6"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div id="inventariskeluar" class="page-heading">
  <h3>Inventaris Keluar</h3>
</div>

<div class="col-md-12">
  <div class="card card-outline card-danger">
    <div class="card-header">
      <button type="button" class="btn btn-success d-inline" data-toggle="modal" data-target="#modal-tambah-keluar">
        <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah Data
      </button>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      <?php if (session()->getFlashdata('info_ik')) : ?>
        <script>
          Swal.fire({
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('info_ik'); ?>',
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 4000,
          });
        </script>
      <?php endif; ?>

      <?php if (session()->getFlashdata('errors_ik')): ?>
        <script>
          let errors = `<?php foreach (session()->getFlashdata('errors_ik') as $error): ?><?= $error; ?> <br> <?php endforeach; ?>`;
          Swal.fire({
            title: 'Kesalahan',
            html: errors,
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 4000,
          });
        </script>
      <?php endif; ?>

      <?php if (session()->getFlashdata('info_ik')): ?>
        <div class="alert bg-info" id="flashMessage">
          <?= session()->getFlashdata('info_ik'); ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('errors_ik')): ?>
        <div class="alert alert-danger" id="flashMessage">
          <ul>
            <?php foreach (session()->getFlashdata('errors_ik') as $error): ?>
              <li><?= $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <h4 class="mb-3 fw-bold text-center">
        <i class="bi bi-box-arrow-right text-danger me-2"></i>
        <b>Inventaris Keluar</b>
      </h4>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr class="text-center">
              <th width="50px">No.</th>
              <th>Nama</th>
              <th>Jumlah</th>
              <th>Satuan</th>
              <th>Kondisi</th>
              <th width="200px">Keterangan</th>
              <th width="130px">Harga Satuan</th>
              <th width="110px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $kategoriData_keluar = [];
            foreach ($inventaris_keluar as $isi_inventaris_keluar) {
              $kategoriData_keluar[$isi_inventaris_keluar['kategori']][] = $isi_inventaris_keluar;
            }
            foreach ($kategoriData_keluar as $kategori_keluar => $isi_kategori_keluar) : ?>
              <tr class="bg-light">
                <td colspan="9" class="text-center text-secondary"><strong><?= $kategori_keluar ?></strong></td>
              </tr>
              <?php foreach ($isi_kategori_keluar as $isi_inventaris_keluar) : ?>
                <tr class="text-center">
                  <td class="text-center"><b><?= $no++; ?></b></td>
                  <td><?= $isi_inventaris_keluar['nama'] ?></td>
                  <td><?= $isi_inventaris_keluar['jumlah'] ?></td>
                  <td><?= $isi_inventaris_keluar['satuan'] ?></td>
                  <td><?= $isi_inventaris_keluar['kondisi'] ?></td>
                  <td><?= $isi_inventaris_keluar['keterangan'] ?></td>
                  <td>Rp. <?= number_format($isi_inventaris_keluar['harga'], 0) ?></td>
                  <td class="text-center">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $isi_inventaris_keluar['id_inventaris'] ?>">
                      <i class="bi bi-pencil fs-6"></i>
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_inventaris_keluar['id_inventaris'] ?>" data-name="<?= $isi_inventaris_keluar['nama'] . ' dengan Kategori ' . $isi_inventaris_keluar['kategori']  ?>" data-type="inventaris-keluar">
                      <i class="bi bi-trash fs-6"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
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
      <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
        <h4 class="modal-title">Tambah <?= $judul ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('Inventaris/InsertData') ?>
        <div class="form-group">
          <label for="kategori">Kategori :</label>
          <select name="kategori_select" id="kategori_select" class="form-select" required>
            <option value="" disabled selected>Pilih kategori</option>
            <?php foreach ($kategoriList_masuk as $kategori_masuk) : ?>
              <option value="<?= $kategori_masuk ?>"><?= $kategori_masuk ?> [<?= isset($jumlahKategori_masuk[$kategori_masuk]) ? $jumlahKategori_masuk[$kategori_masuk] : 0 ?>]</option>
            <?php endforeach; ?>
            <option class="font-weight-bold text-danger" value="new">+ Tambahkan Kategori Baru</option>
          </select>
          <input type="text" name="kategori_input" id="kategori_input" class="form-control mt-2 d-none" placeholder="Masukkan kategori baru" maxlength="50" required>
        </div>
        <div class="form-group">
          <label for="nama">Nama Barang : </label>
          <input class="form-control" type="text" name="nama" id="nama" placeholder="Silahkan isikan nama" maxlength="80" required>
        </div>
        <div class="form-group">
          <label for="jumlah">Jumlah Barang : </label>
          <input class="form-control" type="number" name="jumlah" id="jumlah" value="0" placeholder="Silahkan isikan jumlah" class="form-control" min="1" max="2147483647" required>
        </div>
        <div class="form-group">
          <label for="harga">Harga Barang : </label>
          <input class="form-control" type="number" name="harga" id="harga" value="0" placeholder="Silahkan isikan jumlah" class="form-control" min="0" max="2147483647">
        </div>
        <div class="form-group">
          <label for="satuan">Satuan : </label>
          <input class="form-control" type="text" name="satuan" id="satuan" placeholder="Silahkan isikan satuan" maxlength="25" required>
        </div>
        <div class="form-group">
          <label for="kondisi">Kondisi Barang : </label>
          <select name="kondisi" id="kondisi" class="form-select" required>
            <option value="" disabled selected>Pilih kategori</option>
            <option value="Baik">Baik</option>
            <option value="Rusak">Rusak</option>
          </select>
        </div>
        <div class="form-group">
          <label for="keterangan">Keterangan :</label><br>
          <textarea name="keterangan" id="keterangan" placeholder="Silahkan isikan keterangan" class="form-control" maxlength="255" required></textarea>
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

<?php foreach ($inventaris_masuk as $key => $isi_inventaris_masuk) : ?>
  <!-- /.modal-edit -->
  <div class="modal fade" id="modal-edit<?= $isi_inventaris_masuk['id_inventaris'] ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class="modal-title">Ubah <?= $judul ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('Inventaris/EditData/' . $isi_inventaris_masuk['id_inventaris']) ?>
          <div class="form-group">
            <label for="kategori_select">Kategori :</label>
            <select name="kategori_select" id="kategori_select<?= $isi_inventaris_masuk['id_inventaris'] ?>" class="form-select" required>
              <option value="" disabled selected>Pilih kategori</option>
              <?php foreach ($kategoriList_masuk as $kategori_masuk) : ?>
                <option value="<?= $kategori_masuk ?>" <?= ($kategori_masuk === $isi_inventaris_masuk['kategori']) ? 'selected' : '' ?>><?= $kategori_masuk ?> [<?= isset($jumlahKategori_masuk[$kategori_masuk]) ? $jumlahKategori_masuk[$kategori_masuk] : 0 ?>]</option>
              <?php endforeach; ?>
              <option class="font-weight-bold text-danger" value="new">+ Tambahkan Kategori Baru</option>
            </select>
            <input type="text" name="kategori_input" id="kategori_input<?= $isi_inventaris_masuk['id_inventaris'] ?>" class="form-control mt-2 d-none" placeholder="Masukkan kategori baru" maxlength="50">
          </div>
          <div class="form-group">
            <label for="nama">Nama Barang : </label>
            <input class="form-control" type="text" name="nama" id="nama" value="<?= $isi_inventaris_masuk['nama_barang'] ?>" placeholder="Silahkan isikan nama" maxlength="80" required>
          </div>
          <div class="form-group">
            <label for="jumlah">Jumlah Barang : </label>
            <input class="form-control" type="number" name="jumlah" id="jumlah" value="<?= $isi_inventaris_masuk['jumlah'] ?>" placeholder="Silahkan isikan jumlah" class="form-control" min="1" max="2147483647" required>
          </div>

          <div class="form-group">
            <label for="satuan">Satuan : </label>
            <input class="form-control" type="text" name="satuan" id="satuan" value="<?= $isi_inventaris_masuk['satuan'] ?>" placeholder="Silahkan isikan satuan" maxlength="25" required>
          </div>
          <div class="form-group">
            <label for="kondisi">Kondisi Barang : </label>
            <select name="kondisi" id="kondisi" class="form-select" required>
              <option value="" disabled selected>Pilih kategori</option>
              <option value="Baik" <?= ('Baik' === $isi_inventaris_masuk['kondisi']) ? 'selected' : '' ?>>Baik</option>
              <option value="Rusak" <?= ('Rusak' === $isi_inventaris_masuk['kondisi']) ? 'selected' : '' ?>>Rusak</option>
            </select>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan :</label><br>
            <textarea name="keterangan" id="keterangan" placeholder="Silahkan isikan keterangan" class="form-control" maxlength="255" required><?= $isi_inventaris_masuk['keterangan'] ?></textarea>
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

<!-- /.modal-create -->
<div class="modal fade" id="modal-tambah-keluar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
        <h4 class="modal-title">Tambah Inventaris Keluar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('Inventaris/InsertDataKeluar') ?>
        <div class="form-group">
          <label for="nama_select">Nama Barang :</label>
          <select name="nama_select" id="nama_select" class="form-select" required>
            <option value="" disabled selected>Pilih Nama Barang</option>
            <?php if (!empty($nama_barang_masuk)): ?>
              <?php foreach ($nama_barang_masuk as $nama) : ?>
                <option value="<?= $nama['nama'] ?? $nama['nama_barang'] ?>"><?= $nama['nama'] ?? $nama['nama_barang'] ?></option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
        <input type="hidden" name="kategori" id="kategori_keluar">
        <input type="hidden" name="kondisi" id="kondisi_keluar">
        <input type="hidden" name="harga" id="harga_keluar">
        <input type="hidden" name="keterangan" id="keterangan_keluar">
        <div class="form-group">
          <label for="jumlah_keluar">Jumlah Barang : </label>
          <input class="form-control" type="number" name="jumlah_keluar" id="jumlah_keluar" placeholder="Silahkan isikan jumlah" class="form-control" min="1">
          <small class="text-danger"><b>*Stok tersedia: <span id="stok_tersedia">0</span> <span id="satuan_display"></span></b></small>
        </div>
        <input type="hidden" name="satuan" id="satuan_keluar">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<?php foreach ($inventaris_keluar as $key => $isi_inventaris_keluar) : ?>
  <!-- /.modal-edit -->
  <div class="modal fade" id="modal-edit<?= $isi_inventaris_keluar['id_inventaris'] ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
          <h4 class="modal-title">Ubah Inventaris Keluar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('Inventaris/EditDataKeluar/' . $isi_inventaris_keluar['id_inventaris']) ?>
          <div class="form-group">
            <label for="harga">Harga Barang : </label>
            <input class="form-control" type="number" name="harga" id="harga" value="<?= $isi_inventaris_keluar['harga'] ?>" placeholder="Silahkan isikan jumlah" class="form-control" min="0" max="2147483647">
          </div>
          <div class="form-group">
            <label for="kondisi">Kondisi Barang : </label>
            <select name="kondisi" id="kondisi" class="form-select" required>
              <option value="" disabled selected>Pilih kategori</option>
              <option value="Baik" <?= ('Baik' === $isi_inventaris_keluar['kondisi']) ? 'selected' : '' ?>>Baik</option>
              <option value="Rusak" <?= ('Rusak' === $isi_inventaris_keluar['kondisi']) ? 'selected' : '' ?>>Rusak</option>
            </select>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan :</label><br>
            <textarea name="keterangan" id="keterangan" placeholder="Silahkan isikan keterangan" class="form-control" maxlength="255" required><?= $isi_inventaris_keluar['keterangan'] ?></textarea>
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
  <?php foreach ($inventaris_masuk as $key => $isi_inventaris_masuk) : ?>
    document.getElementById('kategori_select<?= $isi_inventaris_masuk['id_inventaris'] ?>').addEventListener('change', function() {
      const inputField = document.getElementById('kategori_input<?= $isi_inventaris_masuk['id_inventaris'] ?>');
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const namaSelect = document.getElementById('nama_select');
    const jumlahInput = document.getElementById('jumlah_keluar');
    const stokTersedia = document.getElementById('stok_tersedia');
    const satuanDisplay = document.getElementById('satuan_display');
    // Hidden fields
    const kategoriKeluar = document.getElementById('kategori_keluar');
    const kondisiKeluar = document.getElementById('kondisi_keluar');
    const hargaKeluar = document.getElementById('harga_keluar');
    const keteranganKeluar = document.getElementById('keterangan_keluar');
    const satuanKeluar = document.getElementById('satuan_keluar');
    const inventarisMasuk = <?= json_encode($inventaris_masuk) ?>;
    namaSelect.addEventListener('change', function() {
      const selectedNama = this.value;
      const barang = inventarisMasuk.find(item => item.nama === selectedNama);
      if (barang) {
        jumlahInput.max = barang.jumlah;
        stokTersedia.textContent = barang.jumlah;
        satuanDisplay.textContent = barang.satuan;
        // Set hidden field values
        kategoriKeluar.value = barang.kategori;
        kondisiKeluar.value = barang.kondisi;
        hargaKeluar.value = barang.harga;
        keteranganKeluar.value = barang.keterangan;
        satuanKeluar.value = barang.satuan;
        // Enable jumlah input
        jumlahInput.disabled = false;
      } else {
        jumlahInput.max = '';
        stokTersedia.textContent = '0';
        satuanDisplay.textContent = '';
        jumlahInput.disabled = true;
        // Reset hidden fields
        kategoriKeluar.value = '';
        kondisiKeluar.value = '';
        hargaKeluar.value = '';
        keteranganKeluar.value = '';
        satuanKeluar.value = '';
      }
    });
  });
</script>