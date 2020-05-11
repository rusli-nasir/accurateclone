<input type="hidden" id="disp_kategori" value="<?= $produk['kategori_produk_id']; ?>">

<form action="<?= base_url('Produk/edit/') . $produk['SKU']; ?>" method="post" enctype="multipart/form-data" id="form-produk">

  <div class="row">

    <div class="col-12 col-lg-8">
      <div class="card shadow mb-4">

        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Informasi Dasar</h6>
        </div>

        <div class="card-body">

          <div class="form-group" id="sku-selector">
            <label for="input_sku">SKU</label>
            <input type="text" class="form-control" id="input_sku" name="input_sku" placeholder="Kode SKU Dari Produk" value="<?= $produk['SKU']; ?>">
            <?php echo form_error('input_sku', '<span class="text-danger">', '</span>'); ?>
          </div>
          <div class="form-group">
            <label for="input_nama">Nama Produk</label>
            <input type="text" class="form-control" id="input_nama" name="input_nama" placeholder="Nama Produk" value="<?= $produk['nama']; ?>">
            <?php echo form_error('input_nama', '<span class="text-danger">', '</span>'); ?>
          </div>
          <div class="form-group">
            <label for="input_merk">Merk Produk</label>
            <input type="text" class="form-control" id="input_merk" name="input_merk" placeholder="Merk Produk" value="<?= $produk['merk']; ?>">
          </div>
          <div class="form-group">
            <label for="input_deskripsi">Deskripsi Produk</label>
            <textarea class="form-control" id="input_deskripsi" name="input_deskripsi" rows="5" value="<?= $produk['deskripsi']; ?>"></textarea>
          </div>

        </div>
      </div>

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Informasi Harga</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-lg-6">

              <div class="form-group">
                <label for="input_harga_modal">Harga Modal</label>
                <input type="text" class="form-control" id="input_harga_modal" name="input_harga_modal" placeholder="Harga Modal" value="<?= $produk['harga_modal']; ?>">
                <?php echo form_error('input_harga_modal', '<span class="text-danger">', '</span>'); ?>
              </div>
              <div class="form-group">
                <label for="input_harga_jual">Harga Jual</label>
                <input type="text" class="form-control" id="input_harga_jual" name="input_harga_jual" placeholder="Harga Jual" value="<?= $produk['harga_jual']; ?>">
                <?php echo form_error('input_harga_jual', '<span class="text-danger">', '</span>'); ?>
              </div>

            </div>
            <div class="col-12 col-lg-6">

              <div class="form-group">
                <label for="input_diskon">Diskon</label>
                <input type="text" class="form-control" id="input_diskon" name="input_diskon" placeholder="Profit" value="<?= $produk['diskon']; ?>">
              </div>

              <div class="form-group">
                <label for="input_profit">Profit</label>
                <input type="text" class="form-control" id="input_profit" name="input_profit" placeholder="Profit" readonly="readonly" value="<?= $produk['profit']; ?>">
                <?php echo form_error('input_profit', '<span class="text-danger">', '</span>'); ?>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="col-12 col-lg-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Foto Produk</h6>
        </div>
        <div class="card-body text-center">
          <div class="foto-produk">
            <?php
            if ($produk['foto'] == "")
              $tempFoto = "noimage.png";
            else
              $tempFoto = $produk['foto'];
            ?>
            <img id="tampil-foto-produk" src="<?= base_url('upload/produk/') . $tempFoto; ?>">
          </div>
          <label for="btn-upload-produk" class="btn btn-success btn-icon-split btn-sm" style="margin: 0 auto 5px auto;cursor:pointer;">
            <span class="icon text-white-50">
              <i class="fas fa-folder-open"></i>
            </span>
            <span class="text">Pilih Gambar</span>
          </label>
          <input type="file" name="filefoto" id="btn-upload-produk">
          <p id="nama-file-upload-fotoproduk" class="hide-any"></p>
        </div>
      </div>
      <div class=" card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Kategori</h6>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="input_kategori">Pilih Kategori Produk</label>
            <select class="form-control" id="input_kategori" name="input_kategori">
              <option value="">----- Pilih Kategori -----</option>
              <?php foreach ($category as $catdata) { ?>
                <option value="<?= $catdata->id; ?>"><?= $catdata->nama; ?></option>
              <?php } ?>
            </select>
            <?php echo form_error('input_kategori', '<span class="text-danger">', '</span>'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <span class="custom-modal-footer d-flex flex-row-reverse">
        <a href="<?= base_url('Produk'); ?>" id="btn-cancel" class="btn btn-warning btn-icon-split btn-lg ml-3">
          <span class="icon text-white-50">
            <i class="fas fa-exclamation-triangle"></i>
          </span>
          <span class="text">Cancel</span>
        </a>
        <a href="<?= base_url('Produk/delete/') . $produk['SKU']; ?>" id="btn-delete-produk" class="btn btn-danger btn-icon-split btn-lg ml-3">
          <span class="icon text-white-50">
            <i class="fas fa-trash"></i>
          </span>
          <span class="text">Delete</span>
        </a>
        <button type="button" id="btn-update-produk" class="btn btn-primary btn-icon-split btn-lg">
          <span class="icon text-white-50">
            <i class="fas fa-save"></i>
          </span>
          <span class="text">Save</span>
        </button>
      </span>
    </div>
  </div>

</form>