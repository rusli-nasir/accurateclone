<!-- <?php var_dump($list_barang_dipindah); ?> -->
<div class="row">
  <div class="col-12">

    <h4 class="mb-3">Tambah Pemindahan Barang Baru</h4>

    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split mb-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">tes</span>
    </button> -->

    <div class="card">
      <div class="card-body">

        <form id="form" action="<?= base_url('Persediaan/PindahBarang/editPemindahanBarang/' . $id_form) ?>" method="post">

          <div class="row">
            <div class="col-7">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="dari_gudang">Dari<span style="color: red">*</span></label>
                    <input type="hidden" id="dari_gudang_value" name="dari_gudang" value="<?= $data_form['dari_id'] ?>">
                    <select class="form-control pilih-gudang" data-id="dari_alamat" id="dari_gudang" style="width:90%" disabled>
                      <option value="0">--- Pilih Gudang ---</option>
                      <?php
                      foreach ($list_gudang as $gudang) {
                      ?>
                        <?php if ($gudang['id'] == $data_form['dari_id']) { ?>
                          <option value="<?= $gudang['id'] ?>" selected><?= $gudang['nama_gudang'] ?></option>
                        <?php } else { ?>
                          <option value="<?= $gudang['id'] ?>"><?= $gudang['nama_gudang'] ?></option>
                        <?php } ?>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Alamat</label>
                    <textarea class="form-control" id="dari_alamat" rows="2" style="width: 90%" readonly><?= $data_form['dari_alamat'] ?></textarea>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="ke_gudang">Ke<span style="color: red">*</span></label>
                    <input type="hidden" id="ke_gudang_value" name="ke_gudang" value="<?= $data_form['ke_id'] ?>">
                    <select class="form-control pilih-gudang" data-id="ke_alamat" id="ke_gudang" style="width:90%" disabled>
                      <option value="0">--- Pilih Gudang ---</option>
                      <?php
                      foreach ($list_gudang as $gudang) {
                      ?>
                        <?php if ($gudang['id'] == $data_form['ke_id']) { ?>
                          <option value="<?= $gudang['id'] ?>" selected><?= $gudang['nama_gudang'] ?></option>
                        <?php } else { ?>
                          <option value="<?= $gudang['id'] ?>"><?= $gudang['nama_gudang'] ?></option>
                        <?php } ?>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Alamat</label>
                    <textarea class="form-control" id="ke_alamat" rows="2" style="width: 90%" readonly><?= $data_form['ke_alamat'] ?></textarea>
                  </div>
                </div>
                <div class="col-12 text-center">
                  <input type="hidden" value="1" id="value-done-gudang">
                  <button type="button" id="btn-done-gudang" class="btn btn-primary btn-icon-split btn">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Selesai Memilih Gudang</span>
                  </button>
                  <button type="button" id="btn-change-gudang" class="btn btn-danger btn-icon-split btn">
                    <span class="icon text-white-50">
                      <i class="fas fa-undo"></i>
                    </span>
                    <span class="text">Ganti Tujuan Pemindahan Gudang</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-5">
              <div class="form-group">
                <label for="tanggal">Tanggal Pemindahan</label>
                <input type="text" class="form-control" name="tanggal" id="tanggal" readonly style="width: 40%" value="<?= $data_form['tanggal'] ?>">
              </div>

              <div class="form-group">
                <label for="keterangan">Keterangan<span style="color: red">*</span></label>
                <textarea class="form-control" id="keterangan" rows="2" name="keterangan" style="width: 90%"><?= $data_form['keterangan'] ?></textarea>
                <span class="text-danger hide-any" id="error-keterangan-kosong">*Keterangan tidak boleh kosong</span>
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
            <table class="table table-bordered" id="tableListPenyesuaian" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Keterangan</th>
                  <td>Jumlah Sebelum Pindah(Stok Sekarang di Gudang + Jumlah Dipindah)</td>
                  <th>Jumlah Dipindahkan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $this->load->view('persediaan/pindah_barang/tableListPemindahanBarangDisesuaikan', array('model' => $list_barang_dipindah)); ?>
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
                  foreach ($list_barang_dipindah as $x) {
                  ?>
                    <tr>
                      <td>
                        <?= $x['id'] ?>
                        <input type="text" value="1" id="is_any_before_<?= $x['id'] ?>">
                      </td>
                      <td>
                        <?= $x['id'] ?>
                        <input type="text" value="0" name="is_delete[<?= $x['id'] ?>]" id="is_delete_<?= $x['id'] ?>">
                      </td>
                    </tr>
                  <?php
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
            <div href="<?= base_url('Persediaan/PindahBarang/hapusPemindahanBarang/' . $id_form) ?>" id="btn-delete" class="btn btn-danger btn-icon-split btn-lg ml-3" style="cursor: pointer">
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

<?php
foreach ($list_gudang as $gudang) {
?>
  <input type="hidden" value="<?= $gudang['alamat'] ?>" id="alamat_gudang_id_<?= $gudang['id'] ?>">
<?php
}
?>

<!-- Modal Pilih Barang -->
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
          <div class="h5 text-center">
            <?php
            foreach ($list_gudang as $gudang) {
              if ($gudang['id'] == $data_form['dari_id']) {
            ?>
                <strong>Data Barang Pada Gudang "<?= $gudang['nama_gudang'] ?>"</strong>
            <?php
              }
            }
            ?>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="tableBarang" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Keterangan</th>
                  <th>Stok</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="data-tableBarang">
                <?php $this->load->view('persediaan/pindah_barang/tablePilihBarangForEdit', array('model' => $data_barang, 'added' => $barang_added)); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>