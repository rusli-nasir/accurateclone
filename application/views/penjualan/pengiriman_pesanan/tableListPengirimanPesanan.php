<?php
foreach ($model as $x) {
?>
  <tr>
    <td><?= $x['no'] ?></td>
    <td><?= $x['tanggal'] ?></td>
    <td>
      <?php if ($x['status'] == 1) { ?>
        <span class="badge badge-pill badge-success" style="font-size: 100%">Selesai</span>
      <?php } else { ?>
        <span class="badge badge-pill badge-warning" style="font-size: 100%">Belum Dibayar</span>
      <?php } ?>
    </td>
    <td><?= $x['nama_pelanggan'] ?></td>
    <td><?= $x['deskripsi'] ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Penjualan/PengirimanPesanan/editPengirimanPesanan/') . $x['id_pengiriman']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>