<?php
$i = 0;
foreach ($model as $data) {
?>
  <tr id="row_barang_any_before_id_<?= $data['id_barang'] ?>" data-id="<?= $data['id_barang'] ?>" class="add-new row_barang_added">
    <td>
      <?= $data['kode_barang'] ?>
    </td>
    <td>
      <?= $data['keterangan'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="hidden" value="<?= $data['id_barang_beli'] ?>" name="update_id_barang_beli[<?= $i ?>]">
        <input type="text" class="form-control input_qty" id="qty_beli_<?= $data['id_barang'] ?>" name="update_qty_beli[<?= $i ?>]" value="<?= $data['qty_beli'] ?>">
        <span class="text-danger hide-any" id="error-qty-beli-kosong-<?= $data['id_barang'] ?>">*Qty Beli tidak boleh kosong</span>
      </div>
    </td>
    <td>
      <?= $data['unit'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_harga" id="harga_unit_<?= $data['id_barang'] ?>" name="update_harga_unit[<?= $i ?>]" value="<?= $data['harga_unit'] ?>">
        <span class="text-danger hide-any" id="error-harga-unit-kosong-<?= $data['id_barang'] ?>">*Harga unit tidak boleh kosong</span>
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_diskon" id="diskon_<?= $data['id_barang'] ?>" name="update_diskon[<?= $i ?>]" value="<?= $data['diskon'] ?>">
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_harga" id="subtotal_<?= $data['id_barang'] ?>" name="update_subtotal[<?= $i ?>]" value="<?= $data['subtotal'] ?>" readonly>
      </div>
    </td>
    <td>
      <?= $data['qty_diterima'] ?>
    </td>
    <td class="edit-column text-center">
      <div class="btn-hapus-row-barang" data-id="<?= $data['id_barang'] ?>" data-is-update="yes">
        <i class="fas fa-trash"></i>
      </div>
    </td>
  </tr>
<?php
  $i++;
}
?>