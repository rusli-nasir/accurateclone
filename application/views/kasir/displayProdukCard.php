<ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
  <?php
  $count = 1;
  foreach ($kategori as $cat) {
    ?>
    <li class="nav-item">
      <a class="nav-link <?php if ($count == 1) echo 'active'; ?>" id="pills-<?= $cat['class']; ?>-tab" data-toggle="pill" href="#pills-<?= $cat['class']; ?>" role="tab" aria-controls="pills-<?= $cat['class']; ?>" aria-selected="<?php if ($count == 1) echo 'true';
                                                                                                                                                                                                                                        else 'false'; ?>"><?= $cat['nama']; ?></a>
    </li>
  <?php
    $count++;
  }
  ?>
</ul>

<div class="tab-content" id="pills-tabContent">
  <?php
  $itung = 1;
  foreach ($kategori as $cekcat) {
    ?>
    <div class="tab-pane fade <?php if ($itung == 1) echo 'show active' ?>" id="pills-<?= $cekcat['class']; ?>" role="tabpanel" aria-labelledby="pills-<?= $cekcat['class']; ?>-tab">
      <div class="container-katalog">
        <?php foreach ($produk as $pdk) { ?>
          <?php if ($cekcat['id'] == $pdk['kategori_id']) { ?>
            <div class="katalog">
              <div class="card">
                <div class="container-gambar-katalog">
                  <img class="card-img-top gambar-katalog" src="<?php if ($pdk['foto'] == "") echo base_url('upload/produk/') . 'noimage.png';
                                                                      else echo base_url('upload/produk/') . $pdk['foto']; ?>">
                  <?php if ($pdk['diskon'] != 0) { ?>
                    <div class="diskon-katalog font-weight-bold">
                      <?php
                              $diskon = $pdk['diskon'];
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
                  <p class="card-text text-center my-0"><strong><?= $pdk['sku']; ?></strong></p>
                  <p class="card-text text-center my-1"><?= $pdk['nama']; ?></p>
                  <p class="card-text text-center"><strong><?= $pdk['tersedia']; ?> pcs</strong></p>
                  <p class="card-text text-center text-primary disp-harga"><?= $pdk['harga_jual']; ?></p>
                  <p class="text-center my-0">
                    <button type="button" class="btn btn-primary btn-sm btn-beli" rel="<?= $pdk['sku']; ?>" style="margin:0 auto;">
                      <input type="hidden" class="qty-tersedia" value="<?= $pdk['tersedia']; ?>">
                      <span class="text">Beli</span>
                    </button>
                  </p>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  <?php
    $itung++;
  }
  ?>
</div>