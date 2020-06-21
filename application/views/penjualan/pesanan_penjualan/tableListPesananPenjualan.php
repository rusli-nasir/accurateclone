<?php
foreach ($model as $x) {
?>
  <tr>
    <td><?= $x['no'] ?></td>
    <td><?= $x['tanggal_penjualan'] ?></td>
    <td>
      <?php if ($x['status'] == 1) { ?>
        <span class="badge badge-pill badge-success" style="font-size: 100%">Selesai</span>
      <?php } else { ?>
        <span class="badge badge-pill badge-warning" style="font-size: 100%">Sdg Proses</span>
      <?php } ?>
    </td>
    <td><?= $x['nama_pelanggan'] ?></td>
    <td>
      <?= 'Rp ' . number_format(0, 0, ".", ".") ?>
    </td>
    <td><?= 'Rp ' . number_format($x['total_biaya'], 0, ".", ".") ?></td>
    <td><?= $x['deskripsi'] ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Penjualan/PesananPenjualan/editPesananPenjualan/') . $x['id']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>