<?php
$print = 0;
foreach ($model as $data) {
  ?>
  <tr>
    <td class="d-flex align-items-center">
      <?php
        if ($data['foto'] == "")
          $tempFoto = "noimage.png";
        else
          $tempFoto = $data['foto'];
        ?>
      <div class="display-foto-produk"><img src="<?= base_url('upload/produk/') . $tempFoto; ?>"></div>

      <a href="#" rel="<?= $data['SKU']; ?>" class="pilih-produk w-100">
        <input type="hidden" class="jumlah-produk-tersedia" value="<?php if ($status_gudang != 1) echo $data['tersedia']; ?>">
        <?= $data['SKU']; ?> / <?= $data['nama']; ?>
      </a>
      <div class="d-flex flex-column">
        <p class="my-0 text-center">Tersedia</p>
        <p class="my-0 text-center"><?php if ($status_gudang != 1) echo $data['tersedia']; ?></p>
      </div>
    </td>
  </tr>
<?php
}
?>