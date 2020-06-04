<?php
foreach ($model as $x) {
?>
  <tr>
    <td><?= $x['kategori'] ?></td>
    <td><?= $x['kode_barang'] ?></td>
    <td><?= $x['keterangan'] ?></td>
    <td><?= $x['stok'] ?></td>
    <td><?= 'Rp ' . number_format($x['harga_jual'], 0, ".", ".") ?></td>
    <td><?= $x['tipe_barang'] ?></td>
    <td class="edit-column text-center">
      <a href="<?= base_url('Persediaan/BarangJasa/editBarangJasa/') . $x['id_barang']; ?>">
        <i class="fas fa-edit"></i>Edit
      </a>
    </td>
  </tr>

<?php
}
?>