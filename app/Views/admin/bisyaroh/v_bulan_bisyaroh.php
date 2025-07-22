<div class="col-md-12">
  <div class="card card-outline card-orange">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr class="text-center">
            <th width="50px">No.</th>
            <th>Bulan</th>
            <th width="300px">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($bisyaroh as $key => $isi_bisyaroh) :
          ?>
            <tr class="text-center">
              <td class="align-middle"><b><?= $no++; ?></b></td>
              <td>
                <?= $isi_bisyaroh['nama_bulan'] ?>
              </td>
              <td class="align-middle">
                <a href="<?= base_url('Bisyaroh/detailBisyaroh/' . $isi_bisyaroh['id_bulan_bisyaroh']) ?>" class="btn btn-primary btn-sm">
                  <i class="fas fa-clipboard" style="margin-right: 8px;"></i>Laporan
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>