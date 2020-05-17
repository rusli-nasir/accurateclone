<?php
$i = 1;
foreach ($model as $x) {
?>

  <tr>
    <td><?= $x['nama_gudang']; ?></td>
    <td><?= $x['keterangan']; ?></td>
    <td><?= $x['penanggung_jawab']; ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Persediaan/DaftarGudang/editGudang/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
  $i++;
}
?>