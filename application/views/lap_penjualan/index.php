<?php if ($this->session->userdata('role') <= 3) { ?>
  <div class="row mb-5">

    <div class="col-12 col-lg-5">
      <div class="card">
        <div class="card-header">
          Pilih Apa Yang Ditampilkan
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="list-toko">Pilihan Tampilan</label>
            <select class="form-control" id="list-toko">
              <option value="all">Semuanya</option>
              <?php foreach ($toko as $x) { ?>
                <option value="<?= $x['id'] ?>" rel="<?= $x['nama'] ?>"><?= $x['nama'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-7">
      <div class="card">
        <div class="card-header">
          Range Tanggal
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="input_date">Input Range Tanggal</label>
            <div id="input_date">
              <div class="row">
                <div class="col-12 col-lg-6 mb-3">
                  <div class="input-group">
                    <input type="text" id="input_start_date" class="form-control" placeholder="Tanggal Mulai" aria-describedby="basic-addon1" data-toggle="datepicker" readonly="readonly" style="background-color:white">
                    <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                  </div>
                  <span id="error_input_start_date" class="text-danger hide-any"></span>
                </div>
                <div class="col-12 col-lg-6 mb-3">
                  <div class="input-group">
                    <input type="text" id="input_end_date" class="form-control" placeholder="Tanggal Akhir" aria-describedby="basic-addon2" data-toggle="datepicker" readonly="readonly" style="background-color:white">
                    <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon2"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                  </div>
                  <span id="error_input_end_date" class="text-danger hide-any"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-center">
              <button type="button" class="btn btn-primary mr-4" id="btn-custom-range-reset">
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
<?php } ?>

<div class="row">
  <div id="judul-display-toko" class="col-12 text-center text-primary h2">
    <?php if ($this->session->userdata('role') <= 3) { ?>
      Semua Toko
    <?php } else { ?>
      Toko <?= $nama_toko['nama']; ?>
    <?php } ?>
  </div>
</div>

<div class="row">
  <div id="judul-custom-range" class="mt-2 col-12 text-center hide-any">
    <div class="h5 text-primary">Range Tanggal</div>
    <div id="display-range-tgl">2019-10-23 s/d 2019-10-28</div>
  </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mt-4 mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary" id="judul-laporan-penjualan">
      <?php if ($this->session->userdata('role') <= 3) { ?>
        List Laporan Penjualan
      <?php } else { ?>
        List Laporan Penjualan <?= $nama_toko['nama']; ?>
      <?php } ?>
    </h6>
  </div>
  <div class="card-body">
    <div class="container-table100">
      <div class="wrap-table100">
        <div class="table100">
          <table class="custom-table table-invoice" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="white-space: nowrap">Kode Invoice</th>
                <th>Tanggal</th>
                <th>Karyawan Yang<br>Melakukan Order</th>
                <th>Nama Customer</th>
                <th>Toko</th>
                <th>Jenis Bayar</th>
                <th>Total</th>
                <th class="text-center">Status</th>
              </tr>
            </thead>
            <tbody id="data-table-lappenjualan"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="modal-invoice" class="custom-modal hide-any">

  <!-- Modal content -->
  <div class="custom-modal-content bg-gray-200 custom-modal-content-invoice">
    <div class="custom-modal-header mb-4">
      <span class="judul-modal-header" style="width: 100%">Detail Invoice</span>
      <span id="btn-close" class="close"><i class="fas fa-times-circle"></i></span>
    </div>
    <div class="custom-modal-body mb-4">
      <div class="card w-100">
        <div class="card-body" id="view-invoice-details">
        </div>
      </div>
    </div>
    <div class="custom-modal-footer">
      <div class="row">
        <div class="col-12 d-flex flex-row-reverse">
          <button type="button" id="btn-close-foot" class="btn btn-warning btn-icon-split btn-lg disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-times"></i>
            </span>
            <span class="text">Close</span>
          </button>

          <a href="" id="btn-replay-invoice" class="btn btn-primary btn-icon-split btn-lg mr-4 disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-redo"></i>
            </span>
            <span class="text">Resend Nota</span>
          </a>

          <a href="" id="btn-refund" class="btn btn-danger btn-icon-split btn-lg mr-4 disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-archive"></i>
            </span>
            <span class="text">Refund</span>
          </a>
        </div>
      </div>
    </div>
  </div>

</div>