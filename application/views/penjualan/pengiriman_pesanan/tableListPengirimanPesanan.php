<?php
foreach ($model as $x) {
?>
  <tr>
    <td><?= $x['no'] ?></td>
    <td><?= $x['tanggal'] ?></td>
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