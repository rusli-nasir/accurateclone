<!-- <?php var_dump($list_barang_jual) ?> -->
ASU
<div class="row">
  <div class="col-12">

    <h4 class="mb-3">Tambah Pesanan Penjualan Baru</h4>

    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split mb-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">tes</span>
    </button> -->

    <div class="card">
      <div class="card-body">

        <form id="form" action="<?= base_url('Penjualan/PesananPenjualan/editPesananPenjualan/' . $id_form) ?>" method="post">

          <div class="row">
            <div class="col-6">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="order_by_pelanggan_id">Order By<span style="color: red">*</span></label>
                    <select class="form-control" id="order_by_pelanggan_id" name="order_by_pelanggan_id">
                      <option value="kosong">--- Pilih Pelanggan ---</option>
                      <?php
                      foreach ($pelanggan as $x) {
                      ?>
                        <option value="<?= $x['id'] ?>" <?php if ($data_form['id_pelanggan'] == $x['id']) echo 'selected'; ?>><?= $x['nama_pelanggan'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                    <span class="text-danger hide-any" id="error-pelanggan-kosong">*Pilih pelanggan dahulu</span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="keterangan">Tagihan Ke</label>
                    <textarea class="form-control" id="tagihan_ke" rows="2" readonly><?= $data_form['alamat_pelanggan'] ?></textarea>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="keterangan">Ship To</label>
                    <textarea class="form-control" id="alamat_ship_to" name="alamat_ship_to" rows="2"><?= $data_form['alamat_ship_to'] ?></textarea>
                    <span class="text-danger hide-any" id="error-ship-to-kosong">*Alamat Ship To tidak boleh kosong</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-1 d-block"></div>
            <div class="col-5">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="tanggal">Kode Penjualan</label>
                    <input type="hidden" name="id_pesanan" value="<?= $data_form['id'] ?>">
                    <input type="text" class="form-control" value="<?= $data_form['no'] ?>" id="kode_penjualan" readonly>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="tanggal">Tanggal Penjualan</label>
                    <input type="text" class="form-control datepicker" name="tanggal_penjualan" id="tanggal_penjualan" value="<?= $data_form['tanggal_penjualan'] ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="tanggal">Ship Date</label>
                    <input type="text" class="form-control datepicker" name="ship_date" id="ship_date" value="<?= $data_form['ship_date'] ?>" readonly>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="supplier_id">Ship Via<span style="color: red">*</span></label>
                    <select class="form-control pilih-gudang" id="ship_via" name="ship_via">
                      <option value="kosong">--- Pilih Pengiriman ---</option>
                      <?php
                      foreach ($ship_via as $x) {
                      ?>
                        <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $data_form['daftar_jasa_pengiriman_id']) echo 'selected'; ?>><?= $x['nama'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                    <span class="text-danger hide-any" id="error-ship-via-kosong">*Pilih pengiriman dahulu</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <button type="button" id="btn-pilih-barang" class="btn btn-primary btn-icon-split mb-3">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Pilih Barang</span>
          </button>

          <div class="mb-3 text-center">
            Sebisa mungkin jangan ada barang yang terduplikat di list barang yang akan dijual dibawah ini karena akan menyebabkan error-nya perhitungan.
          </div>

          <div class="table-responsive">
            <table class="table table-bordered" id="tableListPenjualan" width="100%" cellspacing="0" style="font-size: 0.8rem;">
              <thead>
                <tr>
                  <th>Kode Barang</th>
                  <th>Keterangan</th>
                  <th>Stok</th>
                  <th>Qty Jual</th>
                  <th>Unit</th>
                  <th>Harga Unit</th>
                  <th>Diskon</th>
                  <th>Subtotal</th>
                  <th>Terkirim</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $this->load->view('penjualan/pesanan_penjualan/listRowBarangPesananPenjualanInserted', array('list_barang' => $list_barang_jual)); // Load file view.php dan kirim data siswanya 
                ?>
              </tbody>
            </table>
          </div>

          <hr class="mt-5 mb-5">

          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"><?= $data_form['deskripsi'] ?></textarea>
              </div>
            </div>
            <div class="col-3 my-auto d-flex justify-content-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="yes" id="is_uang_muka_enabled" name="is_uang_muka_enabled" <?php if ($data_form['is_uang_muka'] == '1') echo 'checked'; ?>>
                <label class="form-check-label" for="is_uang_muka_enabled">
                  Uang Muka
                </label>
              </div>
            </div>
            <div class="col-5 table-responsive">
              <table width="100%">
                <thead>
                  <tr>
                    <td style="width: 30%"></td>
                    <td style="width: 30%"></td>
                    <td style="width: 40%"></td>
                  </tr>
                </thead>
                <tbody class="no-style">
                  <tr>
                    <td colspan="2">
                      <h6>Subtotal</h6>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="subtotal_overall" id="subtotal_overall" value="<?= $data_form['subtotal_overall'] ?>" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h6>Diskon</h6>
                    </td>
                    <td>
                      <div class="form-group mx-auto" style="width: 50%">
                        <input type="text" class="form-control input_diskon" name="diskon_overall" id="diskon_overall" value="<?= $data_form['diskon_overall'] ?>">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="jumlah_diskon_overall" id="jumlah_diskon_overall" value="<?= $data_form['jumlah_diskon_overall'] ?>" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <h6>Biaya Pengiriman</h6>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" id="biaya_pengiriman" name="biaya_pengiriman" value="<?= $data_form['biaya_pengiriman'] ?>">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <h6>Total Biaya</h6>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="total_biaya" id="total_biaya" value="<?= $data_form['total_biaya'] ?>" readonly>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <a href="<?= base_url('Penjualan/PesananPenjualan'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-undo-alt"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <div href="<?= base_url('Penjualan/PesananPenjualan/hapusPesananPenjualan/' . $id_form) ?>" id="btn-delete" class="btn btn-danger btn-icon-split btn-lg ml-3" style="cursor: pointer">
              <span class="icon text-white-50">
                <i class="fas fa-trash"></i>
              </span>
              <span class="text">Delete</span>
            </div>
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

<div class="row mt-5">
  <div class="col-3">
    <div class="card">
      <div class="card-body">
        <h5>Alamat Pelanggan</h5>
        <?php
        foreach ($pelanggan as $x) {
        ?>
          <div>
            <?= $x['id'] ?> :
            <input type="text" id="alamat_pelanggan_<?= $x['id'] ?>" value="<?= $x['alamat'] ?>">
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Pengguna -->
<div id="modal-pilih-barang" class="custom-modal mx-auto hide-any">
  <div class="row" style="width: 100%;height: 100vh;">
    <div class="col-9 my-auto mx-auto">
      <div class="card" style="height: 80vh;overflow-y: auto;">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h5 style="width: 100%">Pilih Barang</h5>
            <span id="btn-close" class="close"><i class="fas fa-times-circle"></i></span>
          </div>
          <hr>
          <div class="table-responsive">
            <table class="table table-bordered" id="tableBarang" width="100%" cellspacing="0">

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>