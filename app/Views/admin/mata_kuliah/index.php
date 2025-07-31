<div class="col-12">
    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Mata Kuliah</h3>
                            <div class="card-tools">
                                <a href="/admin/mata-kuliah/create" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Mata Kuliah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                            <?php endif; ?>
                            
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>Prodi</th>
                                        <th>SKS</th>
                                        <th>Semester</th>
                                        <th>Dosen Pengajar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($mata_kuliah)): ?>
                                        <?php $no = 1; foreach ($mata_kuliah as $mk): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($mk['kode_matkul']) ?></td>
                                            <td><?= esc($mk['nama_matkul']) ?></td>
                                            <td><?= esc($mk['nama_prodi']) ?></td>
                                            <td><?= esc($mk['sks']) ?></td>
                                            <td><?= esc($mk['semester']) ?></td>
                                            <td><?= !empty($mk['nama_dosen']) ? esc($mk['nama_dosen']) : '<span class="text-danger">Belum Ditentukan</span>' ?></td>
                                            <td>
                                                <a href="/admin/mata-kuliah/edit/<?= $mk['id_matkul'] ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="/admin/mata-kuliah/delete/<?= $mk['id_matkul'] ?>" class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data mata kuliah</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
        </div>
    </div>
</div>