<?php
foreach ($model as $x) {
?>

  <tr>
    <td></td>
    <td><?= $x['nama_pelanggan']; ?></td>
    <td>
      <?php
      if (empty($x['telepon']))
        echo '-';
      else
        echo $x['telepon'];
      ?>
    </td>
    <td>
      <?php
      if (empty($x['kontak']))
        echo '-';
      else
        echo $x['kontak'];
      ?>
    </td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Daftar/Pelanggan/editPelanggan/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>