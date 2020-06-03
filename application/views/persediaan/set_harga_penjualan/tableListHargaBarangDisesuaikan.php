<?php
$i = 0;
foreach ($model as $x) {
?>
  <tr id="row_harga_any_before_id_<?= $x['id_harga'] ?>" class="row-any-before">
    <td>
      <?= $x['kode_barang'] ?>
    </td>
    <td>
      <?= $x['keterangan'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="hidden" value="<?= $x['id_harga'] ?>" name="update_id_harga[<?= $i ?>]">
        <!-- <input type="hidden" value="<?= $x['id_barang'] ?>" name="update_id_barang[<?= $i ?>]"> -->
        <input type="text" class="form-control input_harga" name="update_harga1[<?= $i ?>]" value="<?= $x['harga1'] ?>">
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_harga" name="update_harga2[<?= $i ?>]" value="<?= $x['harga2'] ?>">
      </div>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control input_harga" name="update_harga3[<?= $i ?>]" value="<?= $x['harga3'] ?>">
      </div>
    </td>
    <td class="edit-column text-center">
      <div class="btn-hapus-row-data-harga" data-id="<?= $x['id_harga'] ?>" data-toggle="<?= $x['id_barang'] ?>" data-is-update="yes">
        <i class="fas fa-trash"></i>
      </div>
    </td>
  </tr>
<?php
  $i++;
}
?>