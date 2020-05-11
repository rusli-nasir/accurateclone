<div class="row">
  <div class="col-12 col-md-8 col-lg-6 mx-auto">

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <?php if ($status == 'sukses') { ?>
          <h6 class="m-0 text-primary h5">Refund Berhasil</h6>
        <?php } else { ?>
          <h6 class="m-0 text-danger h5">Refund Gagal</h6>
        <?php } ?>
      </div>
      <div class="card-body buka-kasir-toko">
        <?php if ($status == 'sukses') { ?>
          <p>Request refund untuk Invoice <?= $inv['kode_invoice']; ?> berhasil dilakukan.</p>
          <p>Apabila sudah pernah melakukan refund, tidak bisa melakukan refund untuk kedua kali-nya!</p>
        <?php } else { ?>
          <p>Request refund untuk Invoice <?= $inv['kode_invoice']; ?> gagal.</p>
        <?php } ?>
        <a href="<?= base_url('LapPenjualan'); ?>" class="btn btn-primary btn-icon-split btn-sm load-link">
          <span class="icon text-white-50">
            <i class="fas fa-chevron-left"></i>
          </span>
          <span class="text">Kembali</span>
        </a>
      </div>
    </div>

  </div>
</div>