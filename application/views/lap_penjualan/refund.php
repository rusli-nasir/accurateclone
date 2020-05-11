<input type="hidden" id="invoice-id" value="<?= $inv['inv_id']; ?>">
<div class="row">
  <div class="col-12 col-lg-9 mx-auto">
    <div class="card">
      <div class="card-header">
        Proses Refund <?= $inv['kode_invoice']; ?>
      </div>
      <div class="card-body">
        <h6>Data Invoice :</h6>

        <div class="mt-4 mb-3 d-flex justify-content-between w-100 d-block">

          <div>
            <div class="mb-1">Nama Customer : <?= $inv['c_nama'] ?></div>
            <div class="mb-1">
              Kontak Customer : <?php if (!empty($inv['email'])) echo $inv['email'];
                                else echo $inv['cp']; ?>
            </div class="mb-1">
            <div>Metode Pembayaran : <?= $inv['jenis_pembayaran'] ?></div>
          </div>

          <div>
            <div class="mb-1">Dibuat : <?= date('j F Y H:i', $inv['time']); ?></div>
            <div class="mb-1">
              Kontak Customer : <?= $inv['k_nama'] ?>
            </div class="mb-1">
            <div>Toko : <?= $inv['t_nama'] ?></div>
          </div>

        </div>

        <table class="table mt-5" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Dikembalikan</th>
              <th>SKU</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Diskon</th>
              <th>Subtotal</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="data-table-barang">
            <?php foreach ($brg as $x) { ?>
              <tr class="barang-row" rel="<?= $x['id']; ?>">
                <input type="text" id="input_id_barang<?= $x['id']; ?>" value="<?= $x['id']; ?>">
                <input type="text" id="input_jml_kembali<?= $x['id']; ?>" value="0">
                <input type="text" id="bk_harga<?= $x['id']; ?>" value="<?= $x['harga']; ?>">
                <input type="text" id="bk_jml_terbeli<?= $x['id']; ?>" value="<?= $x['qty']; ?>">
                <input type="text" id="bk_diskon<?= $x['id']; ?>" value="<?= $x['diskon']; ?>">
                <input type="text" id="bk_subtotal<?= $x['id']; ?>" value="<?= $x['subtotal']; ?>">
                <td>
                  <label class="checkbox">
                    <input type="checkbox" class="check-to-refund" rel="<?= $x['id']; ?>">
                    <span class="checkbox__icon"></span>
                    <strong><span class="text-danger"><span id="jml_kembali<?= $x['id']; ?>">0</span> pcs</span></strong>
                  </label>
                </td>
                <td><?= $x['sku']; ?></td>
                <td><?= 'Rp ' . number_format($x['harga'], 0, "", "."); ?></td>
                <td><?= $x['qty']; ?></td>
                <td><?= '-Rp ' . number_format($x['diskon'], 0, "", "."); ?></td>
                <td><?= 'Rp ' . number_format($x['subtotal'], 0, "", "."); ?></td>
                <td class="text-center">
                  <?php if ($x['status'] == 0) { ?>
                    <span class="badge badge-pill badge-success">Sukses</span>
                  <?php } else if ($x['status'] == 1) { ?>
                    <span class="badge badge-pill badge-warning">Refund Sebagian</span>
                  <?php } else { ?>
                    <span class="badge badge-pill badge-danger">Refund</span>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
            <tr>
              <td>
                <label class="checkbox">
                  <input type="checkbox" id="check-all-refund" value="all">
                  <span class="checkbox__icon"></span>
                  <strong><span class="text-danger">Kembalikan Semua</strong>
                </label>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="text-center mb-3">
          <h6 class="h5"><strong>Dikembalikan</strong></h6>
          <h6 class="h5 text-danger"><strong><span id="disp-total-kembali">0</span> pcs <span id="is-all-kembali"></span></strong></h6>
        </div>
        <div class="text-center mb-4">
          <h6 class="h5"><strong>Uang Dikembalikan</strong></h6>
          <h6 class="h1 text-danger"><strong>Rp <span id="disp-uang-kembali">0</span></strong></h6>
        </div>

        <div class="text-center">
          <button type="button" id="btn-refund-proses" class="btn btn-danger btn-icon-split btn-lg mb-3">
            <span class="icon text-white-50">
              <i class="fas fa-archive"></i>
            </span>
            <span class="text">Refund</span>
          </button>
          <a href="<?= base_url('LapPenjualan'); ?>" id="btn-refund-cancel-all" class="btn btn-warning btn-icon-split btn-lg mb-3">
            <span class="icon text-white-50">
              <i class="fas fa-times"></i>
            </span>
            <span class="text">Cancel</span>
          </a>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="modal-refund" class="custom-modal hide-any">

  <!-- Modal content -->
  <div class="custom-modal-content bg-gray-200 modal-content-refund">
    <div class="custom-modal-header mb-4">
      <span class="judul-modal-header" style="width: 100%">Jumlah Dikembalikan</span>
      <span id="btn-close" class="close"><i class="fas fa-times-circle"></i></span>
    </div>
    <div class="custom-modal-body mb-4">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div>
                <input type="hidden" id="id-barang-modal" value="">
                <div class="mb-1"><strong>SKU : 211</strong></div>
                <input type="hidden" id="jml-terbeli" value="">
                <div class="mb-4"><strong>Jumlah Terbeli : <span class="text-danger" id="disp-jml-terbeli">2</span></strong></div>
              </div>
              <div class="form-group">
                <label for="jumlah_kembali">Jumlah Yang Dikembalikan<span style="color: red">*</span></label>
                <input type="text" class="form-control mb-1" name="jumlah_kembali" id="jumlah_kembali" placeholder="Jumlah Yang Dikembalikan">
                <span id="error_kembali" class="text-danger"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="custom-modal-footer">
      <div class="row">
        <div class="col-12 d-flex flex-row-reverse">
          <button type="button" id="btn-refund-cancel" class="btn btn-warning btn-icon-split btn-lg">
            <span class="icon text-white-50">
              <i class="fas fa-times"></i>
            </span>
            <span class="text">Cancel</span>
          </button>
          <button type="button" id="btn-refund-ok" class="btn btn-primary btn-icon-split btn-lg mr-4">
            <span class="icon text-white-50">
              <i class="fas fa-archive"></i>
            </span>
            <span class="text">Ok</span>
          </button>
        </div>
      </div>
    </div>
  </div>

</div>