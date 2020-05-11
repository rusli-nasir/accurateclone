<div class="row">

  <div class="col-5">
    <div class="card">
      <div class="card-header">
        Tampilkan Inventory
      </div>
      <div class="card-body">
        <select class="form-control" id="list-toko">
          <?php foreach ($model as $x) { ?>
            <option value="<?= $x['id'] ?>" rel="<?= $x['nama'] ?>" <?php if ($x['id'] == $toko_id) echo "selected"; ?>><?= $x['nama'] ?></option>
          <?php } ?>
        </select>

      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="col-12 d-flex justify-content-between align-items-center mb-4 mt-4">
    <h4 class="text-gray-800" id="judul-toko-inventory"><?= $nama_toko[0]['nama']; ?></h4>
    <a href="<?= base_url('Inventory/tambahInventory/'); ?><?= $toko_id; ?>" id="btn-tambah-inventory" class="btn btn-primary btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">Tambah Produk Baru</span>
    </a>
  </div>

  <div class="col-12 col-lg-5">
    <?= $this->session->flashdata('suksesInventory') ?>
  </div>

  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" id="judul-list-inventory">List Inventory <?= $nama_toko[0]['nama']; ?></h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>NO</th>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th>Tersedia</th>
                <th>Limit Minimal</th>
                <th>Lokasi</th>
              </tr>
            </thead>
            <tbody id="view-table-inventory">
              <?php $this->load->view('inventory/viewTable', array('inv' => $inv)); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>