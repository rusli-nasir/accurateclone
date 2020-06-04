<?php
foreach ($barang_per_gudang as $barang) {
?>
  <tr>
    <td><?= $barang['kode_barang'] ?></td>
    <td><?= $barang['keterangan'] ?></td>
    <?php
    $stok_per_gudang = $barang['stok_per_gudang'];
    foreach ($list_gudang as $gudang) {
      foreach ($stok_per_gudang as $key => $val) {
        if ($key == $gudang['nama_gudang']) {
    ?>
          <td><?= $val ?></td>
    <?php
        }
      }
    }
    ?>
  </tr>

<?php
}
?>