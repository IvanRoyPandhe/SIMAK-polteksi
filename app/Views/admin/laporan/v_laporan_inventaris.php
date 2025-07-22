<div class="col-md-12">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title"><b><?= $judul ?></b></h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-6 col-sm-2 mb-3">
          <button type="button" class="btn btn-primary w-100" onclick="LihatLaporan()">
            <i class="fas fa-eye" style="margin-right: 8px;"></i>Lihat
          </button>
        </div>
        <div class="col-6 col-sm-2 mb-3">
          <button class="btn btn-success w-100" onclick="CetakLaporan()">
            <i class="fa fa-print" style="margin-right: 8px;"></i>Cetak
          </button>
        </div>
      </div>
      <hr>
      <div class="col-sm-12 text-center" id="printarea">
        <div class="TableInventaris">
          <?php if (empty($dataTableInventaris)): ?>
            <p><b>Pilih data berdasarkan waktu terlebih dahulu.</b></p>
          <?php else: ?>
          <?php endif; ?>
        </div>
      </div>
      <hr>
    </div>
  </div>
</div>

<script>
  function LihatLaporan() {
    $.ajax({
      type: "POST",
      url: "<?= base_url('Laporan/ViewLaporanInventaris') ?>",
      dataType: "JSON",
      success: function(response) {
        if (response.data) {
          $('.TableInventaris').html(response.data);
        }
      }
    });
  }

  function CetakLaporan() {
    let printArea = document.getElementById('printarea');
    let printWindow = window.open('', '_blank');
    printWindow.document.write(printArea.innerHTML);
    printWindow.document.close();
    printWindow.print();
  }
</script>