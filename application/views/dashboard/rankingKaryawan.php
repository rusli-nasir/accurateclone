<div class="row mb-5">
  <div class="col-12 col-lg-7 mx-auto">
    <div class="card">
      <div class="card-header">
        Ranking Karyawan Per-Bulan
      </div>
      <div class="card-body">
        <div class="mb-4 text-center hide-any" id="tampilan-rentang">
        </div>
        <div class="form-group" id="tampilan-kategori">
          <label for="tampilan--bulan">Ranking Berdasarkan :</label>
          <select class="form-control" id="tampilan-kategori--select">
            <option value="">--------Pilih Kategori--------</option>
            <option value="jual">Berdasarkan Penjualan</option>
            <option value="absen">Berdasarkan Absensi</option>
          </select>
          <span class="text-danger hide-any" id="error-kategori">*Pilih kategori ranking dahulu</span>
        </div>
        <div class="form-group hide-any" id="tampilan-tahun">
          <label for="tampilan--tahun">Pada Tahun :</label>
          <select class="form-control" id="tampilan-tahun--select">
            <option value="">--------Pilih Tahun--------</option>
            <?php
            for ($i = $first_year_of_record; $i <= $last_year_of_record; $i++) {
            ?>
              <option value="<?= $i; ?>"><?= $i; ?></option>
            <?php
            }
            ?>
          </select>
          <span class="text-danger hide-any" id="error-tahun">*Pilih tahun dahulu</span>
        </div>
        <div class="form-group hide-any" id="tampilan-bulan">
          <label for="tampilan--bulan">Pada Bulan :</label>
          <select class="form-control" id="tampilan-bulan--select">
            <option value="">--------Pilih Bulan--------</option>
            <?php
            for ($i = 1; $i < 13; $i++) {
              $ref_date = '2019-' . sprintf("%02d", $i) . '-01';
              $bln_str = date('F', strtotime($ref_date));
            ?>
              <option value="<?= $i; ?>"><?= $bln_str; ?></option>
            <?php } ?>
          </select>
          <span class="text-danger hide-any" id="error-bulan">*Pilih bulan dahulu</span>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <button type="button" class="btn btn-primary mr-4" id="btn-custom-reset">
              <span class="text">Reset</span>
            </button>
            <button type="button" class="btn btn-primary" id="btn-custom-range">
              <span class="text">Tampilkan</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="ml-md-3 mb-5 text-gray-800 text-center">
  <h1 id="show-range" class="h5"></h1>
</div>

<div id="ranking-content">

</div>