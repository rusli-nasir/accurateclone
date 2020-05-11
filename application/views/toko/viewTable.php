<?php
$no = 1;
foreach ($model as $data) {
  ?>
  <tr>
    <td class="align-middle text-center"><?= $no; ?></td>
    <td>
      <a href="#" data-id="<?= $data['id']; ?>"><?= $data['nama']; ?></a>
      <input type="hidden" class="value-nama" value="<?= $data['nama']; ?>">
      <input type="hidden" class="value-alamat" value="<?= $data['alamat']; ?>">
    </td>
    <td><?= $data['alamat']; ?></td>
  </tr>
<?php
  $no++; // Tambah 1 setiap kali looping
}
?>