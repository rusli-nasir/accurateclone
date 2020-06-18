<!-- <?php var_dump($supplier) ?> -->
<input type="hidden" id="tanggal-now" value="<?= date('Y-m-d') ?>">
<div class="row">
  <div class="col-12">

    <h4 class="mb-3">Tambah Pesanan Pembelian Baru</h4>

    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split mb-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">tes</span>
    </button> -->

    <div class="card">
      <div class="card-body">

        <form id="form" action="<?= base_url('Pembelian/PesananPembelian/tambahPembelian') ?>" method="post">

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
                        <option value="<?= $x['id'] ?>"><?= $x['nama_pemasok'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                    <span class="text-danger hide-any" id="error-supplier-kosong">*Supplier tidak boleh kosong</span>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Alamat Supplier</label>
                    <textarea class="form-control" id="alamat_supplier" name="alamat_supplier" rows="2" readonly></textarea>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="supplier_id">Pilih Alamat Diterima</label>
                    <select class="form-control pilih-gudang" id="select-alamat-ship-to">
                      <option value="custom">Custom</option>
                      <?php
                      $i = 0;
                      foreach ($list_alamat as $x) {
                      ?>
                        <option value="<?= $i ?>"><?= $x['nama'] ?></option>
                      <?php
                        $i++;
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Ship To<span style="color: red">*</span></label>
                    <textarea class="form-control" id="alamat_diterima" name="alamat_diterima" rows="2"></textarea>
                    <span class="text-danger hide-any" id="error-ship-to-kosong">*Alamat Ship To tidak boleh kosong</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4 d-flex">
              <div class="form-group mr-2">
                <label for="tanggal">Kode Pesanan</label>
                <input type="hidden" name="id_pesanan" value="<?= $kode_pesanan['id'] ?>">
                <input type="text" class="form-control" value="<?= $kode_pesanan['kode_pesanan'] ?>" id="kode_pembelian" readonly>
              </div>
              <div class="form-group">
                <label for="tanggal">Tanggal Pembelian</label>
                <input type="text" class="form-control" name="tanggal" id="tanggal" readonly>
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
                  <th></th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>

          <hr class="mt-5 mb-5">

          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"></textarea>
              </div>
              <div class="form-group">
                <label for="tanggal">Pengiriman Via</label>
                <input type="text" class="form-control" id="pengiriman_via" name="pengiriman_via">
              </div>
            </div>
            <div class="col-3 my-auto d-flex justify-content-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="yes" id="is_uang_muka_enabled" name="is_uang_muka_enabled">
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
                        <input type="text" class="form-control input_harga" name="subtotal_overall" id="subtotal_overall" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h6>Diskon</h6>
                    </td>
                    <td>
                      <div class="form-group mx-auto" style="width: 50%">
                        <input type="text" class="form-control input_diskon" name="diskon_overall" id="diskon_overall">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="jumlah_diskon_overall" id="jumlah_diskon_overall" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h6>PPN 10%</h6>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <input class="ml-0 mr-2" type="checkbox" value="yes" id="is_hitung_ppn" name="is_hitung_ppn">
                        <span>Hitung PPN?</span>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="pajak_ppn" id="pajak_ppn">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <h6>Biaya Pengiriman</h6>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" id="biaya_pengiriman" name="biaya_pengiriman">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <h6>Total Biaya</h6>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="total_biaya" id="total_biaya" readonly>
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
                <i class="fas fa-undo-alt"></i>
              </span>
              <span class="text">Cancel</span>
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
  <div class="col-3">
    <div class="card">
      <div class="card-body">
        <h5>Value alamat</h5>
        <?php
        $i = 0;
        foreach ($list_alamat as $x) {
        ?>
          <div>
            <?= $i ?> :
            <input type="text" id="alamat_id_<?= $i ?>" value="<?= $x['alamat'] ?>">
          </div>
        <?php
          $i++;
        }
        ?>
      </div>
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
                <?php $this->load->view('pembelian/pesanan_pembelian/tablePilihBarang', array('model' => $list_barang)); // Load file view.php dan kirim data siswanya 
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
                      <input type="text" class="form-control" name="deskripsi_dp" value="Down Payment" form="form" maxlength="100">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" class="form-control input_harga" name="jumlah_dp" value="0" form="form">
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