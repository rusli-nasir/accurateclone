<?php
foreach ($model as $x) {
?>

  <tr>
    <td>
      <input type="hidden" id="is_added_<?= $x['id'] ?>" value="0" class="count_added">
      <?= $x['no']; ?>
    </td>
    <td><?= $x['tanggal']; ?></td>
    <td class="edit-column text-center">
      <input class="ml-0 mr-2 check-add-barang-pesanan" type="radio" value="<?= $x['id'] ?>" data-no-pesanan="<?= $x['no']; ?>" name="add_pesanan" id="add_pesanan_<?= $x['id'] ?>">
    </td>
  </tr>

<?php
}
?>