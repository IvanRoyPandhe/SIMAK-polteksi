<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Import Data Mahasiswa</h3>
                <div class="card-tools">
                    <a href="<?= base_url('Mahasiswa') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Upload File</h3>
                            </div>
                            <div class="card-body">
                                <?= form_open_multipart('Mahasiswa/ProcessImport') ?>
                                <div class="form-group">
                                    <label>File Import (CSV/Excel)</label>
                                    <input type="file" name="file_import" class="form-control" accept=".csv,.xlsx,.xls" required>
                                    <small class="text-muted">Format yang didukung: CSV, Excel (.xlsx, .xls)</small>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Import Data
                                </button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Template & Panduan</h3>
                            </div>
                            <div class="card-body">
                                <p><strong>Format Template CSV:</strong></p>
                                <ul>
                                    <li>NIM (wajib)</li>
                                    <li>Nama (wajib)</li>
                                    <li>Email (wajib, format: @student.kampus.ac.id)</li>
                                    <li>Prodi ID (opsional, default: 1)</li>
                                    <li>Tahun Angkatan (opsional, default: tahun sekarang)</li>
                                    <li>Semester (opsional, default: 1)</li>
                                </ul>
                                
                                <a href="<?= base_url('Mahasiswa/DownloadTemplate') ?>" class="btn btn-success">
                                    <i class="fas fa-download"></i> Download Template CSV
                                </a>
                                
                                <div class="mt-3">
                                    <p><strong>Catatan Penting:</strong></p>
                                    <ul class="text-sm">
                                        <li>Setiap mahasiswa akan otomatis dibuatkan akun user</li>
                                        <li>Password default: <code>123456</code></li>
                                        <li>Level user: Mahasiswa (4)</li>
                                        <li>NIM dan email harus unik</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>