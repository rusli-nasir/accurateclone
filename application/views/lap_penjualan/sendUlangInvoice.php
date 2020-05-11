<div class="row">
  <div class="col-12 col-md-8 col-lg-6 mx-auto">

    <?= $this->session->flashdata('pesanResendInvoice'); ?>

    <form action="" method="post" id="form-resend-invoice">

      <div class="card">
        <div class="card-header">
          Kirim Ulang Invoice <?= $kd_inv; ?> ke Customer
        </div>
        <div class="card-body text-center">
          <input type="hidden" id="contact-mode" value="<?= $mode; ?>">

          <h6>Nama Customer :</h6>
          <input type="text" value="<?= $cust['nama']; ?>" class="form-control mb-3" id="input_nama" name="input_nama" placeholder="Nama" style="width:70%;display:block;margin: 0 auto;">
          <?php echo form_error('input_nama', '<div class="text-danger mb-4">', '</div>'); ?>

          <div class="d-flex justify-content-around mx-auto mt-4 mb-1" style="width:70%;display:block;">
            <input type="hidden" id="input_mode" name="input_mode" value="<?php if ($mode == 'email') echo 'email';
                                                                          else echo 'sms'; ?>">
            <button type="button" class="btn-invoice mb-3 <?php if ($mode == 'email') echo 'active'; ?>" id="invoice-via-email">
              <span class="btn-invoice-icon">
                <i class="fas fa-paper-plane"></i>
              </span>
              <span class="btn-invoice-text">Email</span>
            </button>
            <button type="button" class="btn-invoice mb-3 <?php if ($mode == 'sms') echo 'active'; ?>" id="invoice-via-sms">
              <span class="btn-invoice-icon">
                <i class="fas fa-comments"></i>
              </span>
              <span class="btn-invoice-text">SMS</span>
            </button>
          </div>

          <?php if ($mode == 'email') { ?>
            <input type="hidden" id="email-temp" value="<?= $cust['email']; ?>">
            <h6 id="judul-mode">Email :</h6>
            <div class="input-group mb-3" style="width:70%;margin: 0 auto;">
              <input type="text" value="<?= $cust['email']; ?>" class="form-control" id="input_contact" name="input_contact" placeholder="Email Customer" aria-label="Email Customer" aria-describedby="basic-addon1">
              <div class="input-group-append">
                <i class="fas fa-paper-plane input-group-text" id="basic-addon1"></i>
              </div>
            </div>
            <?php echo form_error('input_contact', '<div class="text-danger mb-4">', '</div>'); ?>
          <?php } else { ?>
            <input type="hidden" id="cp-temp" value="<?= $cust['cp']; ?>">
            <h6 id="judul-mode">SMS :</h6>
            <div class="input-group mb-3" style="width:70%;margin: 0 auto;">
              <input type="text" value="<?= $cust['cp']; ?>" class="form-control" id="input_contact" name="input_contact" placeholder="No. HP Customer" aria-label="No. HP Customer" aria-describedby="basic-addon1">
              <div class="input-group-append">
                <i class="fas fa-paper-plane input-group-text" id="basic-addon1"></i>
              </div>
            </div>
            <?php echo form_error('input_contact', '<div class="text-danger mb-4">', '</div>'); ?>
          <?php } ?>

          <button type="submit" id="btn-sbmt-resend" class="btn btn-primary btn-icon-split load-link">
            <span class="icon text-white-50">
              <i class="fas fa-paper-plane"></i>
            </span>
            <span class="text">Kirim</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>