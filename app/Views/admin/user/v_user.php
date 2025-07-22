<div class="col-md-12">
  <section class="content">
    <div class="card card-outline card-orange">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><b>Daftar <?= $judul ?></b></h4>
        <button type="button" class="btn btn-success btn-tambah-kelompok ml-auto" onclick="location.href='<?= base_url('User/indexInsertUser') ?>'">
          <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah Data
        </button>
      </div>
      <div class="card-header pb-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center w-100">
          <div class="card-tools w-100">
            <?= form_open('User', ['class' => 'form-inline w-100', 'id' => 'filterForm', 'method' => 'get']) ?>
            <div class="form-row w-100">
              <div class="col-12 col-md-2 mb-2">
                <select name="level" id="levelSelect" class="custom-select w-100 form-control">
                  <option value="" <?= $level == '' ? 'selected' : '' ?>>Semua</option>
                  <option value="takmir" <?= $level == 'takmir' ? 'selected' : '' ?>>Takmir Masjid</option>
                  <option value="masyarakat" <?= $level == 'masyarakat' ? 'selected' : '' ?>>Masyarakat</option>
                </select>
              </div>
              <div class="col-12 col-md-3 mb-2">
                <input class="form-control w-100" type="search" name="search" placeholder="Cari nama atau email..." aria-label="Search" id="searchInput" value="<?= $search ?>">
              </div>
              <div class="col-12 col-md-2 mb-2">
                <button class="btn btn-primary w-100" type="submit">
                  <i class="fas fa-search" style="margin-right: 8px;"></i>Cari
                </button>
              </div>
            </div>
            <?= form_close() ?>
          </div>
        </div>
      </div>
      <div class="card-body pb-0">
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
          <div class="alert bg-info" id="flashMessage">
            <?= session()->getFlashdata('info'); ?>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')) : ?>
          <script>
            Swal.fire({
              title: 'Gagal!',
              text: '<?= session()->getFlashdata('errors'); ?>',
              icon: 'error',
              confirmButtonText: 'OK',
              timer: 4000,
            });
          </script>
        <?php endif; ?>
        <br>
        <div class="row">
          <?php foreach ($users as $key => $isi_user) : ?>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card d-flex flex-fill border border-3 shadow">
                <div class="card-header text-muted border-bottom-0 pt-2 pb-3">
                  <b><?= $isi_user['jabatan'] . ' - ' . $isi_user['nama_level'] ?></b>
                </div>
                <div class="card-body pt-0 pb-3">
                  <div class="row">
                    <div class="col-3">
                      <img src="<?= base_url('uploaded/profil_user/' . $isi_user['profil']) ?>" alt="user-avatar" class="img-circle img-fluid" style="width: 50px; height: 50px;">
                    </div>
                    <div class="col-9 d-flex flex-column justify-content-center">
                      <h2 class="lead mb-1"><b><?= $isi_user['nama'] ?></b></h2>
                      <div class="d-flex align-items-center text-muted small">
                        <span class="me-2"><i class="fas fa-lg fa-at"></i></span>
                        <span><?= $isi_user['email'] ?></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer pt-2 pb-2">
                  <div class="text-right">
                    <?php if (session()->get('user_id') !== $isi_user['id_user']) : ?>
                      <button class="btn btn-sm bg-danger delete-btn" data-id="<?= $isi_user['id_user'] ?>" data-name="<?= $isi_user['email'] ?>" data-type="user">
                        <i class="bi bi-trash fs-6"></i>
                      </button>
                    <?php endif; ?>
                    <button type="button" onclick="location.href='<?= base_url('User/indexEditUser/' . $isi_user['id_user']) ?>'" class="btn btn-sm btn-primary">
                      <i class="bi bi-pencil fs-6" style="margin-right: 8px;"></i>Ubah User
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-between">
        <div>Total User: <?= $totalUsers ?></div>
        <div class="ml-auto">
          <?= $pager->links('user', 'pagination') ?>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  document.getElementById('levelSelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
  });
</script>

<script>
  document.getElementById('searchInput').addEventListener('input', function() {
    if (this.value === '') {
      document.getElementById('filterForm').submit();
    }
  });
</script>

<style>
  @media (max-width: 768px) {
    .card-header {
      flex-direction: column;
      align-items: stretch;
    }

    .btn-tambah-kelompok {
      width: 100%;
      margin-top: 10px;
    }

    .btn:not(.btn-tambah-kelompok) {
      width: auto;
    }
  }
</style>