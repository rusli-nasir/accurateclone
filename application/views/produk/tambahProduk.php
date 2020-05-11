<?php
$bkp = $this->session->flashdata('bkp');
?>
<input type="hidden" id="is_error" value="<?= $bkp['is_error']; ?>">
<input type="hidden" id="bkp_sku" value="<?= $bkp['SKU']; ?>">
<input type="hidden" id="bkp_kategori" value="<?= $bkp['kategori_produk_id']; ?>">
<input type="hidden" id="bkp_nama" value="<?= $bkp['nama']; ?>">
<input type="hidden" id="bkp_merk" value="<?= $bkp['merk']; ?>">
<input type="hidden" id="bkp_deskripsi" value="<?= $bkp['deskripsi']; ?>">
<input type="hidden" id="bkp_harga_modal" value="<?= $bkp['harga_modal']; ?>">
<input type="hidden" id="bkp_harga_jual" value="<?= $bkp['harga_jual']; ?>">
<input type="hidden" id="bkp_diskon" value="<?= $bkp['diskon']; ?>">
<input type="hidden" id="bkp_profit" value="<?= $bkp['profit']; ?>">

<form action="<?= base_url('Produk/save') ?>" method="post" enctype="multipart/form-data" id="form-produk">

  <div class="row">

    <div class="col-12 col-lg-8">
      <div class="card shadow mb-4">

        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Informasi Dasar</h6>
        </div>

        <div class="card-body">

          <div class="form-group" id="sku-selector">
            <label for="input_sku">SKU</label>
            <input type="text" class="form-control" id="input_sku" name="input_sku" placeholder="Kode SKU Dari Produk" value="<?= set_select('input_sku'); ?>">
            <?php echo form_error('input_sku', '<span class="text-danger">', '</span>'); ?>
          </div>
          <div class="form-group">
            <label for="input_nama">Nama Produk</label>
            <input type="text" class="form-control" id="input_nama" name="input_nama" placeholder="Nama Produk" value="<?= set_select('input_sku'); ?>">
            <?php echo form_error('input_nama', '<span class="text-danger">', '</span>'); ?>
          </div>
          <div class="form-group">
            <label for="input_merk">Merk Produk</label>
            <input type="text" class="form-control" id="input_merk" name="input_merk" placeholder="Merk Produk" value="<?= set_select('input_sku'); ?>">
          </div>
          <div class="form-group">
            <label for="input_deskripsi">Deskripsi Produk</label>
            <textarea class="form-control" id="input_deskripsi" name="input_deskripsi" rows="5" value="<?= set_select('input_sku'); ?>"></textarea>
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
                <input type="text" class="form-control" id="input_harga_modal" name="input_harga_modal" placeholder="Harga Modal" value="<?= set_select('input_sku'); ?>">
                <?php echo form_error('input_harga_modal', '<span class="text-danger">', '</span>'); ?>
              </div>
              <div class="form-group">
                <label for="input_harga_jual">Harga Jual</label>
                <input type="text" class="form-control" id="input_harga_jual" name="input_harga_jual" placeholder="Harga Jual" value="<?= set_select('input_sku'); ?>">
                <?php echo form_error('input_harga_jual', '<span class="text-danger">', '</span>'); ?>
              </div>

            </div>
            <div class="col-12 col-lg-6">

              <div class="form-group">
                <label for="input_diskon">Diskon</label>
                <input type="text" class="form-control" id="input_diskon" name="input_diskon" placeholder="Diskon" value="<?= set_select('input_diskon'); ?>">
              </div>

              <div class="form-group">
                <label for="input_profit">Profit</label>
                <input type="text" class="form-control" id="input_profit" name="input_profit" placeholder="Profit" readonly="readonly" value="<?= set_select('input_sku'); ?>">
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
            <div id="pesan-upload-sukses" class="hide-any">
              <div class="alert alert-success" role="alert">Upload Berhasil!</div>
            </div>
            <img id="tampil-foto-produk" src="<?= base_url('upload/produk/'); ?>noimage.png">
          </div>
          <label for="btn-upload-produk" class="btn btn-success btn-icon-split btn-sm" style="margin: 0 auto 5px auto;cursor:pointer;">
            <span class="icon text-white-50">
              <i class="fas fa-folder-open"></i>
            </span>
            <span class="text">Pilih Gambar</span>
          </label>
          <input type="file" name="filefoto" id="btn-upload-produk" accept="image/*" >
          <p id="nama-file-upload-fotoproduk" class="hide-any"></p>
        </div>
      </div>
      <div class=" card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Kategori</h6>
        </div>
        <div class="card-body">
          <div class="form-group">
            <?php $cat_val = $this->session->flashdata('cat'); ?>
            <label for="input_kategori">Pilih Kategori Produk</label>
            <select class="form-control" id="input_kategori" name="input_kategori">
              <option value="">----- Pilih Kategori -----</option>
              <?php foreach ($model as $data) { ?>
                <option value="<?= $data->id; ?>"><?= $data->nama; ?></option>
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
        <button type="button" id="btn-save-produk" class="btn btn-primary btn-icon-split btn-lg">
          <span class="icon text-white-50">
            <i class="fas fa-save"></i>
          </span>
          <span class="text">Save</span>
        </button>
      </span>
    </div>
  </div>

</form>