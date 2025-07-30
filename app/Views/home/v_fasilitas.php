<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold" style="color: #dc2626;">Fasilitas <?= $web['nama_kampus'] ?></h2>
                <p class="lead text-muted">Fasilitas modern dan lengkap untuk mendukung proses pembelajaran</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php if (!empty($web['fasilitas'])): ?>
                <?= $web['fasilitas'] ?>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <h5>Informasi Fasilitas Belum Tersedia</h5>
                    <p class="mb-0">Silakan hubungi admin untuk menambahkan informasi fasilitas kampus.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light border-0">
                <div class="card-body p-5 text-center">
                    <h3 class="mb-4">Fasilitas Terbaik untuk Pendidikan Berkualitas</h3>
                    <p class="lead mb-4">Semua fasilitas dirancang untuk mendukung proses pembelajaran yang optimal</p>
                    <a href="<?= base_url('Home/Program') ?>" class="btn btn-lg" style="background: linear-gradient(135deg, #dc2626, #ef4444); border: none; color: white;">Lihat Program Studi</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>