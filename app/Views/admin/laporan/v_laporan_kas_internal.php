<div class="col-md-12">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title"><b><?= $judul ?></b></h3>
    </div>
    <div class="card-body">
      <form id="filterForm">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="bulan">Bulan :</label>
              <select class="form-select" name="bulan" id="bulan">
                <option value="" disabled selected>Pilih bulan</option>
                <option value="">Tidak memilih bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="tahun">Tahun :</label>
              <select class="form-select" name="tahun" id="tahun">
                <option value="">Pilih tahun</option>
                <?php foreach ($tahunList as $tahun): ?>
                  <option value="<?= $tahun ?>"><?= $tahun ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="kategori">Kategori :</label>
              <select class="form-select" name="kategori" id="kategori">
                <option value="" disabled selected>Pilih kategori</option>
                <option value="">Tidak memilih kategori</option>
                <?php foreach ($kategoriList as $kategori): ?>
                  <option value="<?= $kategori ?>"><?= $kategori ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="status">Status :</label>
              <select class="form-select" name="status" id="status">
                <option value="" disabled selected>Pilih status</option>
                <option value="">Tidak memilih status</option>
                <option value="Masuk">Masuk</option>
                <option value="Keluar">Keluar</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 col-sm-2 mb-3">
            <button type="button" class="btn btn-primary w-100" onclick="LihatLaporan(event)">
              <i class="fas fa-eye" style="margin-right: 8px;"></i>Lihat
            </button>
          </div>
          <div class="col-6 col-sm-2 mb-3">
            <button class="btn btn-success w-100" onclick="CetakLaporan()">
              <i class="fa fa-print" style="margin-right: 8px;"></i>Cetak
            </button>
          </div>
          <div class="col-6 col-sm-2 mb-3">
            <button type="reset" class="btn btn-warning w-100">
              <i class="fas fa-sync-alt" style="margin-right: 8px;"></i>Reset
            </button>
          </div>
          <div class="col-6 col-sm-2 mb-3">
            <button type="button" class="btn btn-secondary w-100" id="toggle-buttons">
              <i class="fas fa-eye-slash" style="margin-right: 8px;"></i>Disable
            </button>
          </div>
        </div>
      </form>
      <div class="row">
        <br>
        <hr>
        <div class="col-sm-12 text-center" id="printarea">
          <div class="TableKas">
            <?php if (empty($dataTableKas)): ?>
              <p><b>Pilih data berdasarkan filter terlebih dahulu.</b></p>
            <?php else: ?>
            <?php endif; ?>
          </div>
        </div>
        <hr>
        <div class="col-sm-12">
          <i class="fas fa-circle text-success"></i> Dana Masuk
          <br>
          <i class="fas fa-circle text-danger"></i> Dana Keluar
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function saveFormData() {
    const formData = {
      bulan: $('#bulan').val(),
      kategori: $('#kategori').val(),
      status: $('#status').val(),
      tahun: $('#tahun').val(),
    };
    localStorage.setItem('formData', JSON.stringify(formData));
  }

  function loadFormData() {
    const savedData = localStorage.getItem('formData');
    if (savedData) {
      const formData = JSON.parse(savedData);
      $('#bulan').val(formData.bulan);
      $('#kategori').val(formData.kategori);
      $('#status').val(formData.status);
      $('#tahun').val(formData.tahun);
    }
  }
  $(document).ready(function() {
    loadFormData();
  });

  function LihatLaporan(event) {
    event.preventDefault();
    saveFormData();
    let bulan = $('#bulan').val();
    let kategori = $('#kategori').val();
    let status = $('#status').val();
    let tahun = $('#tahun').val();
    if (tahun === '') {
      Swal.fire({
        title: 'Informasi',
        text: 'Pilih tahun terlebih dahulu',
        icon: 'info',
        confirmButtonText: 'OK',
        timer: 4000,
      });
    } else {
      $.ajax({
        type: "POST",
        url: "<?= base_url('Laporan/ViewLaporanKas') ?>",
        data: {
          bulan: bulan || null,
          kategori: kategori || null,
          status: status || null,
          tahun: tahun,
        },
        dataType: "JSON",
        success: function(response) {
          if (response.data) {
            $('.TableKas').html(response.data);
            var table = $("#example3").DataTable({
              "paging": false,
              "searching": false,
              "language": {
                "info": ""
              },
              "buttons": ["copy", "csv", "excel"]
            });
            table.buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
            $('#toggle-buttons').off('click').on('click', function() {
              var buttonsContainer = $('#example3_wrapper .dt-buttons');
              if (buttonsContainer.is(':visible')) {
                buttonsContainer.hide();
              } else {
                buttonsContainer.show();
              }
            });
          }
        }
      });
    }
  }

  function CetakLaporan() {
    let printArea = document.getElementById('printarea');
    let printWindow = window.open('', '_blank');
    printWindow.document.write(printArea.innerHTML);
    let images = printWindow.document.images;
    let loadedImages = 0;
    let totalImages = images.length;
    if (totalImages === 0) {
      printWindow.print();
      printWindow.document.close();
    } else {
      for (let i = 0; i < totalImages; i++) {
        images[i].onload = function() {
          loadedImages++;
          if (loadedImages === totalImages) {
            printWindow.print();
            printWindow.document.close();
          }
        };
      }
    }
  }
</script>