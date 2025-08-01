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
                            <th class="text-left">Pengumuman</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($kegiatan as $key => $isi_kegiatan) :
                        ?>
                            <tr>
                                <td class="text-center"><b><?= $no++; ?></b></td>
                                <td>
                                    <b><?= $isi_kegiatan['judul'] ?></b>
                                    <br>
                                    <?php
                                    $dateTime = new DateTime($isi_kegiatan['waktu']);
                                    $formattedTime = $dateTime->format('H:i');
                                    ?>
                                    <span class="text-secondary">
                                        <i class="far fa-calendar-alt text-orange" style="margin-right: 4px;"></i><?= $isi_kegiatan['tgl']; ?>
                                        <br>
                                        <i class=" fas fa-clock text-orange" style="margin-right: 4px;"></i><?= $formattedTime ?> - Selesai
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?= $isi_kegiatan['kategori'] ?><br>
                                    <?= $isi_kegiatan['status'] == 'Public' ? '<span class="right badge badge-primary">Publik</span>' : '<span class="right badge badge-secondary">Privat</span>' ?>
                                </td>
                                <td class="text-center">
                                    <?= substr($isi_kegiatan['keterangan'], 0, 100) . (strlen($isi_kegiatan['keterangan']) > 100 ? '...' : '') ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $isi_kegiatan['id_kegiatan'] ?>">
                                        <i class="bi bi-pencil fs-6"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_kegiatan['id_kegiatan'] ?>" data-name="<?= $isi_kegiatan['judul'] ?>" data-type="kegiatan">
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
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                <h4 class="modal-title">Tambah <?= $judul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('Kegiatan/InsertData') ?>
                <div class="form-group">
                    <label for="judul">Judul : </label>
                    <input class="form-control" type="text" name="judul" id="judul" maxlength="255" placeholder="Silahkan isikan judul" required>
                </div>
                <div class="form-group">
                    <label for="kategori-tambah">Kategori :</label>
                    <select class="form-select" name="kategori" id="kategori-tambah">
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="kegiatan">Kegiatan</option>
                        <option value="pengumuman">Pengumuman</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal : </label>
                    <input class="form-control" type="date" name="tanggal" id="tanggal" required>
                </div>
                <div class="form-group" id="waktu-div-tambah" style="display: none;">
                    <label for="waktu">Waktu : </label>
                    <input class="form-control" type="time" name="waktu" id="waktu">
                </div>
                <div class="form-group" id="tempat-div-tambah" style="display: none;">
                    <label for="tempat">Tempat : </label>
                    <input class="form-control" type="text" name="tempat" id="tempat" maxlength="255" placeholder="Silahkan isikan tempat">
                </div>
                <div class="form-group">
                    <label for="status">Status :</label>
                    <select class="form-select" name="status" id="status">
                        <option value="" disabled selected>Pilih status</option>
                        <option value="Public">Publik</option>
                        <option value="Private">Privat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan : </label>
                    <textarea class="form-control" name="keterangan" id="keterangan" maxlength="400" placeholder="Silahkan isikan keterangan" required></textarea>
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

<?php foreach ($kegiatan as $key => $isi_kegiatan) : ?>
    <!-- /.modal-edit -->
    <div class="modal fade" id="modal-edit<?= $isi_kegiatan['id_kegiatan'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                    <h4 class="modal-title">Ubah <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open('Kegiatan/EditData/' . $isi_kegiatan['id_kegiatan']) ?>
                    <div class="form-group">
                        <label for="judul">Judul : </label>
                        <input class="form-control" type="text" name="judul" id="judul" maxlength="255" value="<?= $isi_kegiatan['judul'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori-edit<?= $isi_kegiatan['id_kegiatan'] ?>">Kategori :</label>
                        <select class="form-select" name="kategori" id="kategori-edit<?= $isi_kegiatan['id_kegiatan'] ?>">
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="kegiatan" <?= ('kegiatan' === $isi_kegiatan['kategori']) ? 'selected' : '' ?>>Kegiatan</option>
                            <option value="pengumuman" <?= ('pengumuman' === $isi_kegiatan['kategori']) ? 'selected' : '' ?>>Pengumuman</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal : </label>
                        <input class="form-control" type="date" name="tanggal" id="tanggal" value="<?= $isi_kegiatan['tgl'] ?>" required>
                    </div>
                    <div class="form-group" id="waktu-div-edit<?= $isi_kegiatan['id_kegiatan'] ?>" style="display: <?= ('kegiatan' === $isi_kegiatan['kategori']) ? 'block' : 'none' ?>;">
                        <label for="waktu">Waktu : </label>
                        <input class="form-control" type="time" name="waktu" id="waktu" value="<?= $isi_kegiatan['waktu'] ?>">
                    </div>
                    <div class="form-group" id="tempat-div-edit<?= $isi_kegiatan['id_kegiatan'] ?>" style="display: <?= ('kegiatan' === $isi_kegiatan['kategori']) ? 'block' : 'none' ?>;">
                        <label for="tempat">Tempat : </label>
                        <input class="form-control" type="text" name="tempat" id="tempat" maxlength="255" value="<?= $isi_kegiatan['tempat'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status :</label>
                        <select class="form-select" name="status" id="status">
                            <option value="" disabled selected>Pilih status</option>
                            <option value="Public" <?= ('Public' === $isi_kegiatan['status']) ? 'selected' : '' ?>>Publik</option>
                            <option value="Private" <?= ('Private' === $isi_kegiatan['status']) ? 'selected' : '' ?>>Privat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan : </label>
                        <textarea class="form-control" name="keterangan" id="keterangan" maxlength="400" required><?= $isi_kegiatan['keterangan'] ?></textarea>
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
    // Create
    document.getElementById('kategori-tambah').addEventListener('change', function() {
        const waktuDivTambah = document.getElementById('waktu-div-tambah');
        const tempatDivTambah = document.getElementById('tempat-div-tambah');
        if (this.value === 'kegiatan') {
            waktuDivTambah.style.display = 'block';
            tempatDivTambah.style.display = 'block';
        } else {
            waktuDivTambah.style.display = 'none';
            tempatDivTambah.style.display = 'none';
        }
    });

    // Edit
    <?php foreach ($kegiatan as $key => $isi_kegiatan): ?>
        const kategoriEdit<?= $isi_kegiatan['id_kegiatan'] ?> = document.getElementById('kategori-edit<?= $isi_kegiatan['id_kegiatan'] ?>');
        const waktuDivEdit<?= $isi_kegiatan['id_kegiatan'] ?> = document.getElementById('waktu-div-edit<?= $isi_kegiatan['id_kegiatan'] ?>');
        const tempatDivEdit<?= $isi_kegiatan['id_kegiatan'] ?> = document.getElementById('tempat-div-edit<?= $isi_kegiatan['id_kegiatan'] ?>');
        kategoriEdit<?= $isi_kegiatan['id_kegiatan'] ?>.addEventListener('change', function() {
            if (this.value === 'kegiatan') {
                waktuDivEdit<?= $isi_kegiatan['id_kegiatan'] ?>.style.display = 'block';
                tempatDivEdit<?= $isi_kegiatan['id_kegiatan'] ?>.style.display = 'block';
            } else {
                waktuDivEdit<?= $isi_kegiatan['id_kegiatan'] ?>.style.display = 'none';
                tempatDivEdit<?= $isi_kegiatan['id_kegiatan'] ?>.style.display = 'none';
            }
        });
    <?php endforeach; ?>
</script>