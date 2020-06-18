<?php
foreach ($model as $x) {
?>
  <tr>
    <td><?= $x['no_faktur'] ?></td>
    <td><?= $x['tanggal'] ?></td>
    <td><?= $x['no_pesanan'] ?></td>
    <td><?= $x['nama_pemasok'] ?></td>
    <td>
      <?= 'Rp ' . number_format($x['nilai_faktur'], 0, ".", ".") ?>
    </td>
    <td>
      <?= 'Rp ' . number_format($x['uang_muka'], 0, ".", ".") ?>
    </td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Pembelian/FakturPembelian/editFakturPembelian/') . $x['id_faktur']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>