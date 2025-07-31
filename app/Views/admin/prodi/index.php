<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title mb-0">Data Program Studi</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="<?= base_url('Prodi/create') ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Prodi
                </a>
            </div>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('info') ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead class="table-primary">
                        <tr>
                            <th width="50px">No</th>
                            <th>Kode</th>
                            <th>Nama Program Studi</th>
                            <th>Jenjang</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($prodi as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $p['kode_prodi'] ?></td>
                                <td><?= $p['nama_prodi'] ?></td>
                                <td><?= $p['jenjang'] ?></td>
                                <td>
                                    <a href="<?= base_url('Prodi/edit/' . $p['id_prodi']) ?>" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-btn" 
                                            data-id="<?= $p['id_prodi'] ?>" 
                                            data-name="<?= $p['nama_prodi'] ?>" 
                                            data-type="prodi">
                                        <i class="fas fa-trash"></i>
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