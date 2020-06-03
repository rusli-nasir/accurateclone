<tr id="row_harga_id_<?= $model['id_harga'] ?>" class="add-new">
  <td>
    <?= $model['kode_barang'] ?>
  </td>
  <td>
    <?= $model['keterangan'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="hidden" value="<?= $model['id_barang'] ?>" name="id_barang[<?= $model['id_harga'] ?>]">
      <input type="text" class="form-control input_harga" name="harga1[<?= $model['id_harga'] ?>]" value="<?= $model['harga1'] ?>">
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_harga" name="harga2[<?= $model['id_harga'] ?>]" value="<?= $model['harga2'] ?>">
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control input_harga" name="harga3[<?= $model['id_harga'] ?>]" value="<?= $model['harga3'] ?>">
    </div>
  </td>
  <td class="edit-column text-center">
    <div class="btn-hapus-row-data-harga" data-id="<?= $model['id_harga'] ?>" data-toggle="<?= $model['id_barang'] ?>">
      <i class="fas fa-trash"></i>
    </div>
  </td>
</tr>