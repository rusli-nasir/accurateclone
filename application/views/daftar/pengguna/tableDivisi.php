<?php
$i = 1;
foreach ($model as $x) {
?>

  <tr>
    <td><?= $i; ?></td>
    <td><?= $x['nama']; ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Daftar/Pengguna/editDivisi/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
  $i++;
}
?>