<?php
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
$random_row_id = substr(str_shuffle($permitted_chars), 0, 10);
?>
<tr id="row_barang_<?= $random_row_id ?>" data-row-id="<?= $random_row_id ?>" class="add-new row_barang_added">
  <td>
    <input type="hidden" value="<?= $model['id'] ?>" name="insert_id_barang[<?= $random_row_id ?>]">
    <?= $model['kode_barang'] ?>
  </td>
  <td>
    <?= $model['keterangan'] ?>
  </td>
  <td>
    <input type="hidden" id="stok_terbaru_<?= $random_row_id ?>" value="<?= $model['stok_terbaru'] ?>">
    <?= $model['stok_terbaru'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_qty" id="insert_qty_jual_<?= $random_row_id ?>" name="insert_qty_jual[<?= $random_row_id ?>]">
      <span class="text-danger hide-any" id="error-qty-jual-kosong-<?= $random_row_id ?>">*Qty Jual tidak boleh kosong</span>
      <span class="text-danger hide-any" id="error-qty-jual-lebih-<?= $random_row_id ?>">*Qty Jual melebihi stok yang tersedia</span>
    </div>
  </td>
  <td>
    <?= $model['unit'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_harga" id="insert_harga_unit_<?= $random_row_id ?>" name="insert_harga_unit[<?= $random_row_id ?>]" value="<?= $model['harga_jual_terbaru'] ?>">
      <span class="text-danger hide-any" id="error-harga-unit-kosong-<?= $random_row_id ?>">*Harga unit tidak boleh kosong</span>
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_diskon" id="insert_diskon_<?= $random_row_id ?>" name="insert_diskon[<?= $random_row_id ?>]">
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_harga" id="insert_subtotal_<?= $random_row_id ?>" name="insert_subtotal[<?= $random_row_id ?>]" readonly>
    </div>
  </td>
  <td class="edit-column text-center">
    <div class="btn-hapus-row-barang" data-id="<?= $model['id'] ?>" data-row-id="<?= $random_row_id ?>">
      <i class="fas fa-trash"></i>
    </div>
  </td>
</tr>