<!-- <?php
      echo '$data_form';
      var_dump($data_form);
      echo '$data_dp_faktur';
      var_dump($data_dp_faktur);
      ?> -->
<div class="row">
  <div class="col-12">
    <h4 class="mb-3">Edit Faktur Pembelian</h4>
    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-search"></i>
      </span>
      <span class="text">tes</span>
    </button> -->
    <form id="form" action="<?= base_url('Pembelian/FakturPembelian/editFakturPembelian/' . $data_form['id_faktur']) ?>" method="post">

      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-8">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="supplier_id">Supplier</label>
                    <input type="text" class="form-control" value="<?= $data_form['nama_pemasok'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">Alamat Supplier</label>
                    <textarea class="form-control" rows="2" readonly><?= $data_form['alamat_pemasok'] ?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="tanggal">Kode Invoice</label>
                    <input type="hidden" name="id_faktur_pembelian" value="<?= $data_form['id_faktur'] ?>">
                    <input type="text" class="form-control" value="<?= $data_form['no_invoice'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="tanggal">Kode Pesanan</label>
                    <input type="text" class="form-control" value="<?= $data_form['no_pesanan'] ?>" readonly>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="tanggal">Tanggal Invoice</label>
                    <input type="text" class="form-control" value="<?= $data_form['tanggal_faktur'] ?>" name="tanggal_faktur" id="tanggal-faktur" readonly>
                  </div>
                  <div class="form-group">
                    <label for="tanggal">Tanggal Pembelian</label>
                    <input type="text" class="form-control" value="<?= $data_form['tanggal_pesanan'] ?>" readonly>
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

          <?php if ($data_form['is_row_dp'] == 0) { ?>
            <div class="table-responsive view-faktur" id="view_list_barang">
              <table class="table table-bordered" id="tableListPembelian" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th style="width: 10%;">Kd Barang</th>
                    <!-- 10 -->
                    <th style="width: 15%;">Keterangan</th>
                    <!-- 25 -->
                    <th style="width: 10%;">Qty Beli</th>
                    <!-- 33 -->
                    <th style="width: 10%;">Qty Terima</th>
                    <!-- 41 -->
                    <th style="width: 5%;">Unit</th>
                    <!-- 46 -->
                    <th style="width: 14%;">Harga Unit</th>
                    <!-- 56 -->
                    <th style="width: 5%;">Disc</th>
                    <!-- 61 -->
                    <th style="width: 15%;">Subtotal</th>
                    <!-- 71 -->
                    <th style="width: 16%;">Gudang</th>
                    <!-- 81 -->
                  </tr>
                </thead>
                <tbody>
                  <?php $this->load->view('pembelian/faktur_pembelian/listRowBarangForEditFaktur', array('list_barang_faktur' => $list_barang_faktur, 'gudang' => $gudang)); // Load file view.php dan kirim data siswanya 
                  ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
          <?php if ($data_form['is_uang_muka'] == 1) { ?>
            <div id="view_dp" class="view-faktur <?php if ($data_form['is_row_dp'] == 0) echo 'hide-any'; ?>">
              <h6 class="text-center"><strong>Untuk edit data DP melalui fitur Pesanan Pembelian sesuai dengan No Pesanan</strong></h6>
              <div class="table-responsive">
                <table class="table table-bordered" id="tableListPembelian" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Deskripsi</th>
                      <th>Jumlah DP</th>
                      <th>DP Untuk Pesanan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?= $data_dp_faktur['deskripsi'] ?></td>
                      <td>
                        <?= 'Rp ' . number_format($data_dp_faktur['jumlah_dp'], 0, ".", ".") ?>
                      </td>
                      <td><?= $data_form['no_pesanan'] ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } ?>

          <hr class="mt-5 mb-5">

          <?php if ($data_form['is_row_dp'] == 0) { ?>
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label for="deskripsi">Deskripsi</label>
                  <textarea class="form-control" rows="2" readonly><?= $data_form['deskripsi'] ?></textarea>
                </div>
                <div class="form-group">
                  <label for="tanggal">Pengiriman Via</label>
                  <input type="text" class="form-control" value="<?= $data_form['pengiriman_via'] ?>" readonly>
                </div>
              </div>
              <div class="col-3 my-auto d-flex justify-content-center">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="yes" id="is_uang_muka_enabled" <?php if ($data_form['is_uang_muka'] == "1") echo 'checked'; ?> disabled>
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
                          <input type="text" class="form-control input_harga" value="<?= 'Rp ' . number_format($data_form['subtotal_overall'], 0, ".", ".") ?>" readonly>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h6>Diskon</h6>
                      </td>
                      <td>
                        <div class="form-group mx-auto" style="width: 50%">
                          <input type="text" class="form-control input_diskon" value="<?= number_format($data_form['diskon_overall'], 0, ".", ".") . '%' ?>" readonly>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control input_harga" value="<?= 'Rp ' . number_format($data_form['jumlah_diskon_overall'], 0, ".", ".") ?>" readonly>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h6>PPN 10%</h6>
                      </td>
                      <td>
                        <div class="d-flex justify-content-center">
                          <?php
                          $total_ppn = (int) $data_form['pajak_ppn'];
                          if ($total_ppn > 0) {
                          ?>
                            <input class="ml-0 mr-2" type="checkbox" value="yes" checked disabled>
                          <?php } else { ?>
                            <input class="ml-0 mr-2" type="checkbox" value="yes" disabled>
                          <?php } ?>
                          <span>Hitung PPN?</span>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control input_harga" value="<?= 'Rp ' . number_format($data_form['pajak_ppn'], 0, ".", ".") ?>" readonly>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <h6>Biaya Pengiriman</h6>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control input_harga" value="<?= 'Rp ' . number_format($data_form['biaya_pengiriman'], 0, ".", ".") ?>" readonly>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <h6>Total Biaya</h6>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="hidden" name="nilai_faktur" value="<?= $data_form['total_biaya'] ?>">
                          <input type="text" class="form-control input_harga" value="<?= 'Rp ' . number_format($data_form['total_biaya'], 0, ".", ".") ?>" readonly>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } else { ?>
            <div class="row d-flex flex-row-reverse">
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
                        <h6>Total Biaya</h6>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control input_harga" value="<?= 'Rp ' . number_format($data_dp_faktur['jumlah_dp'], 0, ".", ".") ?>" readonly>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } ?>

          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <?php if ($data_form['is_row_dp'] == 0) { ?>
              <a href="<?= base_url('Pembelian/FakturPembelian'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
                <span class="icon text-white-50">
                  <i class="fas fa-exclamation-triangle"></i>
                </span>
                <span class="text">Cancel</span>
              </a>
              <div href="<?= base_url('Pembelian/FakturPembelian/hapusFakturPembelian/' . $data_form['id_faktur']) ?>" id="btn-delete" class="btn btn-danger btn-icon-split btn-lg ml-3" style="cursor: pointer">
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
            <?php } else { ?>
              <a href="<?= base_url('Pembelian/FakturPembelian'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
                <span class="icon text-white-50">
                  <i class="fas fa-exclamation-triangle"></i>
                </span>
                <span class="text">Cancel</span>
              </a>
            <?php } ?>
          </div>

        </div>
      </div>

    </form>
  </div>
</div>