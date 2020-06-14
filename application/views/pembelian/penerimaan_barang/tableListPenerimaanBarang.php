<?php
foreach ($model as $x) {
?>
  <tr>
    <td><?= $x['no_pesanan'] ?></td>
    <td><?= $x['tanggal'] ?></td>
    <td><?= $x['nama_pemasok'] ?></td>
    <td><?= $x['deskripsi'] ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Pembelian/PenerimaanBarang/editPenerimaanBarang/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>