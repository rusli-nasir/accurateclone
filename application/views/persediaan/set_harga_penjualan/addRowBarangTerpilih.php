<tr id="row_barang_terpilih_<?= $model['id_barang'] ?>" class="add-new">
  <td>
    <?= $model['kode_barang'] ?>
  </td>
  <td>
    <?= $model['keterangan'] ?>
  </td>
  <td>
    <div class="form-group">
      <input type="hidden" value="<?= $model['id_barang'] ?>" name="insert_id_barang[<?= $model['id_barang'] ?>]">
      <input type="text" class="form-control input_harga" name="insert_harga_jual[<?= $model['id_barang'] ?>]" value="<?= $model['harga_jual'] ?>">
    </div>
  </td>
  <td class="edit-column text-center">
    <div class="btn-hapus-row-data-harga" data-id="<?= $model['id_barang'] ?>" data-toggle="<?= $model['id_barang'] ?>">
      <i class="fas fa-trash"></i>
    </div>
  </td>
</tr>