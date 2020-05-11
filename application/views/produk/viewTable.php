<?php
foreach ($model as $data) {
  ?>
  <tr>
    <td><span></span></td>
    <td class="d-flex align-items-center">
      <?php
        if ($data->foto == "")
          $tempFoto = "noimage.png";
        else
          $tempFoto = $data->foto;
        ?>
      <div class="display-foto-produk"><img src="<?= base_url('upload/produk/') . $tempFoto; ?>"></div>
      <a class="load-link" href="<?= base_url('Produk/editProduk/') .  $data->SKU; ?>"><?= $data->nama; ?></a>
    </td>
    <td><?= $data->SKU; ?></td>
    <td><?= 'Rp ' . number_format($data->harga_modal,0,".","."); ?></td>
    <td><?= 'Rp ' . number_format($data->harga_jual,0,".","."); ?></td>
    <td><?= '-Rp ' . number_format($data->diskon,0,".","."); ?></td>
    <td><?= 'Rp ' . number_format($data->profit,0,".","."); ?></td>
  </tr>
<?php
}
?>