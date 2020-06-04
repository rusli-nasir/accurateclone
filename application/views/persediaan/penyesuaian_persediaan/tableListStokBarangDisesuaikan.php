<?php
$i = 0;
foreach ($model as $x) {
?>
  <tr id="row_stok_any_before_id_<?= $x['id_barang'] ?>" class="row-any-before">
    <td>
      <?= $x['kode_barang'] ?>
    </td>
    <td>
      <?= $x['keterangan'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="hidden" value="<?= $x['id_stok'] ?>" name="update_id_stok[<?= $i ?>]">
        <input type="text" class="form-control input_stok" name="update_selisih_stok[<?= $i ?>]" value="<?= $x['stok'] ?>">
      </div>
    </td>
    <td>
      <div class="form-group">
        <select class="form-control" name="update_gudang[<?= $i ?>]">
          <?php
          foreach ($gudang as $y) {
          ?>
            <?php if ($x['persediaan_daftar_gudang_id'] == $y['id']) { ?>
              <option value="<?= $y['id'] ?>" selected="selected"><?= $y['nama_gudang'] ?></option>
            <?php } else { ?>
              <option value="<?= $y['id'] ?>"><?= $y['nama_gudang'] ?></option>
            <?php } ?>
          <?php
          }
          ?>
        </select>
      </div>
    </td>
    <td class="edit-column text-center">
      <div class="btn-hapus-row-stok" data-id="<?= $x['id_stok'] ?>" data-toggle="<?= $x['id_barang'] ?>" data-is-update="yes">
        <i class="fas fa-trash"></i>
      </div>
    </td>
  </tr>
<?php
  $i++;
}
?>