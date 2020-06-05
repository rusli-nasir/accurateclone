<?php
$i = 1;
foreach ($model as $x) {
?>

  <tr>
    <td></td>
    <td><?= $x['nama_pemasok']; ?></td>
    <td><?= $x['telepon']; ?></td>
    <td><?= $x['kontak']; ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Daftar/Pemasok/editPemasok/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
  $i++;
}
?>