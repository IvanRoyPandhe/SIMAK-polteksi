<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">My Profile - <?= $mahasiswa['nama'] ?></h4>
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit-profile">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Foto Profil -->
                <div class="col-md-3 text-center">
                    <img src="<?= base_url('uploaded/mahasiswa/' . ($mahasiswa['foto'] ?? 'default.jpg')) ?>" 
                         class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    <h5><?= $mahasiswa['nama'] ?></h5>
                    <p class="text-muted"><?= $mahasiswa['nim'] ?></p>
                    <span class="badge bg-<?= $mahasiswa['status_akademik'] == 'Aktif' ? 'success' : 'warning' ?> mb-2">
                        <?= $mahasiswa['status_akademik'] ?>
                    </span>
                </div>

                <!-- Data Pribadi -->
                <div class="col-md-4">
                    <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Data Pribadi</h6>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%">Tempat Lahir</td>
                            <td>: <?= $mahasiswa['tempat_lahir'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>: <?= $mahasiswa['tanggal_lahir'] ? date('d M Y', strtotime($mahasiswa['tanggal_lahir'])) : '-' ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>: <?= $mahasiswa['jenis_kelamin'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>: <?= $mahasiswa['agama'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>No. HP</td>
                            <td>: <?= $mahasiswa['no_hp'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: <?= $mahasiswa['email'] ?></td>
                        </tr>
                    </table>
                    
                    <h6 class="text-success mb-3 mt-4"><i class="fas fa-home me-2"></i>Data Orang Tua</h6>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%">Nama Ayah</td>
                            <td>: <?= $mahasiswa['nama_ayah'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan Ayah</td>
                            <td>: <?= $mahasiswa['pekerjaan_ayah'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>Nama Ibu</td>
                            <td>: <?= $mahasiswa['nama_ibu'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan Ibu</td>
                            <td>: <?= $mahasiswa['pekerjaan_ibu'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>No. HP Ortu</td>
                            <td>: <?= $mahasiswa['no_hp_ortu'] ?? '-' ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Data Akademik -->
                <div class="col-md-5">
                    <h6 class="text-info mb-3"><i class="fas fa-graduation-cap me-2"></i>Data Akademik</h6>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%">Program Studi</td>
                            <td>: <?= $mahasiswa['nama_prodi'] ?></td>
                        </tr>
                        <tr>
                            <td>Tahun Angkatan</td>
                            <td>: <?= $mahasiswa['tahun_angkatan'] ?></td>
                        </tr>
                        <tr>
                            <td>Semester Aktif</td>
                            <td>: <?= $mahasiswa['semester_aktif'] ?? 1 ?></td>
                        </tr>
                        <tr>
                            <td>Dosen PA</td>
                            <td>: <?= $mahasiswa['nama_dosen_pa'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td>IPK</td>
                            <td>: <span class="badge bg-<?= $mahasiswa['ipk'] >= 3.5 ? 'success' : ($mahasiswa['ipk'] >= 3.0 ? 'warning' : 'danger') ?>"><?= number_format($mahasiswa['ipk'] ?? 0, 2) ?></span></td>
                        </tr>
                        <tr>
                            <td>SKS Lulus</td>
                            <td>: <?= $mahasiswa['sks_lulus'] ?? 0 ?> SKS</td>
                        </tr>
                        <tr>
                            <td>Status Akademik</td>
                            <td>: <span class="badge bg-<?= $mahasiswa['status_akademik'] == 'Aktif' ? 'success' : 'warning' ?>"><?= $mahasiswa['status_akademik'] ?></span></td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <h6 class="text-warning mb-3"><i class="fas fa-map-marker-alt me-2"></i>Alamat</h6>
                        <p class="text-muted"><?= $mahasiswa['alamat'] ?? 'Alamat belum diisi' ?></p>
                    </div>

                    <div class="mt-4">
                        <h6 class="text-secondary mb-3"><i class="fas fa-chart-bar me-2"></i>Progress Akademik</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-success" style="width: <?= ($mahasiswa['sks_lulus'] / 144) * 100 ?>%"></div>
                        </div>
                        <small class="text-muted"><?= $mahasiswa['sks_lulus'] ?? 0 ?> / 144 SKS (<?= number_format(($mahasiswa['sks_lulus'] / 144) * 100, 1) ?>%)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="modal-edit-profile" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Edit My Profile</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('Dashboard/UpdateProfile') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Data Pribadi</h6>
                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="<?= $mahasiswa['tempat_lahir'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?= $mahasiswa['tanggal_lahir'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="Laki-laki" <?= $mahasiswa['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $mahasiswa['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <select name="agama" class="form-control">
                                <option value="Islam" <?= $mahasiswa['agama'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                <option value="Kristen" <?= $mahasiswa['agama'] == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                <option value="Katolik" <?= $mahasiswa['agama'] == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                <option value="Hindu" <?= $mahasiswa['agama'] == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                <option value="Buddha" <?= $mahasiswa['agama'] == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="no_hp" class="form-control" value="<?= $mahasiswa['no_hp'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"><?= $mahasiswa['alamat'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">Data Orang Tua</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" value="<?= $mahasiswa['nama_ayah'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control" value="<?= $mahasiswa['pekerjaan_ayah'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" value="<?= $mahasiswa['nama_ibu'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control" value="<?= $mahasiswa['pekerjaan_ibu'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. HP Orang Tua</label>
                            <input type="text" name="no_hp_ortu" class="form-control" value="<?= $mahasiswa['no_hp_ortu'] ?>">
                        </div>
                        
                        <h6 class="text-info mb-3">Foto Profil</h6>
                        <div class="mb-3">
                            <label class="form-label">Upload Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>