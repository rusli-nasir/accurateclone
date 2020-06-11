<tr>
  <td colspan="6">
    <input type="hidden" value="<?= $kode_pesanan['id'] ?>" name="insert_kode_pesanan[<?= $kode_pesanan['id'] ?>]">
    <strong>Kode Pesanan : <?= $kode_pesanan['kode'] ?></strong>
  </td>
</tr>
<?php
$i = 0;
foreach ($model as $data) {
?>
  <tr id="row_barang_id_<?= $data['id_barang_pesanan'] ?>" data-id="<?= $data['id_barang_pesanan'] ?>" class="add-new row_barang_added">
    <td>
      <div>
        <?= $data['kode_barang'] ?>
        <span class="text-danger hide-any error-duplikat error-barang-duplikat-<?= $data['id_barang_pesanan'] ?>">*Kode Barang ini terduplikat di pesanan yang sama</span>
      </div>
    </td>
    <td>
      <?= $data['keterangan'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_qty" id="insert_qty_terbeli_<?= $data['id_barang_pesanan'] ?>" value="<?= $data['qty_beli'] ?>" readonly>
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="hidden" value="<?= $data['id_barang_pesanan'] ?>" name="insert_id_barang_pesanan[<?= $data['id_barang_pesanan'] ?>]">
        <input type="text" class="form-control input_qty" id="insert_qty_terima_<?= $data['id_barang_pesanan'] ?>" name="insert_qty_terima[<?= $data['id_barang_pesanan'] ?>]">
        <span class="text-danger hide-any" id="error-qty-terima-kosong-<?= $data['id_barang_pesanan'] ?>">*Qty Terima tidak boleh kosong</span>
        <span class="text-danger hide-any" id="error-qty-terima-lebih-<?= $data['id_barang_pesanan'] ?>">*Qty Terima tidak boleh lebih dari Qty Dibeli</span>
      </div>
    </td>
    <td>
      <?= $data['unit'] ?>
    </td>
    <td>
      <div class="form-group">
        <select class="form-control pilih-gudang" name="insert_terima_gudang_id">
          <option value="kosong">--- Pilih Gudang ---</option>
          <?php
          foreach ($list_gudang as $x) {
          ?>
            <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $data['default_gudang_id']) echo 'selected'; ?>><?= $x['nama_gudang'] ?></option>
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