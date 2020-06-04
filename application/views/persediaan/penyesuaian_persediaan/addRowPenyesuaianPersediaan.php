<tr id="row_stok_id_<?= $model['id'] ?>" class="add-new">
  <td>
    <?= $model['kode_barang'] ?>
  </td>
  <td>
    <?= $model['keterangan'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="hidden" value="<?= $model['id'] ?>" name="insert_id_barang[<?= $model['id'] ?>]">
      <input type="text" id="current_qty_" class="form-control input_stok" name="insert_current_qty[<?= $model['id'] ?>]" value="<?= $model['stok'] ?>" readonly>
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_stok" name="insert_new_qty[<?= $model['id'] ?>]">
    </div>
  </td>
  <td>
    <div class="form-group">
      <select class="form-control" name="insert_gudang[<?= $model['id'] ?>]">
        <?php
        foreach ($gudang as $x) {
        ?>
          <?php if ($x['id'] == $model['default_gudang_id']) { ?>
            <option value="<?= $x['id'] ?>" selected="selected"><?= $x['nama_gudang'] ?></option>
          <?php } else { ?>
            <option value="<?= $x['id'] ?>"><?= $x['nama_gudang'] ?></option>
          <?php } ?>
        <?php
        }
        ?>
      </select>
    </div>
  </td>
  <td class="edit-column text-center">
    <div class="btn-hapus-row-stok" data-id="<?= $model['id'] ?>">
      <i class="fas fa-trash"></i>
    </div>
  </td>
</tr>