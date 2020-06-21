<?php
function getRandomRowId()
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($permitted_chars), 0, 10);
}

foreach ($list_barang as $barang) {
  $random_row_id = getRandomRowId();
?>
  <tr id="row_barang_<?= $random_row_id ?>" data-row-id="<?= $random_row_id ?>" data-is-any-before="yes" class="row_barang_added">
    <td>
      <input type="hidden" value="<?= $barang['id_barang_pesanan'] ?>" name="update_id_barang_pesanan[<?= $random_row_id ?>]">
      <input type="hidden" id="is_delete_<?= $random_row_id ?>" name="update_is_delete[<?= $random_row_id ?>]" value="0">
      <?= $barang['kode_barang'] ?>
    </td>
    <td>
      <?= $barang['keterangan'] ?>
    </td>
    <td>
      <input type="hidden" id="stok_terbaru_<?= $random_row_id ?>" value="<?= $barang['stok_terbaru'] ?>">
      <?= $barang['stok_terbaru'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_qty" id="update_qty_jual_<?= $random_row_id ?>" name="update_qty_jual[<?= $random_row_id ?>]" value="<?= $barang['qty_jual'] ?>">
        <span class="text-danger hide-any" id="error-qty-jual-kosong-<?= $random_row_id ?>">*Qty Jual tidak boleh kosong</span>
        <span class="text-danger hide-any" id="error-qty-jual-lebih-<?= $random_row_id ?>">*Qty Jual melebihi stok yang tersedia</span>
      </div>
    </td>
    <td>
      <?= $barang['unit'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_harga" id="update_harga_unit_<?= $random_row_id ?>" name="update_harga_unit[<?= $random_row_id ?>]" value="<?= $barang['harga_unit'] ?>">
        <span class="text-danger hide-any" id="error-harga-unit-kosong-<?= $random_row_id ?>">*Harga unit tidak boleh kosong</span>
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_diskon" id="update_diskon_<?= $random_row_id ?>" name="update_diskon[<?= $random_row_id ?>]" value="<?= $barang['diskon'] ?>">
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_harga" id="update_subtotal_<?= $random_row_id ?>" name="update_subtotal[<?= $random_row_id ?>]" value="<?= $barang['subtotal'] ?>" readonly>
      </div>
    </td>
    <td><?= $barang['qty_terkirim'] ?></td>
    <td class="edit-column text-center">
      <div class="btn-hapus-row-barang" data-row-id="<?= $random_row_id ?>" data-is-any-before="yes" data-id-barang-pesanan="<?= $barang['id_barang_pesanan'] ?>">
        <i class="fas fa-trash"></i>
      </div>
    </td>
  </tr>
<?php } ?>