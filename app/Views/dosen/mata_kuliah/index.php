<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title mb-0">Mata Kuliah yang Diampu</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th width="50px">No</th>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Prodi</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($mata_kuliah)): ?>
                            <?php $no = 1; foreach ($mata_kuliah as $mk): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $mk['kode_matkul'] ?></td>
                                    <td><?= $mk['nama_matkul'] ?></td>
                                    <td><?= $mk['sks'] ?></td>
                                    <td><?= $mk['semester'] ?></td>
                                    <td><?= $mk['nama_prodi'] ?? '-' ?></td>
                                    <td>
                                        <a href="<?= base_url('dosen/mata-kuliah/nilai/' . $mk['id_matkul']) ?>" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-edit"></i> Input Nilai
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada mata kuliah yang diampu</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>