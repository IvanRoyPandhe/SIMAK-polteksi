<?php
if (empty($kas)) {
  $pemasukan = 0;
  $pengeluaran = 0;
} else {
  $pemasukan = [];
  $pengeluaran = [];

  foreach ($kas as $key => $isi_kas) {
    $pemasukan[] = $isi_kas['dana_masuk'];
    $pengeluaran[] = $isi_kas['dana_keluar'];
  }
  $total_kas = array_sum($pemasukan) - array_sum($pengeluaran);
  $total_kas = number_format($total_kas);
}

if ($kasinternal == null) {
  $pemasukankasinternal[] = 0;
  $pengeluarankasinternal[] = 0;
} else {
  foreach ($kasinternal as $key => $isi_kaskasinternal) {
    $pemasukankasinternal[] = $isi_kaskasinternal['dana_masuk'];
    $pengeluarankasinternal[] = $isi_kaskasinternal['dana_keluar'];
  }
}
$total_kasinternal = array_sum($pemasukankasinternal) - array_sum($pengeluarankasinternal);
$total_kasinternal = number_format($total_kasinternal);
$selisih_kas = str_replace(',', '', $total_kasinternal) - str_replace(',', '', $total_kas);
$selisih_kas = number_format($selisih_kas);
?>

<style>
  table {
    width: 100%;
    border: 1px solid black;
    border-collapse: collapse;
  }

  th,
  td {
    padding: 5px;
  }

  .header-container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    font-family: Times New Roman;
  }

  .header-container img {
    margin-right: 20px;
    align-self: center;
  }

  .header-text {
    text-align: center;
  }
</style>

<?php if (empty($kas)) : ?>
  <p><b>Tidak ada data keuangan pada filter yang dipilih.</b></p>
<?php else : ?>
  <div class="header-container">
    <div class="header-text">
      <p style="font-size: 18px; margin: 0;"><b>
          LAPORAN
          <br>
          KOTAK AMAL MASJID AGUNG <?= $masjid['nama_masjid'] ?>
          <br>
          <?php
          $periodText = 'Periode ';
          if (!empty($bulan) && $bulan != 'Semua Bulan') {
            $periodText .= $bulan;
          } else {
            $periodText .= 'Semua Bulan';
          }
          $periodText .= ' ' . $tahun;
          if (!empty($kategori)) {
            $periodText .= ' - Kategori: ' . $kategori;
          }
          if (!empty($status)) {
            $periodText .= ' - Status: ' . $status;
          }
          echo $periodText;
          ?>
        </b></p>
    </div>
  </div>
  <hr style="background-color: black; margin: 5; margin-bottom: 0;">
  <br>
  <div class="table-responsive">
    <table class="table" border="1" id="example3" style="text-align: center; font-family: Times New Roman;">
      <thead>
        <tr class="text-center">
          <th width="50px">No.</th>
          <th width="90px">Tanggal</th>
          <th width="300px">Keterangan</th>
          <th class="text-success" width="130px">Pemasukkan</th>
          <th class="text-danger" width="130px">Pengeluaran</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        foreach ($kas as $key => $isi_kas) :
        ?>
          <tr class="text-center">
            <td><b><?= $no++; ?></b></td>
            <td><?= $isi_kas['tgl'] ?></td>
            <td class="text-left" style="text-align: left;"><?= $isi_kas['keterangan'] ?></td>
            <td class="text-success" style="text-align: left;">
              <?= $isi_kas['dana_masuk'] == 0 ? '' : 'Rp. ' . number_format($isi_kas['dana_masuk'], 0) ?>
            </td>
            <td class="text-danger" style="text-align: left;">
              <?= $isi_kas['dana_keluar'] == 0 ? '' : 'Rp. ' . number_format($isi_kas['dana_keluar'], 0) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot class="text-center">
        <tr>
          <th colspan="3">Jumlah</th>
          <td class="text-success" style="text-align: left;">Rp. <?= number_format(array_sum($pemasukan), 0) ?></td>
          <td class="text-danger" style="text-align: left;">Rp. <?= number_format(array_sum($pengeluaran), 0) ?></td>
        </tr>
        <?php if (!empty($bulan) && !empty($tahun) && empty($kategori) && empty($status)): ?>
          <tr>
            <th colspan="3">Sisa Kas Bulan <?= $bulan . ' ' . $tahun ?></th>
            <td colspan="2">Rp. <?= $total_kas ?></td>
          </tr>
          <tr>
            <th colspan="3">Sisa Kas Bulan Sebelumnya</th>
            <td colspan="2">Rp. <?= $selisih_kas ?></td>
          </tr>
          <tr>
            <th colspan="3">Saldo Akhir Kas</th>
            <td colspan="2">Rp. <?= $total_kasinternal ?></td>
          </tr>
        <?php endif; ?>
      </tfoot>
    </table>
  </div>
  <div style="font-family: Times New Roman;">
    <p style="text-align: right;">
      Kajen, <?= date('d M Y') ?> jam <?= date('H:i:s') ?>
      <br>
      Dicetak oleh: <?= $user_name ?>
    </p>
  </div>
<?php endif; ?>

<style>
  @media print {
    @page {
      margin-top: 0;
      margin-bottom: 0;
    }

    body {
      margin: 1.6cm;
    }

    tfoot {
      display: table-row-group;
    }
  }
</style>