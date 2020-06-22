<!-- <?php var_dump($list_barang_pesanan); ?> -->
<div class="card">
  <div class="card-body">

    <div class="row">
      <div class="col-6">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label for="nama_pelanggan">Order By</label>
              <input type="text" class="form-control" id="nama_pelanggan" value="<?= $data_form['nama_pelanggan'] ?>" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="keterangan">Tagihan Ke</label>
              <textarea class="form-control" id="tagihan_ke" rows="2" readonly><?= $data_form['tagihan_ke'] ?></textarea>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="keterangan">Ship To</label>
              <textarea class="form-control" id="alamat_ship_to" rows="2"><?= $data_form['alamat_ship_to'] ?></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="col-1 d-block"></div>
      <div class="col-5 d-flex flex-row-reverse">
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="no_pesanan">No Pesanan</label>
              <input type="hidden" name="id_pesanan" value="<?= $data_form['id_pesanan'] ?>">
              <input type="text" class="form-control" id="no_pesanan" value="<?= $data_form['no_pesanan'] ?>" readonly>
            </div>
            <div class="form-group">
              <input type="hidden" name="id_delivery" value="<?= $data_form['id_delivery'] ?>">
              <label for="no_delivery">No Delivery</label>
              <input type="text" class="form-control" id="no_delivery" value="<?= $data_form['no_delivery'] ?>" readonly>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="tanggal">Tanggal Pesan</label>
              <input type="text" class="form-control" id="tanggal_pesan" value="<?= $data_form['tanggal_penjualan'] ?>" readonly>
            </div>
            <div class="form-group">
              <label for="tanggal_kirim">Tanggal Pengiriman</label>
              <input type="text" class="form-control" name="tanggal_kirim" id="tanggal_kirim" value="<?= date('Y-m-d') ?>" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <div class="row d-flex align-items-center">
      <div class="col-6">
        <h6 class="d-block"><strong>Detail Pesanan Penjualan</strong></h6>
        <table class="table mt-3">
          <thead>
            <tr>
              <th style="width: 35%;">Kode Brg</th>
              <th style="width: 25%;">Qty Dijual</th>
              <th style="width: 25%;">Qty Terkirim</th>
              <th style="width: 15%;"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($list_barang_pesanan as $barang) {
            ?>
              <tr class="list-barang-dipesan" data-id-barang-pesanan="<?= $barang['id_barang_pesanan'] ?>">
                <td><?= $barang['kode_barang'] ?></td>
                <td>
                  <div class="form-group">
                    <input type="text" class="form-control" id="qty_dijual_<?= $barang['id_barang_pesanan'] ?>" value="<?= $barang['qty_jual'] ?>" readonly>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="hidden" id="table_qty_dikirim_before_<?= $barang['id_barang_pesanan'] ?>" value="<?= $barang['qty_terkirim'] ?>">
                    <input type="text" class="form-control" id="table_qty_dikirim_<?= $barang['id_barang_pesanan'] ?>" name="total_qty_barang_pesanan_dikirim[<?= $barang['id_barang_pesanan'] ?>]" value="<?= $barang['qty_terkirim'] ?>" readonly>
                    <span class="text-danger hide-any" id="error-qty-kirim-lebih-<?= $barang['id_barang_pesanan'] ?>">*Qty Terima tidak boleh lebih dari Qty Dibeli</span>
                  </div>
                </td>
                <td class="edit-column text-center">
                  <div class="btn-tambah-list-barang" data-id="<?= $barang['id_barang_pesanan'] ?>">
                    <i class="fas fa-plus"></i>
                  </div>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-4 text-justify">
        <span>
          Table ini digunakan untuk memastikan pengiriman barang sesuai dengan yang dipesan, serta memudahkan apabila ingin melakukan pengiriman dari berbeda gudang karena stok yang selalu berubah.
        </span>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-12">
        <h6 class="d-block"><strong>Form Pengiriman</strong></h6>
        <div class="table-responsive mt-3">
          <table class="table table-bordered" id="tableListBarangDiterima" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="width: 15%;">Kode Barang</th>
                <th style="width: 25%;">Keterangan</th>
                <th style="width: 15%;">Qty Dikirim</th>
                <th style="width: 5%;">Unit</th>
                <th style="width: 25%;">Gudang</th>
                <th style="width: 10%;">Stok</th>
                <th style="width: 5%;"></th>
              </tr>
            </thead>
            <tbody>
              <?php $this->load->view('penjualan/pengiriman_pesanan/listRowBarangPengiriman', array('model' => $list_barang_pesanan, 'list_gudang' => $list_gudang)); // Load file view.php dan kirim data siswanya 
              ?>
            </tbody>
          </table>
        </div>
      </div>
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