<form action="" method="post">
  <div class="row">
    <div class="col-12 col-lg-6">

      <div class="card mb-3">
        <div class="card-header">
          Lokasi Penempatan Produk
        </div>
        <div class="card-body" id="judul-nama-toko" rel="Toko <?= $nama_toko[0]['nama']; ?>">
          <h5><strong><?= $nama_toko[0]['nama']; ?></strong></h5>

        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header">
          Produk Yang Ditambahkan
        </div>
        <div class="card-body">
          <?php if ($status_gudang == 1) { ?>
            <span class="text-danger">* Jika produk yg dicari tidak ada mungkin produk tersebut sudah terdaftar di Gudang. Coba cek produk yang dicari di list inventory Gudang terlebih dahulu.</span>
          <?php } else { ?>
            <span class="text-danger">* Jika produk yg dicari tidak ada mungkin produk tersebut sudah terdaftar di toko ini. Coba cek produk yang dicari di list inventory Toko <?= $nama_toko[0]['nama']; ?> terlebih dahulu.</span>
          <?php } ?>

          <div class="input-group mb-3 mt-2">
            <input type="text" id="cari-barang" class="form-control bg-light small" placeholder="Cari barang berdasarkan SKU atau nama produk" aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button" id="clear-search-bar">
                <i class="fas fa-times fa-sm"></i>
              </button>
            </div>
          </div>

          <div class="table-responsive mb-3 hide-any" style="height:200px;" id="cari-barang-table">
            <table class="table" id="dataTable" width="100%" cellspacing="0" style="border-left: 2px solid #e3e6f0;border-right: 2px solid #e3e6f0;border-bottom: 2px solid #e3e6f0">
              <thead id="hide-thead">
                <tr>
                  <th>Pencarian Produk</th>
                </tr>
              </thead>
              <tbody id="pencarian-produk">
                <div>Hasil Pencarian:</div>
                <?php $this->load->view('inventory/pencarianProduk', array('model' => $produk_cari)); ?>
              </tbody>
            </table>
          </div>

          <div class="form-group">
            <label for="input_sku">SKU Produk</label>
            <input type="text" class="form-control" id="input_sku" name="input_sku" placeholder="SKU Produk" value="<?= set_select('input_sku'); ?>" readonly>
            <?php echo form_error('input_sku', '<span class="text-danger">', '</span>'); ?>
          </div>

          <div id="tersedia-gudang" class="mt-3" rel="<?= $status_gudang; ?>"></div>
          <input type="hidden" id="input_tersedia_gudang" name="input_tersedia_gudang" value="">
        </div>
      </div>

    </div>

    <div class="col-12 col-lg-6">

      <div class="card mb-3">
        <div class="card-header">
          Informasi Ketersediaan Produk
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="input_tersedia">Input Jumlah</label>
                <input type="text" class="form-control" id="input_tersedia" name="input_tersedia" placeholder="Input Jumlah" value="">
                <?php echo form_error('input_tersedia', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group <?php if ($status_gudang == 1) echo 'hide-any'; ?>">
                <label for="input_minimal">Limit Minimal (Notifikasi)</label>
                <input type="text" class="form-control" id="input_minimal" name="input_minimal" placeholder="Limit Minimal" value="<?php if ($status_gudang == 1) echo 0; ?>">
                <?php echo form_error('input_minimal', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12">
      <span class="custom-modal-footer d-flex flex-row-reverse">
        <a href="<?= base_url('Inventory/index2/'); ?><?= $toko_id; ?>" id="btn-cancel" class="btn btn-warning btn-icon-split btn-lg ml-3">
          <span class="icon text-white-50">
            <i class="fas fa-exclamation-triangle"></i>
          </span>
          <span class="text">Cancel</span>
        </a>
        <button type="submit" id="btn-save-produk" class="btn btn-primary btn-icon-split btn-lg">
          <span class="icon text-white-50">
            <i class="fas fa-save"></i>
          </span>
          <span class="text">Save</span>
        </button>
      </span>
    </div>
  </div>
</form>