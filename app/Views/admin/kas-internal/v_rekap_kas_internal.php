<?php
if ($kas == null) {
    $pemasukan[] = 0;
    $pengeluaran[] = 0;
} else {
    foreach ($kas as $key => $isi_kas) {
        $pemasukan[] = $isi_kas['dana_masuk'];
        $pengeluaran[] = $isi_kas['dana_keluar'];
    }
}
$total = array_sum($pemasukan) - array_sum($pengeluaran);
?>

<div class="col-md-12">
    <div class="alert alert-dismissible bg-info">
        <h5><i class="fas fa-wallet" style="margin-right: 8px;"></i> <b>Keuangan Internal</b></h5>
        <hr>
        <h6>
            Saldo Pemasukkan: Rp. <?= number_format(array_sum($pemasukan), 0) ?>
            <br>
            Saldo Pengeluaran: Rp. <?= number_format(array_sum($pengeluaran), 0) ?>
        </h6>
        <hr>
        <h5>Saldo Terakhir: <b>Rp. <?= number_format($total, 0) ?></b></h5>
    </div>
</div>
<div class="col-md-12">
    <div class="card card-outline card-info">
        <div class="card-header">
            <button type="button" class="btn btn-danger d-inline" id="deleteAllButton"><i class="bi bi-trash fs-6" style="margin-right: 8px;"></i>Hapus Semua data
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

            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert bg-info" id="flashMessage">
                    <?= session()->getFlashdata('info'); ?>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-hover" id="example1">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Dana Masuk</th>
                            <th>Dana Keluar</th>
                            <th>Kategori</th>
                            <th width="300px">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($kas as $key => $isi_kas) :
                        ?>
                            <tr class="text-center">
                                <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                    <b><?= $no++; ?></b>
                                </td>
                                <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                    <?= $isi_kas['tgl'] ?></td>
                                <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                    <?= $isi_kas['dana_masuk'] == 0 ? '' : 'Rp. ' . number_format($isi_kas['dana_masuk'], 0) ?></td>
                                <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                    <?= $isi_kas['dana_keluar'] == 0 ? '' : 'Rp. ' . number_format($isi_kas['dana_keluar'], 0) ?></td>
                                <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                    <?= $isi_kas['kategori'] ?></td>
                                <td class="<?= $isi_kas['status'] == 'Masuk' ? 'text-success' : 'text-danger' ?>">
                                    <?= $isi_kas['keterangan'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <i class="fas fa-circle text-success"></i> Dana Masuk
            <br>
            <i class="fas fa-circle text-danger"></i> Dana Keluar
        </div>
    </div>
</div>

<script>
    document.getElementById("deleteAllButton").addEventListener("click", function() {
        if (<?= empty($kas) ? 'true' : 'false' ?>) {
            Swal.fire({
                title: 'Tidak ada data!',
                text: 'Data kas internal Kosong',
                icon: 'error',
                confirmButtonText: 'Ok',
                timer: 4000,
            });
        } else {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Semua data kas internal akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#f0ad4e',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Tutup',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('KasInternal/DeleteAll') ?>';
                }
            });
        }
    });
</script>