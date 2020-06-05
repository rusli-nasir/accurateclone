<?php
function checkAdded($id_barang, $temp_added)
{
  $is_added = false;
  foreach ($temp_added as $y) {
    if ($id_barang == $y['id'])
      $is_added = true;
  }
  return $is_added;
}

// function getIdStok($id_barang, $temp_added)
// {
//   $id_stok = 0;
//   foreach ($temp_added as $y) {
//     if ($id_barang == $y['id_barang'])
//       $id_stok = $y['id_stok'];
//   }
//   return $id_stok;
// }

foreach ($model as $x) {
?>

  <tr>
    <!-- <?= $x['id'] ?> -->
    <?php if (checkAdded($x['id'], $added)) { ?>
      <input type="hidden" id="is_added_<?= $x['id'] ?>" value="1" class="count_added">
    <?php } else { ?>
      <input type="hidden" id="is_added_<?= $x['id'] ?>" value="0" class="count_added">
    <?php } ?>
    <td>
      <input type="hidden" id="stok_aktual_<?= $x['id'] ?>" value="<?= $x['total_stok_all'] ?>">
      <?= $x['kode_barang']; ?>
    </td>
    <td><?= $x['keterangan']; ?></td>
    <td><?= $x['stok'] ?></td>
    <td class="edit-column text-center">
      <?php if (checkAdded($x['id'], $added)) { ?>
        <div class="btn-tambah-list-barang" data-id="<?= $x['id'] ?>">
        <?php } else { ?>
          <div class="btn-tambah-list-barang" data-id="<?= $x['id'] ?>">
          <?php } ?>
          <?php if (checkAdded($x['id'], $added)) { ?>
            <i class="fas fa-plus hide-any" id="icon-plus-id-<?= $x['id'] ?>"></i>
            <i class="fas fa-check" id="icon-check-id-<?= $x['id'] ?>"></i>
          <?php } else { ?>
            <i class="fas fa-plus" id="icon-plus-id-<?= $x['id'] ?>"></i>
            <i class="fas fa-check hide-any" id="icon-check-id-<?= $x['id'] ?>"></i>
          <?php } ?>
          </div>
    </td>
  </tr>

<?php
}
?>