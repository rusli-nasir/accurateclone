<!-- <?php print_r($list_barang_disesuaikan); ?> -->
<div class="row">
  <div class="col-12">

    <h4 class="mb-3">Tambah Penyesuaian Persediaan Baru</h4>

    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split mb-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">tes</span>
    </button> -->

    <div class="card">
      <div class="card-body">

        <form id="form" action="<?= base_url('Persediaan/PenyeseuaianPersediaan/editPenyeseuaianPersediaan/' . $id_form) ?>" method="post">

          <div class="form-group">
            <label for="tanggal">Tanggal Penyesuaian</label>
            <input type="text" class="form-control" name="tanggal" id="tanggal" readonly style="width: 20%" value="<?= $data_form['tanggal'] ?>">
          </div>

          <div class="form-group">
            <label for="keterangan">Keterangan<span style="color: red">*</span></label>
            <textarea class="form-control" id="keterangan" rows="2" name="keterangan" style="width: 40%"><?= $data_form['keterangan'] ?></textarea>
            <span class="text-danger hide-any" id="error-keterangan-kosong">*Keterangan tidak boleh kosong</span>
          </div>

          <hr>

          <!-- <button type="button" id="btn-pilih-barang" class="btn btn-primary btn-icon-split mb-3">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Pilih Barang</span>
          </button> -->

          <div class="table-responsive">
            <table class="table table-bordered" id="tableListPenyesuaian" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Keterangan</th>
                  <th>Selisih Kuantitas</th>
                  <th>Gudang</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $this->load->view('persediaan/penyesuaian_persediaan/tableListStokBarangDisesuaikan', array('model' => $list_barang_disesuaikan, 'gudang' => $gudang)); // Load file view.php dan kirim data siswanya 
                ?>
              </tbody>
            </table>
          </div>

          <div class="hide-any">
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
                  $i = 0;
                  foreach ($list_barang_disesuaikan as $x) {
                  ?>
                    <tr>
                      <td>
                        <?= $x['id_barang'] ?>
                        <input type="text" value="1" id="is_any_before_<?= $x['id_barang'] ?>">
                      </td>
                      <td>
                        <?= $x['id_stok'] ?>
                        <input type="text" value="0" name="is_delete[<?= $i ?>]" id="is_delete_<?= $x['id_stok'] ?>">
                      </td>
                    </tr>
                  <?php
                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <a href="<?= base_url('Persediaan/SetHargaPenjualan'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <div href="<?= base_url('Persediaan/PenyeseuaianPersediaan/hapusPenyeseuaianPersediaan/' . $id_form) ?>" id="btn-delete" class="btn btn-danger btn-icon-split btn-lg ml-3" style="cursor: pointer">
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
                <?php $this->load->view('persediaan/penyesuaian_persediaan/tablePilihBarangForEdit', array('model' => $barang, 'added' => $list_barang_disesuaikan)); // Load file view.php dan kirim data siswanya 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>