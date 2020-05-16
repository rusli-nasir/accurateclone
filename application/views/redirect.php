<div class="row d-flex justify-content-around" style="max-width: 600px;margin:0 auto;">

  <?php
  foreach ($list_fitur as $fitur) {
  ?>
    <div class="col-lg-4 mb-3">
      <a class="card-redirect-link" href="<?= base_url($fitur['link_menu'] . '/' . $fitur['link_fitur']); ?>">
        <div class="card card-redirect">
          <div class="card-body text-center">
            <img src="<?= base_url('assets/img/' . $fitur['icon']); ?>" class="card-redirect-img">
            <?= $fitur['nama_fitur']; ?>
          </div>
        </div>
      </a>
    </div>
  <?php } ?>

</div>