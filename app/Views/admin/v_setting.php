<div class="col-md-12">
    <div class="card card-outline rounded-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><b><?= $judul ?></b></h4>
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
            <?= form_open('Admin/EditSetting') ?>
            <label for="nama_kampus">Nama Kampus : </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                </div>
                <input class="form-control" type="text" name="nama_kampus" id="nama_kampus" value="<?= $setting['nama_kampus'] ?? '' ?>">
            </div>
            <label for="alamat_kampus">Alamat Kampus : </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                </div>
                <input class="form-control" type="text" name="alamat_kampus" id="alamat_kampus" value="<?= $setting['alamat_kampus'] ?? '' ?>">
            </div>
            <label>Kabupaten/ Kota Kampus : </label>
            <div class="form-group">
                <select class="form-select select2" name="id_lokasi">
                    <?php foreach ($lokasi as $key => $isi_lokasi) : ?>
                        <option value="<?= $isi_lokasi['id'] ?>" <?= $isi_lokasi['id'] == ($setting['id_lokasi'] ?? '1418') ? 'selected' : '' ?>><?= $isi_lokasi['lokasi'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <label for="keterangan">Keterangan Kampus : </label>
            <div class="form-group">
                <textarea class="summernote" name="keterangan"><?= set_value('keterangan', $setting['keterangan'] ?? '') ?></textarea>
            </div>
            <label for="fasilitas">Fasilitas Kampus : </label>
            <div class="form-group">
                <textarea class="summernote" name="fasilitas"><?= set_value('fasilitas', $setting['fasilitas'] ?? '') ?></textarea>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>