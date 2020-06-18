<!-- <?php var_dump($list_barang_pesanan); ?> -->
<div class="row">
  <div class="col-12">
    <h4 class="mb-3">Edit Form Penerimaan Barang</h4>
    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-search"></i>
      </span>
      <span class="text">tes</span>
    </button> -->

    <form id="form" action="<?= base_url('Pembelian/PenerimaanBarang/editPenerimaanBarang/' . $id_form_penerimaan) ?>" method="post">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-7">
              <div class="row">
                <div class="col-7">
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
            <div class="col-5 d-flex flex-row-reverse">
              <div class="form-group pl-2" style="width: 50%;">
                <label for="tanggal">Tanggal Diterima</label>
                <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= $data_form['tanggal'] ?>" readonly>
              </div>
              <div class="form-group pr-2" style="width: 50%;">
                <label for="tanggal">No Pesanan Diterima</label>
                <input type="hidden" name="id_pesanan_diterima" value="<?= $data_form['id_pesanan'] ?>">
                <input type="text" class="form-control" name="kode_pesanan_diterima" value="<?= $kode_pesanan ?>" readonly>
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
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"><?= $data_form['deskripsi'] ?></textarea>
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
            <div href="<?= base_url('Pembelian/PenerimaanBarang/hapusPenerimaanBarang/' . $id_form_penerimaan) ?>" id="btn-delete" class="btn btn-danger btn-icon-split btn-lg ml-3" style="cursor: pointer">
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

        </div>
      </div>
    </form>
  </div>
</div>