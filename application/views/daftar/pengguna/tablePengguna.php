<?php
$i = 1;
foreach ($model as $x) {
?>

  <tr>
    <td><?= $i; ?></td>
    <td><?= $x['nama']; ?></td>
    <td><?= $x['username']; ?></td>
    <td>
      <?php
      if (!empty($x['cp']))
        echo $x['cp'];
      ?>
    </td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Daftar/Pengguna/editPengguna/') . $x['username']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
  $i++;
}
?>