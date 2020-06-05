<?php
$i = 0;
foreach ($model as $x) {
  // var_dump($x);
?>
  <tr id="row_barang_any_before_id_<?= $x['id'] ?>" class="row-any-before count-added">
    <td>
      <?= $x['kode_barang'] ?>
    </td>
    <td>
      <?= $x['keterangan'] ?>
    </td>
    <td>
      <div class="form-group">
        <input type="text" class="form-control" id="qty_actual_<?= $x['id'] ?>" value="<?= $x['stok_sekarang'] ?>" readonly>
      </div>
    </td>
    <td>
      <div class="form-group">
        <?php
        $j = 0;
        foreach ($list_id_stok as $id_stok) {
          if ($x['id'] == $id_stok['id_barang']) {
        ?>
            <input type="hidden" value="<?= $id_stok['id_stok'] ?>" name="update_id_stok[<?= $id_stok['id_barang'] ?>][<?= $j ?>]">
        <?php
            $j++;
          }
        } ?>
        <input type="hidden" value="<?= $x['id'] ?>" name="update_id_barang[<?= $x['id'] ?>]">
        <input type="text" class="form-control input_qty_pindah" id="update_qty_pindah_<?= $x['id'] ?>" name="update_qty_pindah[<?= $x['id'] ?>]" data-id="<?= $x['id'] ?>" value="<?= $x['jumlah_pindah'] ?>">
        <span class="text-danger hide-any" id="error_input_qty_pindah_kosong_<?= $x['id'] ?>">*Jumlah tidak boleh kosong / harus lebih dari 0.</span>
        <span class="text-danger hide-any" id="error_input_qty_pindah_lebih_<?= $x['id'] ?>">*Jumlah dipindah tidak boleh lebih dari stok sekarang.</span>
      </div>
    </td>
    <td class="edit-column text-center">
      <div class="btn-hapus-row-barang" data-id="<?= $x['id'] ?>" data-is-update="yes">
        <i class="fas fa-trash"></i>
      </div>
    </td>
  </tr>
<?php
  $i++;
}
?>