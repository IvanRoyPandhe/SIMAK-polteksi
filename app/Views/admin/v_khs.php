<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manajemen KHS</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Input Nilai
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

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Tahun Akademik</th>
                            <th>Nilai Angka</th>
                            <th>Nilai Huruf</th>
                            <th>Bobot</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($khs as $data) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nim'] ?></td>
                            <td><?= $data['nama_mahasiswa'] ?></td>
                            <td><?= $data['kode_matkul'] ?> - <?= $data['nama_matkul'] ?></td>
                            <td><?= $data['sks'] ?> SKS</td>
                            <td><?= $data['semester_aktif'] ?></td>
                            <td><?= $data['tahun_akademik'] ?></td>
                            <td><?= $data['nilai_angka'] ?></td>
                            <td>
                                <?php
                                $badge_class = 'bg-success';
                                if ($data['nilai_huruf'] == 'E') $badge_class = 'bg-danger';
                                elseif (in_array($data['nilai_huruf'], ['D', 'D+'])) $badge_class = 'bg-warning';
                                elseif (in_array($data['nilai_huruf'], ['C-', 'C', 'C+'])) $badge_class = 'bg-info';
                                ?>
                                <span class="badge <?= $badge_class ?>"><?= $data['nilai_huruf'] ?></span>
                            </td>
                            <td><?= $data['bobot'] ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $data['id_khs'] ?>" data-name="<?= $data['nama_matkul'] ?>" data-type="khs">
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

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Input Nilai KHS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('KHS/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mahasiswa</label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                                <option value="">Pilih Mahasiswa</option>
                                <?php foreach ($mahasiswa as $mhs) : ?>
                                    <option value="<?= $mhs['id_mahasiswa'] ?>"><?= $mhs['nim'] ?> - <?= $mhs['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Semester Aktif</label>
                            <select name="semester_aktif" id="semester_aktif" class="form-control" required>
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" id="tahun_akademik" class="form-control" required placeholder="Contoh: 2024/2025">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah (dari KRS)</label>
                            <select name="matkul_id" id="matkul_id" class="form-control" required>
                                <option value="">Pilih mata kuliah terlebih dahulu</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Nilai Angka (0-100)</label>
                            <input type="number" name="nilai_angka" class="form-control" required min="0" max="100" step="0.01" placeholder="Contoh: 85.5">
                            <small class="text-muted">Nilai huruf dan bobot akan dihitung otomatis</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#mahasiswa_id, #semester_aktif, #tahun_akademik').change(function() {
        var mahasiswa_id = $('#mahasiswa_id').val();
        var semester_aktif = $('#semester_aktif').val();
        var tahun_akademik = $('#tahun_akademik').val();
        
        if (mahasiswa_id && semester_aktif && tahun_akademik) {
            $.ajax({
                url: '<?= base_url('KHS/getKRSByMahasiswa') ?>',
                type: 'POST',
                data: {
                    mahasiswa_id: mahasiswa_id,
                    semester_aktif: semester_aktif,
                    tahun_akademik: tahun_akademik
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    var options = '<option value="">Pilih Mata Kuliah</option>';
                    
                    data.forEach(function(item) {
                        options += '<option value="' + item.matkul_id + '">' + item.kode_matkul + ' - ' + item.nama_matkul + ' (' + item.sks + ' SKS)</option>';
                    });
                    
                    $('#matkul_id').html(options);
                }
            });
        }
    });
});
</script>