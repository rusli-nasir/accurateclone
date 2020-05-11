<div class="row">
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 text-primary h5">Pilih Toko Untuk Membuka Kasir</h6>
      </div>
      <div class="card-body buka-kasir-toko">
        <?php
        foreach ($model as $toko) {
          if ($toko['id'] != 1) {
            ?>
            <div class="card buka-kasir-toko-card">
              <div class="card-body">
                <h5 class="card-title">Toko <?= $toko['nama']; ?></h5>
                <p><?= $toko['alamat']; ?></p>
                <p class="text-center my-0">
                  <a href="<?= base_url('Kasir/admin/'); ?><?= $toko['id']; ?>" class="load-link btn btn-primary btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                      <i class="fas fa-door-open"></i>
                    </span>
                    <span class="text">Buka</span>
                  </a>
                </p>
              </div>
            </div>
        <?php }
        } ?>
      </div>
    </div>
  </div>
</div>