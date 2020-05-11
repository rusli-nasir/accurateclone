<?php
if ($inv === null) { ?>
  asuuu
  <?php } else {
    $no = 1;
    foreach ($inv as $data) {
      ?>
    <tr>
      <td><?= $no; ?></td>
      <td class="d-flex align-items-center">
        <?php
            if ($data['foto'] == "")
              $tempFoto = "noimage.png";
            else
              $tempFoto = $data['foto'];
            ?>
        <div class="display-foto-produk"><img src="<?= base_url('upload/produk/') . $tempFoto; ?>"></div>
        <a href="<?= base_url('Inventory/editInventory/'); ?><?= $data['id_inv'] . '/'; ?><?= $toko_id; ?>"><?= $data['nama_produk']; ?></a>
      </td>
      <td valign="center"><?= $data['sku']; ?></td>
      <td><?= $data['tersedia']; ?></td>
      <td><?= $data['minimal']; ?></td>
      <td><?= $data['nama_toko']; ?></td>
    </tr>
<?php $no++;
  }
} ?>