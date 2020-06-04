<?php
foreach ($model as $x) {
?>

  <tr>
    <input type="hidden" id="is_added_<?= $x['id'] ?>" value="0" class="count_added">
    <td><?= $x['kode_barang']; ?></td>
    <td><?= $x['keterangan']; ?></td>
    <td class="edit-column text-center">
      <div class="btn-tambah-list-barang" data-id="<?= $x['id'] ?>">
        <i class="fas fa-plus" id="icon-plus-id-<?= $x['id'] ?>"></i>
        <i class="fas fa-check hide-any" id="icon-check-id-<?= $x['id'] ?>"></i>
      </div>
    </td>
  </tr>

<?php
}
?>