<tr id="row_barang_id_<?= $model['id'] ?>" class="add-new count-added">
  <td>
    <?= $model['kode_barang'] ?>
  </td>
  <td>
    <?= $model['keterangan'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control" id="qty_actual_<?= $model['id'] ?>" name="insert_qty_actual[<?= $model['id'] ?>]" readonly>
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="hidden" value="<?= $model['id'] ?>" name="insert_id_barang[<?= $model['id'] ?>]">
      <input type="text" class="form-control input_qty_pindah" name="insert_qty_pindah[<?= $model['id'] ?>]" data-id="<?= $model['id'] ?>">
      <span class="text-danger hide-any" id="error_input_qty_pindah_kosong_<?= $model['id'] ?>">*Jumlah tidak boleh kosong / harus lebih dari 0.</span>
      <span class="text-danger hide-any" id="error_input_qty_pindah_lebih_<?= $model['id'] ?>">*Jumlah dipindah tidak boleh lebih dari stok sekarang.</span>
    </div>
  </td>
  <td class="edit-column text-center">
    <div class="btn-hapus-row-barang" data-id="<?= $model['id'] ?>">
      <i class="fas fa-trash"></i>
    </div>
  </td>
</tr>