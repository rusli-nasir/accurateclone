<?php
function getRandomRowId()
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($permitted_chars), 0, 10);
}

foreach ($list_barang as $barang) {
  $random_row_id = getRandomRowId();
?>
  <tr id="row_barang_<?= $random_row_id ?>" data-row-id="<?= $random_row_id ?>" class="row_barang_added">
    <td>
      <?= $barang['kode_barang'] ?>
    </td>
    <td>
      <?= $barang['keterangan'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_qty" id="qty_terkirim_<?= $random_row_id ?>" value="<?= $barang['qty_terkirim'] ?>" readonly>
      </div>
    </td>
    <td>
      <?= $barang['unit'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_harga" id="harga_unit_<?= $random_row_id ?>" value="<?= $barang['harga_unit'] ?>" readonly>
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_diskon" id="diskon_<?= $random_row_id ?>" value="<?= $barang['diskon'] ?>" readonly>
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_harga" id="subtotal_<?= $random_row_id ?>" value="<?= $barang['subtotal'] ?>" readonly>
      </div>
    </td>
  </tr>
<?php } ?>