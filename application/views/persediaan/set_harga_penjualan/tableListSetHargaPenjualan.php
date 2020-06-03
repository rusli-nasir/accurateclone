<?php
foreach ($model as $x) {
?>
  <tr>
    <td></td>
    <td><?= $x['tanggal'] ?></td>
    <td><?= $x['keterangan'] ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Persediaan/SetHargaPenjualan/editSetHargaPenjualan/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>