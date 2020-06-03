<?= print_r($barang_added) ?>
<div class="row">
  <div class="col-12">

    <h4 class="mb-3">Edit Penyesuaian Harga Jual</h4>

    <button type="button" id="tes" class="btn btn-primary btn-icon-split mb-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">tes</span>
    </button>

    <div class="card">
      <div class="card-body">

        <form id="form-tambah-penyesuaian-harga" action="<?= base_url('Persediaan/SetHargaPenjualan/editSetHargaPenjualan/') . $id_form ?>" method="post">
          <div id="is_add"></div>
          <?php
          foreach ($list_harga_per_barang as $x) {
          ?>
            <input type="text" value="0" name="is_delete[<?= $x['id_harga'] ?>]" id="is_delete_<?= $x['id_harga'] ?>">
          <?php
          }
          ?>

          <div class="form-group">
            <label for="tanggal">Tanggal Penyesuaian</label>
            <input type="text" value="<?= $data_form['tanggal'] ?>" class="form-control" name="tanggal" id="tanggal" readonly style="width: 20%">
          </div>

          <div class="form-group">
            <label for="keterangan">Keterangan<span style="color: red">*</span></label>
            <textarea class="form-control" id="keterangan" rows="2" name="keterangan" style="width: 40%"><?= $data_form['keterangan'] ?></textarea>
            <span class="text-danger hide-any" id="error-keterangan-kosong">*Keterangan tidak boleh kosong</span>
          </div>

          <hr>

          <button type="button" id="btn-pilih-barang" class="btn btn-primary btn-icon-split mb-3">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Pilih Barang</span>
          </button>

          <div class="table-responsive">
            <table class="table table-bordered" id="tableListPenyesuaian" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Keterangan</th>
                  <th>Harga 1</th>
                  <th>Harga 2</th>
                  <th>Harga 3</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $this->load->view('persediaan/set_harga_penjualan/tableListHargaBarangDisesuaikan', array('model' => $list_harga_per_barang)); // Load file view.php dan kirim data siswanya 
                ?>
              </tbody>
            </table>
          </div>

          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <a href="<?= base_url('Persediaan/SetHargaPenjualan'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
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
                <?php $this->load->view('persediaan/set_harga_penjualan/tablePilihBarangForEdit', array('model' => $barang, 'added' => $barang_added)); // Load file view.php dan kirim data siswanya 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>