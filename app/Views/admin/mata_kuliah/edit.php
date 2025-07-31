<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Mata Kuliah</h3>
        </div>
        <form action="/admin/mata-kuliah/update/<?= $mata_kuliah['id_matkul'] ?>" method="post">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Mata Kuliah</label>
                            <input type="text" class="form-control" name="kode_matkul" value="<?= $mata_kuliah['kode_matkul'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Mata Kuliah</label>
                            <input type="text" class="form-control" name="nama_matkul" value="<?= $mata_kuliah['nama_matkul'] ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Program Studi</label>
                            <select class="form-control" name="prodi_id" id="prodi_id" required>
                                <option value="">Pilih Prodi</option>
                                <?php foreach ($prodi as $p): ?>
                                    <option value="<?= $p['id_prodi'] ?>" <?= $mata_kuliah['prodi_id'] == $p['id_prodi'] ? 'selected' : '' ?>>
                                        <?= $p['nama_prodi'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Dosen Pengajar</label>
                            <select class="form-control" name="dosen_id" id="dosen_id" required>
                                <option value="">Pilih Dosen</option>
                                <?php foreach ($dosen as $d): ?>
                                    <option value="<?= $d['id_dosen'] ?>" <?= $mata_kuliah['dosen_id'] == $d['id_dosen'] ? 'selected' : '' ?>>
                                        <?= $d['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis</label>
                            <select class="form-control" name="jenis" required>
                                <option value="Wajib" <?= $mata_kuliah['jenis'] == 'Wajib' ? 'selected' : '' ?>>Wajib</option>
                                <option value="Pilihan" <?= $mata_kuliah['jenis'] == 'Pilihan' ? 'selected' : '' ?>>Pilihan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>SKS</label>
                            <input type="number" class="form-control" name="sks" value="<?= $mata_kuliah['sks'] ?>" min="1" max="6" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Semester</label>
                            <input type="number" class="form-control" name="semester" value="<?= $mata_kuliah['semester'] ?>" min="1" max="8" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/admin/mata-kuliah" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('prodi_id').addEventListener('change', function() {
    const prodiId = this.value;
    const dosenSelect = document.getElementById('dosen_id');
    
    dosenSelect.innerHTML = '<option value="">Loading...</option>';
    
    if (prodiId) {
        fetch('/admin/mata-kuliah/get-dosen-by-prodi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'prodi_id=' + prodiId
        })
        .then(response => response.json())
        .then(data => {
            dosenSelect.innerHTML = '<option value="">Pilih Dosen</option>';
            data.forEach(dosen => {
                dosenSelect.innerHTML += `<option value="${dosen.id_dosen}">${dosen.nama}</option>`;
            });
        });
    } else {
        dosenSelect.innerHTML = '<option value="">Pilih Dosen</option>';
    }
});
</script>