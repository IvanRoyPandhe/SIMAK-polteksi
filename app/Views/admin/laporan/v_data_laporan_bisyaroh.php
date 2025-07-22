<?php
if (empty($bisyaroh)) {
  $total_sumbangan_transport = 0;
} else {
  $total_sumbangan_transport = [];
  foreach ($bisyaroh as $key => $isi_bisyaroh) {
    $total_sumbangan_transport[] = $isi_bisyaroh['sumbangan_transport'];
  }
}
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

  .signature-section {
    text-align: right;
    margin-top: 0;
    font-family: Times New Roman;
    position: relative;
  }

  .signature-container {
    display: inline-block;
    text-align: center;
    margin-right: 20px;
  }

  .signature-space {
    margin-top: 60px;
  }

  .signature-title {
    margin-bottom: 5px;
    font-weight: bold;
  }

  .text-left {
    text-align: left;
  }

  .text-center {
    text-align: center;
  }
</style>

<?php if (empty($bisyaroh)) : ?>
  <p><b>Tidak ada data bisyaroh pada filter yang dipilih.</b></p>
<?php else : ?>
  <div class="header-container">
    <div class="header-text">
      <p style="font-size: 18px; margin: 0;"><b>
          TANDA TERIMA TRANSPORT
          <br>
          IMAM ROWATIB, KHATIB DAN IMAM JUM'AT, MUADZIN DAN PETUGAS/ MARBOT
          <br>
          MASJID AGUNG <?= $masjid['nama_masjid'] ?> KAJEN KAB. PEKALONGAN
          <br>
          BULAN <?= $bulan . ' ' . $tahun ?>
        </b>
      </p>
    </div>
  </div>
  <hr style="background-color: black; margin: 5;">
  <br>
  <div class="table-responsive">
    <table class="table" border="1" style="font-family: Times New Roman;">
      <thead>
        <tr class="text-center">
          <th width="50px">No.</th>
          <th width="180px">Nama</th>
          <th width="200px">Tugas</th>
          <th width="120px">Sumbangan Transport</th>
          <th width="140px">Tanda Tangan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $no_ttd = 1;
        foreach ($bisyaroh as $key => $isi_bisyaroh) :
          $text_align_class = ($no_ttd % 2 == 0) ? 'text-center' : 'text-left'; ?>
          <tr class="text-center">
            <td><b><?= $no++; ?></b></td>
            <td class="text-left"><?= $isi_bisyaroh['nama'] ?></td>
            <td class="text-left"><?= $isi_bisyaroh['tugas'] ?></td>
            <td class="text-left">Rp. <?= number_format($isi_bisyaroh['sumbangan_transport'], 0) ?></td>
            <td class="<?= $text_align_class ?>"><?= $no_ttd++; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot class="text-center">
        <tr>
          <th colspan="3">Jumlah</th>
          <td class="text-left">Rp. <?= number_format(array_sum($total_sumbangan_transport), 0) ?></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <div style="font-family: Times New Roman;">
    <p class="text-right" style="text-align: right; margin-bottom: 5px;">
      Kajen, <?= date('d M Y') ?> jam <?= date('H:i:s') ?>
      <br>
      Dicetak oleh: <?= $user_name ?>
    </p>
  </div>
  <div class="signature-section">
    <div class="signature-container">
      <p class="signature-title">
        <b>
          Takmir Masjid Agung Al-Muhtaram
          <br>
          Kajen Kabupaten Pekalongan
          <br>
          <?= $jabatan ?>
        </b>
      </p>
      <div class="signature-space"></div>
      <p class="signature-title"><u><?= $nama ?></u></p>
    </div>
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