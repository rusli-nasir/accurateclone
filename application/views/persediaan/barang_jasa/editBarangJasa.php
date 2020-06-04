<input type="hidden" id="val-tipe-barang" value="<?= $data_barang['tipe_barang'] ?>">
<input type="hidden" id="val-saldo-awal-tanggal" value="<?= $data_barang['saldo_awal_tanggal'] ?>">
<!-- <?php print_r($data_barang); ?> -->
<div class="row">

  <div class="col-12">

    <h4 class="mb-3">Edit Barang / Jasa</h4>

    <div class="card">
      <div class="card-body">

        <form action="<?= base_url('Persediaan/BarangJasa/editBarangJasa/') . $data_barang['id_barang'] ?>" id="form-tambah-barang-jasa" method="post">

          <div class="form-group">
            <p>Tipe Barang<span style="color: red">*</span></p>
            <div class="d-flex">
              <div class="form-check mr-5">
                <input class="form-check-input" type="radio" name="tipe_barang" id="tipe_barang1" value="Persediaan">
                <label class="form-check-label" for="tipe_barang1">
                  Persediaan
                </label>
              </div>
              <div class="form-check mr-5">
                <input class="form-check-input" type="radio" name="tipe_barang" id="tipe_barang2" value="NonPersediaan">
                <label class="form-check-label" for="tipe_barang2">
                  Non Persediaan
                </label>
              </div>
              <div class="form-check mr-5">
                <input class="form-check-input" type="radio" name="tipe_barang" id="tipe_barang3" value="Servis">
                <label class="form-check-label" for="tipe_barang3">
                  Servis
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="kode_barang">Kode Barang<span style="color: red">*</span></label>
            <input type="text" value="<?= $data_barang['kode_barang'] ?>" class="form-control" id="kode_barang" name="kode_barang" style="width:30%" maxlength="10">
            <span class="text-danger hide-any" id="error-kode-kosong">*Kode Barang tidak boleh kosong</span>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan<span style="color: red">*</span></label>
            <input type="text" value="<?= $data_barang['keterangan'] ?>" class="form-control" id="keterangan" name="keterangan" style="width:60%" maxlength="50">
            <span class="text-danger hide-any" id="error-keterangan-kosong">*Keterangan tidak boleh kosong</span>
          </div>

          <hr class="mb-3 mt-3">

          <div class="row mb-3">

            <div class="col-7">
              <strong class="d-block mb-3">Informasi Tambahan</strong>

              <div class="form-group">
                <label for="kategori_barang">Kategori Barang</label>
                <select class="form-control" id="kategori_barang" name="kategori_barang" style="width:50%">
                  <?php
                  foreach ($kategori_barang as $cat) {
                  ?>
                    <option value="<?= $cat['id'] ?>" <?php if ($cat['id'] == $data_barang['id_kategori_barang']) echo 'selected="selected"'; ?>><?= $cat['nama_kategori'] ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="gudang_default">Gudang Default</label>
                <select class="form-control" id="gudang_default" name="gudang_default" style="width:50%">
                  <?php
                  foreach ($list_gudang as $gudang) {
                  ?>
                    <option value="<?= $gudang['id'] ?>" <?php if ($gudang['id'] == $data_barang['default_gudang_id']) echo 'selected="selected"'; ?>><?= $gudang['nama_gudang'] ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-5">
              <strong class="d-block mb-3">Informasi Penjualan</strong>
              <div class="form-group">
                <label for="kode_barang">Harga Jual Awal</label>
                <input type="text" class="form-control" value="<?= $data_barang['harga_jual'] ?>" id="harga_jual" name="harga_jual" style="width:70%" maxlength="10">
              </div>
              <div class="form-group">
                <label for="kode_barang">Diskon</label>
                <input type="text" class="form-control" value="<?= $data_barang['diskon'] ?>" id="diskon_barang" name="diskon_barang" style="width:70%" maxlength="10">
              </div>
            </div>

          </div>



          <div class="row">
            <div class="col-7">
              <strong class="d-block mb-3">Saldo Awal</strong>

              <div class="form-group">
                <label for="kuantitas_saldo_awal">Kuantitas</label>
                <input type="text" class="form-control" value="<?= $data_barang['saldo_awal_kuantitas'] ?>" id="kuantitas_saldo_awal" name="kuantitas_saldo_awal" style="width:50%">
              </div>
              <div class="form-group">
                <label for="unit">Unit</label>
                <input type="text" class="form-control" value="<?= $data_barang['unit'] ?>" id="unit" name="unit" style="width:30%" maxlength="3">
              </div>
              <div class="form-group">
                <label for="harga_per_unit">Harga / Unit</label>
                <input type="text" class="form-control" value="<?= $data_barang['saldo_awal_harga_per_unit'] ?>" id="harga_per_unit_saldo_awal" name="harga_per_unit_saldo_awal" placeholder="0" style="width:50%">
              </div>
              <div class="form-group">
                <label for="harga_pokok">Harga Pokok</label>
                <input type="text" class="form-control" value="<?= $data_barang['saldo_awal_harga_pokok'] ?>" id="harga_pokok_saldo_awal" name="harga_pokok_saldo_awal" placeholder="0" style="width:50%" readonly>
              </div>
              <div class="form-group">
                <label for="gudang_saldo_awal">Gudang</label>
                <select class="form-control" id="gudang_saldo_awal" name="gudang_saldo_awal" style="width:50%">
                  <?php
                  foreach ($list_gudang as $gudang) {
                  ?>
                    <option value="<?= $gudang['id'] ?>" <?php if ($gudang['id'] == $data_barang['saldo_awal_gudang_id']) echo 'selected="selected"'; ?>><?= $gudang['nama_gudang'] ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="tanggal_saldo_awal">Per Tanggal</label>
                <input type="text" data-toggle="datepicker" class="form-control" id="tanggal_saldo_awal" name="tanggal_saldo_awal" placeholder="" style="width:50%;cursor:pointer;" readonly>
              </div>
            </div>
            <div class="col-5">
              <strong class="d-block mb-3">Saldo Saat Ini</strong>

              <table class="table">
                <tr>
                  <td>Kuantitas</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Harga / Unit</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>Harga Pokok</td>
                  <td>0</td>
                </tr>
              </table>
            </div>
          </div>


          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <a href="<?= base_url('Persediaan/BarangJasa'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <a href="<?= base_url('Persediaan/BarangJasa/hapusBarangJasa/') . $data_barang['id_barang'] ?>" id="btn-delete-pengguna" class="btn btn-danger btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-trash"></i>
              </span>
              <span class="text">Delete</span>
            </a>
            <button type="submit" id="btn-save-pengguna" class="btn btn-primary btn-icon-split btn-lg">
              <span class="icon text-white-50">
                <i class="fas fa-save"></i>
              </span>
              <span class="text">Save</span>
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>