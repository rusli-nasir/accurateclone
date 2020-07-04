<?php
foreach ($model as $x) {
?>
  <tr>
    <td><?= $x['no_faktur'] ?></td>
    <td><?= $x['tanggal'] ?></td>
    <td><?= $x['no_pengiriman'] ?></td>
    <td><?= $x['nama_pelanggan'] ?></td>
    <td><?= 'Rp ' . number_format($x['total_biaya'], 0, ".", ".") ?></td>
    <td><?= 'Rp ' . number_format(0, 0, ".", ".") ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Penjualan/FakturPenjualan/editFakturPenjualan/') . $x['id_faktur']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>