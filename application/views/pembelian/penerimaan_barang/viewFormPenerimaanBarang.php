<?php var_dump($list_barang_pesanan) ?>
<div class="card">
  <div class="card-body">

    <div class="row">
      <div class="col-8">
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="supplier_id">Supplier</label>
              <input type="text" class="form-control" id="supplier" value="<?= $data_form['nama_pemasok'] ?>" readonly>
            </div>
            <div class="form-group">
              <label for="keterangan">Alamat Supplier</label>
              <textarea class="form-control" id="alamat_supplier" rows="2" readonly><?= $data_form['alamat_pemasok'] ?></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4 d-flex flex-row-reverse">
        <div class="form-group">
          <label for="tanggal">Tanggal Diterima</label>
          <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" readonly>
        </div>
      </div>
    </div>

    <hr>

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
          <?php $this->load->view('pembelian/penerimaan_barang/listRowBarangPesanan', array('model' => $list_barang_pesanan, 'list_gudang' => $list_gudang)); // Load file view.php dan kirim data siswanya 
          ?>
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
      <a href="<?= base_url('Pembelian/PenerimaanBarang'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
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

  </div>
</div>