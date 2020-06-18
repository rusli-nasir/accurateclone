<?php
foreach ($model as $x) {
?>

  <tr>
    <td></td>
    <td><?= $x['nama']; ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Daftar/JasaPengiriman/editJasaPengiriman/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>