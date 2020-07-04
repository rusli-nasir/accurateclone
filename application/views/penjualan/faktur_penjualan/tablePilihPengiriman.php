<?php
foreach ($model as $x) {
?>

  <tr>
    <td>
      <input type="hidden" id="is_added_<?= $x['id_pengiriman'] ?>" value="0" class="count_added">
      <?= $x['no']; ?>
    </td>
    <td><?= $x['tanggal']; ?></td>
    <td class="edit-column text-center">
      <input class="ml-0 mr-2 check-add-barang-pesanan" type="radio" value="<?= $x['id_pengiriman'] ?>" data-no-pesanan="<?= $x['no']; ?>" name="add_pengiriman" id="add_pesanan_<?= $x['id_pengiriman'] ?>">
    </td>
  </tr>

<?php
}
?>