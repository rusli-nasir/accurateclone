<div class="row">
  <div class="col-12 col-md-8 col-lg-6 mx-auto">

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 text-danger h5">Sudah Pernah Refund</h6>
      </div>
      <div class="card-body buka-kasir-toko">
        <p>Invoice dengan Kode Invoice <?= $inv['kode_invoice']; ?> ini sudah pernah melakukan transaksi refund.</p>
        <p>Apabila sudah pernah melakukan refund, tidak bisa melakukan refund untuk kedua kali-nya!</p>
        <a href="<?= base_url('LapPenjualan'); ?>" class="btn btn-primary btn-icon-split btn-sm">
          <span class="icon text-white-50">
            <i class="fas fa-chevron-left"></i>
          </span>
          <span class="text">Kembali</span>
        </a>
      </div>
    </div>

  </div>
</div>