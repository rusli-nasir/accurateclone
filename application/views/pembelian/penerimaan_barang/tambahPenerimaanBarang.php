<!-- <?php var_dump($list_pesanan) ?> -->
<input type="hidden" id="tanggal-now" value="<?= date('Y-m-d') ?>">
<div class="row">
  <div class="col-12">

    <h4 class="mb-3">Tambah Form Penerimaan Barang Baru</h4>

    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split mb-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">tes</span>
    </button> -->

    <div class="card">
      <div class="card-body">

        <form id="form" action="<?= base_url('Pembelian/PenerimaanBarang/tambahPenerimaanBarang') ?>" method="post">

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
              </div>
            </div>
            <div class="col-4 d-flex">
              <div class="form-group mr-2">
                <label for="tanggal">Kode Penerimaan</label>
                <input type="hidden" name="id_penerimaan" value="<?= $kode_penerimaan['id'] ?>">
                <input type="text" class="form-control" value="<?= $kode_penerimaan['kode'] ?>" id="kode_pembelian" readonly>
              </div>
              <div class="form-group">
                <label for="tanggal">Tanggal Pembelian</label>
                <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" readonly>
              </div>
            </div>
          </div>

          <hr>

          <button type="button" id="btn-pilih-pesanan" class="btn btn-primary btn-icon-split mb-3">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Pilih Pesanan</span>
          </button>

          <div class="table-responsive">
            <table class="table table-bordered" id="tableListBarangDiterima" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode Barang</th>
                  <th>Keterangan</th>
                  <th>Qty Dibeli</th>
                  <th>Qty Terima</th>
                  <th>Unit</th>
                  <th>Gudang</th>
                </tr>
              </thead>
              <tbody id="bodyListBarangDiterima">

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
            </div>
          </div>

          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <a href="<?= base_url('Pembelian/PesananPembelian'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
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
</div>

<!-- Modal Tambah Pengguna -->
<div id="modal-pilih-pesanan" class="custom-modal mx-auto hide-any">
  <div class="row" style="width: 100%;height: 100vh;">
    <div class="col-6 my-auto mx-auto">
      <div class="card" style="height: 80vh;overflow-y: auto;">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h5 style="width: 100%">Pilih Pesanan Pembelian</h5>
            <span id="btn-close" class="close"><i class="fas fa-times-circle"></i></span>
          </div>
          <hr>
          <form id="getListBarangPesanan">
            <div class="table-responsive">
              <table class="table table-bordered" id="tablePesanan" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No Pesanan</th>
                    <th>Tanggal</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="data-table-pesanan">
                  <?php $this->load->view('pembelian/penerimaan_barang/tablePilihPesanan', array('model' => $list_pesanan)); // Load file view.php dan kirim data siswanya 
                  ?>
                </tbody>
              </table>
            </div>

            <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
              <button type="submit" id="btn-tambah-pesanan" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text">Masukkan</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>