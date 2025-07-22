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
              <label for="jabatan">Jabatan :</label>
              <select class="form-select" name="jabatan" id="jabatan">
                <option value="" disabled selected>Pilih jabatan</option>
                <option value="Bendahara 1">Bendahara 1</option>
                <option value="Bendahara 2">Bendahara 2</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="nama">Nama :</label>
              <input type="text" class="form-control" name="nama" id="nama">
            </div>
          </div>
        </div>
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
          <div class="col-12 col-sm-2 mb-3">
            <button type="reset" class="btn btn-warning w-100">
              <i class="fas fa-sync-alt" style="margin-right: 8px;"></i>Reset
            </button>
          </div>
        </div>
      </form>
      <br>
      <hr>
      <div class="col-sm-12 text-center" id="printarea">
        <div class="TableBisyaroh">
          <?php if (empty($dataTableBisyaroh)): ?>
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
  function saveFormData() {
    const bulan = $('#bulan').val();
    const tahun = $('#tahun').val();
    const jabatan = $('#jabatan').val();
    const nama = $('#nama').val();
    localStorage.setItem('bulan', bulan);
    localStorage.setItem('tahun', tahun);
    localStorage.setItem('jabatan', jabatan);
    localStorage.setItem('nama', nama);
  }

  function loadFormData() {
    const bulan = localStorage.getItem('bulan');
    const tahun = localStorage.getItem('tahun');
    const jabatan = localStorage.getItem('jabatan');
    const nama = localStorage.getItem('nama');
    if (bulan !== null) {
      $('#bulan').val(bulan);
    }
    if (tahun !== null) {
      $('#tahun').val(tahun);
    }
    if (jabatan !== null) {
      $('#jabatan').val(jabatan);
    }
    if (nama !== null) {
      $('#nama').val(nama);
    }
  }
  $(document).ready(function() {
    loadFormData();
  });

  function LihatLaporan() {
    let bulan = $('#bulan').val();
    let tahun = $('#tahun').val();
    let jabatan = $('#jabatan').val();
    let nama = $('#nama').val();
    if (bulan == '') {
      Swal.fire({
        title: 'Informasi',
        text: 'Pilih bulan terlebih dahulu',
        icon: 'info',
        confirmButtonText: 'OK',
        timer: 4000,
      });
    } else if (tahun == '') {
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
        url: "<?= base_url('Laporan/ViewLaporanBisyaroh') ?>",
        data: {
          bulan: bulan,
          tahun: tahun,
          jabatan: jabatan,
          nama: nama,
        },
        dataType: "JSON",
        success: function(response) {
          if (response.data) {
            $('.TableBisyaroh').html(response.data);
          }
        }
      });
    }
  }

  function CetakLaporan() {
    let printArea = document.getElementById('printarea');
    let printWindow = window.open('', '_blank');
    printWindow.document.write(printArea.innerHTML);
    printWindow.document.close();
    printWindow.print();
  }
</script>