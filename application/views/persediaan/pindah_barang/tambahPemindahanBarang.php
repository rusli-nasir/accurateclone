<!-- <?php print_r($tes); ?> -->
<div class="row">
  <div class="col-12">

    <h4 class="mb-3">Tambah Pemindahan Barang Baru</h4>

    <button type="button" id="tes" class="btn btn-primary btn-icon-split mb-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">tes</span>
    </button>

    <div class="card">
      <div class="card-body">

        <form id="form" action="<?= base_url('Persediaan/PindahBarang/tambahPemindahanBarang') ?>" method="post">

          <div class="row">
            <div class="col-7">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="dari_gudang">Dari<span style="color: red">*</span></label>
                    <input type="hidden" id="dari_gudang_value" name="dari_gudang">
                    <select class="form-control pilih-gudang" data-id="dari_alamat" id="dari_gudang" name="dari_gudang" style="width:90%">
                      <option value="0">--- Pilih Gudang ---</option>
                      <?php
                      foreach ($list_gudang as $gudang) {
                      ?>
                        <option value="<?= $gudang['id'] ?>"><?= $gudang['nama_gudang'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Alamat</label>
                    <textarea class="form-control" id="dari_alamat" rows="2" style="width: 90%" readonly></textarea>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="ke_gudang">Ke<span style="color: red">*</span></label>
                    <input type="hidden" id="ke_gudang_value" name="ke_gudang">
                    <select class="form-control pilih-gudang" data-id="ke_alamat" id="ke_gudang" style="width:90%">
                      <option value="0">--- Pilih Gudang ---</option>
                      <?php
                      foreach ($list_gudang as $gudang) {
                      ?>
                        <option value="<?= $gudang['id'] ?>"><?= $gudang['nama_gudang'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Alamat</label>
                    <textarea class="form-control" id="ke_alamat" rows="2" style="width: 90%" readonly></textarea>
                  </div>
                </div>
                <div class="col-12 text-center">
                  <input type="hidden" value="0" id="value-done-gudang">
                  <button type="button" id="btn-done-gudang" class="btn btn-danger btn-icon-split btn">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Selesai Memilih Gudang</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-5">
              <div class="form-group">
                <label for="tanggal">Tanggal Pemindahan</label>
                <input type="text" class="form-control" name="tanggal" id="tanggal" readonly style="width: 40%" value="<?= date('Y-m-d') ?>">
              </div>

              <div class="form-group">
                <label for="keterangan">Keterangan<span style="color: red">*</span></label>
                <textarea class="form-control" id="keterangan" rows="2" name="keterangan" style="width: 90%"></textarea>
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
                  <th>Jumlah Sekarang</th>
                  <th>Jumlah Dipindahkan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

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
                <!-- <?php $this->load->view('persediaan/pindah_barang/tablePilihBarang', array('model' => $tes)); // Load file view.php dan kirim data siswanya 
                      ?> -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>