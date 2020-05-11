<h5 class="d-block w-100 my-3">Hasil Pencarian :</h5>

<?php
foreach ($produk as $pdkcari) {
  ?>
  <li class="katalog">
    <div class="card h-100">
      <div class="container-gambar-katalog">
        <img class="card-img-top gambar-katalog" src="<?php if ($pdkcari['foto'] == "") echo base_url('upload/produk/') . 'noimage.png';
                                                        else echo base_url('upload/produk/') . $pdkcari['foto']; ?>">
        <?php if ($pdkcari['diskon'] != 0) { ?>
          <div class="diskon-katalog font-weight-bold">
            <?php
                $diskon = $pdkcari['diskon'];
                if ($diskon > 1000) {

                  $x = round($diskon);
                  $x_number_format = number_format($x);
                  $x_array = explode(',', $x_number_format);
                  $x_parts = array('k', 'm', 'b', 't');
                  $x_count_parts = count($x_array) - 1;
                  $x_display = $x;
                  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                  $x_display .= $x_parts[$x_count_parts - 1];

                  $diskon = $x_display;
                }
                echo '- ' . $diskon;
                ?>
          </div>
        <?php } ?>
      </div>
      <div class="card-body">
        <p class="card-text text-center my-0 cari-sku"><strong><?= $pdkcari['sku']; ?></strong></p>
        <p class="card-text text-center cari-nama my-1"><?= $pdkcari['nama']; ?></p>
        <p class="card-text text-center cari-nama"><strong><?= $pdkcari['tersedia']; ?> pcs</strong></p>
        <p class="card-text text-center text-primary disp-harga"><?= $pdkcari['harga_jual']; ?></p>
        <p class="text-center my-0">
          <button type="button" class="btn btn-primary btn-sm btn-beli" rel="<?= $pdkcari['sku']; ?>" style="margin:0 auto;">
            <input type="hidden" class="qty-tersedia" value="<?= $pdkcari['tersedia']; ?>">
            <span class="text">Beli</span>
          </button>
        </p>
      </div>
    </div>
  </li>
<?php } ?>