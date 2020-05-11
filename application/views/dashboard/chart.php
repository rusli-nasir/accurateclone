<div class="row mb-5">
  <div class="col-12 col-md-8 col-lg-6 d-block mx-auto">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 h5">Opsi Tampilan Chart</h6>
      </div>
      <div class="card-body">

        <div class="mb-4 text-center">
          Data penjualan yang ter-rekam berada pada rentang waktu : <br><strong><?= date('j F Y', strtotime($first_date_of_record)); ?> s/d <?= date('j F Y', strtotime($last_date_of_record)); ?></strong>
        </div>

        <div class="form-group mb-3" id="tampilan-toko">
          <label for="tampilan-mode--select">Toko :</label>
          <select class="form-control" id="tampilan-toko--select">
            <option value="">--------Pilih Toko--------</option>
            <option value="all">Semua Toko</option>
            <?php foreach ($toko as $x) { ?>
              <option value="<?= $x['id']; ?>"><?= $x['nama']; ?></option>
            <?php } ?>
          </select>
          <span class="text-danger hide-any" id="error-toko">*Pilih toko dahulu</span>
        </div>

        <div class="form-group mb-3" id="tampilan-mode">
          <label for="tampilan-mode--select">Mode :</label>
          <select class="form-control" id="tampilan-mode--select">
            <option value="">--------Pilih Mode--------</option>
            <option value="hari">Harian</option>
            <option value="bulan">Bulanan</option>
            <option value="tahun">Tahunan</option>
          </select>
          <span class="text-danger hide-any" id="error-mode">*Pilih mode dahulu</span>
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

        <div class="form-group hide-any" id="tampilan-tahun">
          <label for="tampilan--tahun">Pada Tahun :</label>
          <select class="form-control" id="tampilan-tahun--select">
            <option value="">--------Pilih Tahun--------</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
          </select>
          <span class="text-danger hide-any" id="error-tahun">*Pilih tahun dahulu</span>
        </div>

        <div class="text-center">
          <button type="button" class="btn btn-primary" id="btn-tampilkan">
            <span class="text">Tampilkan</span>
          </button>
        </div>

      </div>
    </div>
  </div>
</div>

<div id="chart-area" class="hide-any">

  <div class="row">
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 h5">Profit</h6>
        </div>
        <div class="card-body">
          <canvas id="cProfit"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 h5">Omset</h6>
        </div>
        <div class="card-body">
          <canvas id="cOmset"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 h5">Jumlah Transaksi</h6>
        </div>
        <div class="card-body">
          <canvas id="cTransaksi"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 h5">Produk Terjual</h6>
        </div>
        <div class="card-body">
          <canvas id="cProduk"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 h5">Detail Pengunjung</h6>
        </div>
        <div class="card-body">
          <canvas id="cPengunjung"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 h5">Operasional</h6>
        </div>
        <div class="card-body">
          <canvas id="cOperasional"></canvas>
        </div>
      </div>
    </div>
  </div>

</div>