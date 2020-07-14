<?php var_dump($list_barang_pengiriman); ?>
sdasdasd
<div class="row">
  <div class="col-12">
    <h4 class="mb-3">Edit Faktur Penjualan</h4>

    <form id="form" action="<?= base_url('Penjualan/FakturPenjualan/editFakturPenjualan/' . $data_form['id_faktur']) ?>" method="post">

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
                    <label for="no_pesanan">No Faktur</label>
                    <input type="hidden" name="id_faktur" value="<?= $data_form['id_faktur'] ?>">
                    <input type="text" class="form-control" id="no_faktur" value="<?= $data_form['no_faktur'] ?>" readonly>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="tanggal">Tanggal Pesan</label>
                    <input type="text" class="form-control" id="tanggal_pesan" value="<?= $data_form['tanggal_penjualan'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="tanggal">Tanggal Faktur</label>
                    <input type="text" class="form-control" id="tanggal_faktur" name="tanggal_faktur" value="<?= date('Y-m-d') ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <?php if ($data_form['is_row_dp'] == 0) { ?>
            <div class="row mb-4">
              <div class="col-12">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="sub-fitur btn btn-primary active text-white" data-id="view_list_barang">List Barang Dibeli</button>
                  <?php if ($data_form['is_uang_muka'] == 1) { ?>
                    <button type="button" class="sub-fitur btn btn-primary text-white" data-id="view_dp">Down Payment</button>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>

          <div class="row">
            <div class="col-12">
              <h6 class="d-block"><strong>Form Pengiriman</strong></h6>
              <div class="table-responsive mt-3">
                <table class="table table-bordered" id="tableListBarangDiterima" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Barang</th>
                      <th>Keterangan</th>
                      <th>Qty Dikirim</th>
                      <th>Unit</th>
                      <th>Harga Unit</th>
                      <th>Diskon</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <hr class="mt-5 mb-5">

          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="deskripsi">Deskripsi Pesanan</label>
                <textarea class="form-control" id="deskripsi" rows="2" readonly><?= $data_form['deskripsi'] ?></textarea>
              </div>
            </div>
            <div class="col-3 my-auto d-flex justify-content-center">
              <div class="form-check">
                <input type="hidden" value="<?= $data_form['is_uang_muka'] ?>" id="is_uang_muka_enabled" name="is_uang_muka_enabled">
                <input class="form-check-input" type="checkbox" value="yes" <?php if ($data_form['is_uang_muka'] == 1) echo 'checked'; ?> disabled>
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
                        <input type="text" class="form-control input_harga" name="subtotal_overall" id="subtotal_overall" value="0" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h6>Diskon</h6>
                    </td>
                    <td>
                      <div class="form-group mx-auto" style="width: 50%">
                        <input type="text" class="form-control input_diskon" name="diskon_overall" id="diskon_overall" value="<?= $data_form['diskon_overall'] ?>" readonly>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="jumlah_diskon_overall" id="jumlah_diskon_overall" value="0" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <h6>Biaya Pengiriman</h6>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" id="biaya_pengiriman" name="biaya_pengiriman" value="0" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <h6>Total Biaya</h6>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" class="form-control input_harga" name="total_biaya" id="total_biaya" value="0" readonly>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <a href="<?= base_url('Pembelian/PenerimaanBarang'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <div href="<?= base_url('Penjualan/FakturPenjualan/hapusFakturPenjualan/' . $data_form['id_faktur']) ?>" id="btn-delete" class="btn btn-danger btn-icon-split btn-lg ml-3" style="cursor: pointer">
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