<?php
$i = 0;
foreach ($model as $data) {
?>
  <tr id="row_barang_id_<?= $data['id_barang_pesanan'] ?>" data-id="<?= $data['id_barang_pesanan'] ?>" class="add-new row_barang_added">
    <td>
      <div>
        <?= $data['kode_barang'] ?>
        <input type="hidden" name="id_daftar_barang[<?= $data['id_barang_pesanan'] ?>]" value="<?= $data['id_barang'] ?>">
        <span class="text-danger hide-any error-duplikat error-barang-duplikat-<?= $data['id_barang_pesanan'] ?>">*Kode Barang ini terduplikat di pesanan yang sama</span>
      </div>
    </td>
    <td>
      <?= $data['keterangan'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control" id="insert_qty_terbeli_<?= $data['id_barang_pesanan'] ?>" value="<?= $data['qty_beli'] ?>" readonly>
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="hidden" value="<?= $data['id_barang_pesanan'] ?>" name="insert_id_barang_pesanan[<?= $data['id_barang_pesanan'] ?>]">
        <input type="text" class="form-control input_qty" id="insert_qty_terima_<?= $data['id_barang_pesanan'] ?>" name="insert_qty_terima[<?= $data['id_barang_pesanan'] ?>]" value="<?= $data['qty_diterima'] ?>">
        <span class="text-danger hide-any" id="error-qty-terima-lebih-<?= $data['id_barang_pesanan'] ?>">*Qty Terima tidak boleh lebih dari Qty Dibeli</span>
      </div>
    </td>
    <td>
      <?= $data['unit'] ?>
    </td>
    <td>
      <div class="form-group">
        <select class="form-control pilih-gudang" name="insert_terima_gudang[<?= $data['id_barang_pesanan'] ?>]">
          <option value="kosong">--- Pilih Gudang ---</option>
          <?php
          foreach ($list_gudang as $x) {
          ?>
            <?php if ($this->uri->segment(1) == "Pembelian" && $this->uri->segment(2) == "PenerimaanBarang" && $this->uri->segment(3) == "editPenerimaanBarang") { ?>
              <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $data['gudang_id']) echo 'selected'; ?>><?= $x['nama_gudang'] ?></option>
            <?php } else { ?>
              <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $data['default_gudang_id']) echo 'selected'; ?>><?= $x['nama_gudang'] ?></option>
            <?php } ?>
          <?php
          }
          ?>
        </select>
      </div>
    </td>
  </tr>
<?php
  $i++;
}
?>