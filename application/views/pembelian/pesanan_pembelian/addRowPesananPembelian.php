<tr id="row_barang_id_<?= $model['id'] ?>" data-id="<?= $model['id'] ?>" class="add-new row_barang_added">
  <td>
    <?= $model['kode_barang'] ?>
  </td>
  <td>
    <?= $model['keterangan'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="hidden" value="<?= $model['id'] ?>" name="insert_id_barang[<?= $model['id'] ?>]">
      <input type="text" class="form-control input_qty" id="qty_beli_<?= $model['id'] ?>" name="insert_qty_beli[<?= $model['id'] ?>]">
      <span class="text-danger hide-any" id="error-qty-beli-kosong-<?= $model['id'] ?>">*Qty Beli tidak boleh kosong</span>
    </div>
  </td>
  <td>
    <?= $model['unit'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_harga" id="harga_unit_<?= $model['id'] ?>" name="insert_harga_unit[<?= $model['id'] ?>]">
      <span class="text-danger hide-any" id="error-harga-unit-kosong-<?= $model['id'] ?>">*Harga unit tidak boleh kosong</span>
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_diskon" id="diskon_<?= $model['id'] ?>" name="insert_diskon[<?= $model['id'] ?>]">
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_harga" id="subtotal_<?= $model['id'] ?>" name="insert_subtotal[<?= $model['id'] ?>]" readonly>
    </div>
  </td>
  <td class="edit-column text-center">
    <div class="btn-hapus-row-barang" data-id="<?= $model['id'] ?>">
      <i class="fas fa-trash"></i>
    </div>
  </td>
</tr>