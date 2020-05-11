<form action="" method="post">
  <div class="row">
    <div class="col-12 col-lg-6">

      <div class="card mb-3">
        <div class="card-header">
          Lokasi Penempatan Produk
        </div>
        <div class="card-body">
          <h5><strong><?= $inside[0]['nama_toko']; ?></strong></h5>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header">
          Produk Yang Ditambahkan
        </div>
        <div class="card-body">

          <div class="form-group">
            <label for="input_merk">SKU Produk</label>
            <input type="text" class="form-control" id="input_sku" name="input_sku" placeholder="SKU Produk" value="<?= $inside[0]['sku']; ?>" readonly>
            <?php echo form_error('input_sku', '<span class="text-danger">', '</span>'); ?>
          </div>

          <div id="tersedia-gudang" class="mt-3" rel="<?= $status_gudang; ?>">
            <?php if ($status_gudang == 0) { ?>
              <div class="mb-2">Jumlah Produk Ini Yang Tersedia Di Gudang :</div>
              <div class="text-primary"><strong><?= $jml_tersedia; ?></strong></div>
            <?php } ?>
          </div>
          <input type="hidden" id="input_tersedia_gudang" name="input_tersedia_gudang" value="<?= $jml_tersedia; ?>">
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
                <label for="input_tersedia">Jumlah Tersedia</label>
                <input type="hidden" id="input_tersedia_bfr" name="input_tersedia_bfr" value="<?= $inside[0]['tersedia']; ?>">
                <input type="text" class="form-control" id="input_tersedia" name="input_tersedia" placeholder="Jumlah Tersedia" value="<?= $inside[0]['tersedia']; ?>">
                <?php echo form_error('input_tersedia', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group <?php if ($status_gudang == 1) echo 'hide-any'; ?>">
                <label for="input_minimal">Limit Minimal (Notifikasi)</label>
                <input type="text" class="form-control" id="input_minimal" name="input_minimal" placeholder="Limit Minimal" value="<?= $inside[0]['minimal']; ?>">
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
        <a href="<?= base_url('Inventory/index2/'); ?><?= $inside[0]['toko_id']; ?>" id="btn-cancel" class="btn btn-warning btn-icon-split btn-lg ml-3">
          <span class="icon text-white-50">
            <i class="fas fa-exclamation-triangle"></i>
          </span>
          <span class="text">Cancel</span>
        </a>
        <div id="btn-delete-inventory">
          <a href="<?= base_url('Inventory/delete/'); ?><?= $inside[0]['id']; ?>/<?= $inside[0]['toko_id']; ?>" rel="<?= $inside[0]['id']; ?>/<?= $inside[0]['toko_id']; ?>" class="btn btn-danger btn-icon-split btn-lg ml-3">
            <span class="icon text-white-50">
              <i class="fas fa-trash"></i>
            </span>
            <span class="text">Delete</span>
          </a>
        </div>
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