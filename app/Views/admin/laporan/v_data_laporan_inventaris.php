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

<?php if (empty($inventaris_masuk) && empty($inventaris_keluar)) : ?>
  <p><b>Silahkan klik Lihat.</b></p>
<?php else : ?>
  <div class="header-container">
    <div class="header-text">
      <p style="font-size: 18px; margin: 0;"><b>
          LAPORAN INVENTARIS BARANG
          <br>
          MASJID AGUNG <?= $masjid['nama_masjid'] ?> KAJEN KAB. PEKALONGAN
          <br>
          TAHUN <?= date('Y') ?>
        </b>
      </p>
    </div>
  </div>
  <hr style="background-color: black; margin: 5;">
  <br>
  <h4 style="font-family: Times New Roman;"><b>A. Inventaris Masuk</b></h4>
  <div class="table-responsive">
    <table class="table" border="1" style="font-family: Times New Roman;">
      <thead>
        <tr class="text-center">
          <th width="50px">No.</th>
          <th>Nama</th>
          <th width="130px">Harga Satuan</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Kondisi</th>
          <th width="200px">Keterangan</th>
          <th width="140px">Total Harga</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $totalMasuk = 0;
        $kategoriData_masuk = [];
        foreach ($inventaris_masuk as $isi_inventaris_masuk) {
          $kategoriData_masuk[$isi_inventaris_masuk['kategori']][] = $isi_inventaris_masuk;
        }
        foreach ($kategoriData_masuk as $kategori_masuk => $isi_kategori_masuk) : ?>
          <tr>
            <td colspan="8" class="text-center text-secondary"><strong><?= $kategori_masuk ?></strong></td>
          </tr>
          <?php foreach ($isi_kategori_masuk as $isi_inventaris_masuk) :
            $total = $isi_inventaris_masuk['harga'] * $isi_inventaris_masuk['jumlah'];
            $totalMasuk += $total;
          ?>
            <tr class="text-center">
              <td class="text-center"><b><?= $no++; ?></b></td>
              <td class="text-left"><?= $isi_inventaris_masuk['nama'] ?></td>
              <td class="text-left">Rp. <?= number_format($isi_inventaris_masuk['harga'], 0) ?></td>
              <td><?= $isi_inventaris_masuk['jumlah'] ?></td>
              <td><?= $isi_inventaris_masuk['satuan'] ?></td>
              <td><?= $isi_inventaris_masuk['kondisi'] ?></td>
              <td class="text-left"><?= $isi_inventaris_masuk['keterangan'] ?></td>
              <td class="text-left">Rp. <?= number_format($total, 0) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th class="text-center" colspan="7">Total Inventaris Masuk</th>
          <td class="text-left">Rp. <?= number_format($totalMasuk, 0) ?></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <br>
  <h4 style="font-family: Times New Roman;"><b>B. Inventaris Keluar</b></h4>
  <div class="table-responsive">
    <table class="table" border="1" style="font-family: Times New Roman;">
      <thead>
        <tr class="text-center">
          <th width="50px">No.</th>
          <th>Nama</th>
          <th width="130px">Harga Satuan</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Kondisi</th>
          <th width="200px">Keterangan</th>
          <th width="140px">Total Harga</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $totalKeluar = 0;
        $kategoriData_keluar = [];
        foreach ($inventaris_keluar as $isi_inventaris_keluar) {
          $kategoriData_keluar[$isi_inventaris_keluar['kategori']][] = $isi_inventaris_keluar;
        }
        foreach ($kategoriData_keluar as $kategori_keluar => $isi_kategori_keluar) : ?>
          <tr>
            <td colspan="8" class="text-center text-secondary"><strong><?= $kategori_keluar ?></strong></td>
          </tr>
          <?php foreach ($isi_kategori_keluar as $isi_inventaris_keluar) :
            $total = $isi_inventaris_keluar['harga'] * $isi_inventaris_keluar['jumlah'];
            $totalKeluar += $total;
          ?>
            <tr class="text-center">
              <td class="text-center"><b><?= $no++; ?></b></td>
              <td class="text-left"><?= $isi_inventaris_keluar['nama'] ?></td>
              <td class="text-left">Rp. <?= number_format($isi_inventaris_keluar['harga'], 0) ?></td>
              <td><?= $isi_inventaris_keluar['jumlah'] ?></td>
              <td><?= $isi_inventaris_keluar['satuan'] ?></td>
              <td><?= $isi_inventaris_keluar['kondisi'] ?></td>
              <td class="text-left"><?= $isi_inventaris_keluar['keterangan'] ?></td>
              <td class="text-left">Rp. <?= number_format($total, 0) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th class="text-center" colspan="7">Total Inventaris Keluar</th>
          <td class="text-left">Rp. <?= number_format($totalKeluar, 0) ?></td>
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