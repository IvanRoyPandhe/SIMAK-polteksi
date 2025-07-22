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
            <label for="nama_masjid">Nama Masjid : </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-mosque"></i></span>
                </div>
                <input class="form-control" type="text" name="nama_masjid" id="nama_masjid" value="<?= $setting['nama_masjid'] ?>">
            </div>
            <label for="alamat_masjid">Alamat Masjid : </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                </div>
                <input class="form-control" type="text" name="alamat_masjid" id="alamat_masjid" value="<?= $setting['alamat_masjid'] ?>">
            </div>
            <label>Kabupaten/ Kota Masjid : </label>
            <div class="form-group">
                <select class="form-select select2" name="id_lokasi">
                    <?php foreach ($lokasi as $key => $isi_lokasi) : ?>
                        <option value="<?= $isi_lokasi['id'] ?>" <?= $isi_lokasi['id'] == $setting['id_lokasi'] ? 'selected' : '' ?>><?= $isi_lokasi['lokasi'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <label for="keterangan">Keterangan Masjid : </label>
            <div class="form-group">
                <textarea class="summernote" name="keterangan"><?= set_value('keterangan', $setting['keterangan']) ?></textarea>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>