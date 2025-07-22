<div class="col-md-12">
    <div class="card card-outline card-orange">
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
                <table class="table" id="example1">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">No.</th>
                            <th>Nama Bank</th>
                            <th>No. Rekening</th>
                            <th>Nama Rekening</th>
                            <th width="110px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($rekening as $key => $isi_rekening) :
                        ?>
                            <tr class="text-center">
                                <td><b><?= $no++; ?></b></td>
                                <td><?= $isi_rekening['nama_bank'] ?></td>
                                <td><?= $isi_rekening['no_rek'] ?></td>
                                <td><?= $isi_rekening['nama_rek'] ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $isi_rekening['id_rekening'] ?>">
                                        <i class="bi bi-pencil fs-6"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $isi_rekening['id_rekening'] ?>" data-name="<?= $isi_rekening['nama_bank'] . ' - ' . $isi_rekening['nama_rek'] ?>" data-type="rekening">
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
            <div class="modal-header bg-orange">
                <h4 class="modal-title">Tambah <?= $judul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('Donasi/InsertRekening') ?>
                <div class="form-group">
                    <label for="nama_bank">Nama Bank : </label>
                    <input class="form-control" type="text" name="nama_bank" id="nama_bank" maxlength="100" placeholder="Silahkan isikan nama bank" required>
                </div>
                <div class="form-group">
                    <label for="no_rek">No. Rekening : </label>
                    <input class="form-control" type="text" name="no_rek" id="no_rek" maxlength="25" placeholder="Silahkan isikan no. rekening" required>
                </div>
                <div class="form-group">
                    <label for="nama_rek">Nama Rekening : </label>
                    <input class="form-control" type="text" name="nama_rek" id="nama_rek" maxlength="100" placeholder="Silahkan isikan nama rekening" required>
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

<?php foreach ($rekening as $key => $isi_rekening) : ?>
    <!-- /.modal-edit -->
    <div class="modal fade" id="modal-edit<?= $isi_rekening['id_rekening'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-orange">
                    <h4 class="modal-title">Ubah <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open('Donasi/EditRekening/' . $isi_rekening['id_rekening']) ?>
                    <div class="form-group">
                        <label for="nama_bank">Nama Bank : </label>
                        <input class="form-control" type="text" name="nama_bank" id="nama_bank" maxlength="100" value="<?= $isi_rekening['nama_bank'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_rek">No. Rekening : </label>
                        <input class="form-control" type="text" name="no_rek" id="no_rek" maxlength="25" value="<?= $isi_rekening['no_rek'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_rek">Nama Rekening : </label>
                        <input class="form-control" type="text" name="nama_rek" id="nama_rek" maxlength="100" value="<?= $isi_rekening['nama_rek'] ?>" required>
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