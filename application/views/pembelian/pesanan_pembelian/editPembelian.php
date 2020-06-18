<!-- <?php var_dump($list_barang_beli) ?> -->
<input type="hidden" id="tanggal-now" value="<?= date('Y-m-d') ?>">
<div class="row">
  <div class="col-12">

    <h4 class="mb-3">Edit Pesanan Pembelian</h4>

    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split mb-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">tes</span>
    </button> -->

    <div class="card">
      <div class="card-body">

        <form id="form" action="<?= base_url('Pembelian/PesananPembelian/editPembelian/' . $id_form) ?>" method="post">

          <div class="row">
            <div class="col-8">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="supplier_id">Supplier<span style="color: red">*</span></label>
                    <select class="form-control pilih-gudang" id="supplier_id" name="supplier_id">
                      <option value="kosong">--- Pilih Supplier ---</option>
                      <?php
                      foreach ($supplier as $x) {
                      ?>
                        <option value="<?= $x['id'] ?>" <?php if ($data_form['supplier_id'] == $x['id']) echo 'selected'; ?>><?= $x['nama_pemasok'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                    <span class="text-danger hide-any" id="error-supplier-kosong">*Supplier tidak boleh kosong</span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="keterangan">Alamat Supplier</label>
                    <textarea class="form-control" id="alamat_supplier" name="alamat_supplier" rows="2" readonly><?= $data_form['alamat_supplier'] ?></textarea>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="keterangan">Ship To<span style="color: red">*</span></label>
                    <textarea class="form-control" id="alamat_diterima" name="alamat_diterima" rows="2"><?= $data_form['alamat_ship_to'] ?></textarea>
                    <span class="text-danger hide-any" id="error-ship-to-kosong">*Alamat Ship To tidak boleh kosong</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4 d-flex">
              <div class="form-group mr-2">
                <label for="tanggal">Kode Pesanan</label>
                <input type="hidden" name="id_pesanan" value="<?= $data_form['id'] ?>">
                <input type="text" class="form-control" value="<?= $data_form['no'] ?>" id="kode_pembelian" readonly>
              </div>
              <div class="form-group">
                <label for="tanggal">Tanggal Pembelian</label>
                <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= $data_form['tanggal'] ?>" readonly>
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

          <div class="table-responsive">
            <table class="table table-bordered" id="tableListPembelian" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode Barang</th>
                  <th>Keterangan</th>
                  <th>Qty Beli</th>
                  <th>Unit</th>
                  <th>Harga Unit</th>
                  <th>Diskon</th>
                  <th>Subtotal</th>
                  <th>Diterima</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $this->load->view('pembelian/pesanan_pembelian/tableListBarangPesanananPembelian', array('model' => $list_barang_beli)); // Load file view.php dan kirim data siswanya 
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
              <div class="form-group">
                <label for="tanggal">Pengiriman Via</label>
                <input type="text" class="form-control" id="pengiriman_via" name="pengiriman_via" value="<?= $data_form['pengiriman_via'] ?>">
              </div>
            </div>
            <div class="col-3 my-auto d-flex justify-content-center">
              <div class="form-check">
                <?php if ($data_form['is_uang_muka'] == 1) { ?>
                  <input type="hidden" name="id_faktur_dp" value="<?= $data_form['id_faktur_dp'] ?>">
                  <input type="hidden" name="id_faktur_data_dp" value="<?= $data_form['id_faktur_data_dp'] ?>">
                <?php } ?>
                <input type="hidden" name="is_uang_muka_enabled_before" value="<?= $data_form['is_uang_muka'] ?>">
                <input class="form-check-input" type="checkbox" value="yes" id="is_uang_muka_enabled" name="is_uang_muka_enabled" <?php if ($data_form['is_uang_muka'] == 1) echo 'checked'; ?>>
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
                    <td>
                      <h6>PPN 10%</h6>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <input class="ml-0 mr-2" type="checkbox" value="yes" id="is_hitung_ppn" name="is_hitung_ppn" <?php if ($data_form['is_hitung_ppn'] == 1) echo 'checked'; ?>>
                        <span>Hitung PPN?</span>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="pajak_ppn" id="pajak_ppn" value="<?= $data_form['pajak_ppn'] ?>">
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
            <a href="<?= base_url('Pembelian/PesananPembelian'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <div href="<?= base_url('Pembelian/PesananPembelian/hapusPembelian/' . $id_form) ?>" id="btn-delete" class="btn btn-danger btn-icon-split btn-lg ml-3" style="cursor: pointer">
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

<div class="row hide-any">
  <div class="col-3">
    <div class="card">
      <div class="card-body">
        <h5>Value alamat</h5>
        <?php
        foreach ($supplier as $x) {
        ?>
          <div>
            <?= $x['id'] ?> :
            <input type="text" id="alamat_supplier_<?= $x['id'] ?>" value="<?= $x['alamat'] ?>">
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
  <div class="col-9">
    <h5>Data Untuk Update</h5>
    <div class="table-responsive mt-5">
      <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>any_before</th>
            <td>is_delete</td>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($list_barang_beli as $x) {
          ?>
            <tr>
              <td>
                <?= $x['id_barang'] ?>
                <input type="text" value="1" id="is_any_before_<?= $x['id_barang'] ?>">
              </td>
              <td>
                <?= $x['id_barang'] ?>
                <input type="text" value="0" name="is_delete[<?= $x['id_barang'] ?>]" id="is_delete_<?= $x['id_barang'] ?>">
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Pengguna -->
<div id="modal-pilih-barang" class="custom-modal mx-auto hide-any">
  <div class="row" style="width: 100%;height: 100vh;">
    <div class="col-6 my-auto mx-auto">
      <div class="card" style="height: 80vh;overflow-y: auto;">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h5 style="width: 100%">Pilih Barang</h5>
            <span id="btn-close" class="close"><i class="fas fa-times-circle"></i></span>
          </div>
          <hr>
          <div class="table-responsive">
            <table class="table table-bordered" id="tableBarang" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="data-table-user">
                <?php $this->load->view('pembelian/pesanan_pembelian/tablePilihBarangForEdit', array('model' => $list_barang, 'added' => $list_barang_beli)); // Load file view.php dan kirim data siswanya 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Uang Muka -->
<div id="modal-uang-muka" class="custom-modal mx-auto hide-any">
  <div class="row" style="width: 100%;height: 100vh;">
    <div class="col-6 my-auto mx-auto">
      <div class="card" style="height: 60vh;overflow-y: auto;">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h5 style="width: 100%">Uang Muka</h5>
            <span id="btn-close-dp" class="close"><i class="fas fa-times-circle"></i></span>
          </div>
          <hr>

          <div class="table-responsive">
            <table class="table table-bordered" id="tableBarang" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Deskripsi</th>
                  <th>Jumlah DP</th>
                </tr>
              </thead>
              <tbody id="data-table-user">
                <tr>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control" value="<?= $data_form['deskripsi_dp'] ?>" name="deskripsi_dp" form="form" maxlength="100">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control input_harga" value="<?= $data_form['jumlah_dp'] ?>" name="jumlah_dp" form="form">
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="mt-3">
            Apabila uang muka diisi, secara otomatis akan membuat faktur pembelian baru untuk DP.
          </div>

          <hr>

          <div class="d-flex flex-row-reverse">
            <button type="button" id="btn-cancel-dp" class="btn btn-warning btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-undo-alt"></i>
              </span>
              <span class="text">Cancel</span>
            </button>
            <button type="button" id="btn-save-dp" class="btn btn-primary btn-icon-split mr-3">
              <span class="icon text-white-50">
                <i class="fas fa-save"></i>
              </span>
              <span class="text">Save</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>