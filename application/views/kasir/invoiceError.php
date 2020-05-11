<div class="row">
  <div class="col-12 col-md-8 col-lg-6 mx-auto">
    <form action="" method="post">


      <?php if ($mode == 'email') { ?>
        <div class="alert alert-danger mb-4" role="alert">
          Pastikan format email yang ditulis sudah benar!
        </div>
        <div class="card">
          <div class="card-header">
            Invoice <?= ucfirst($mode); ?>
          </div>
          <div class="card-body text-center">
            <h6>Nama Customer :</h6>
            <input type="text" value="<?= $cust['nama']; ?>" class="form-control mb-3" id="input_nama_customer" name="input_nama_customer" placeholder="Nama" style="width:70%;display:block;margin: 0 auto;">
            <?php echo form_error('input_nama_customer', '<div class="text-danger mb-4">', '</div>'); ?>
            <h6>Email :</h6>
            <div class="input-group mb-3" style="width:70%;margin: 0 auto;">
              <input type="text" value="<?= $cust['email']; ?>" class="form-control" id="input_email_customer" name="input_email_customer" placeholder="Email Customer" aria-label="Email Customer" aria-describedby="basic-addon2" style="background-color:#FCEFDC">
              <div class="input-group-append">
                <i class="fas fa-paper-plane input-group-text" id="basic-addon2"></i>
              </div>
            </div>
            <?php echo form_error('input_email_customer', '<div class="text-danger mb-4">', '</div>'); ?>

            <button type="submit" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-paper-plane"></i>
              </span>
              <span class="text">Kirim</span>
            </button>
          </div>
        </div>
      <?php } ?>

      <?php if ($mode == 'SMS') { ?>
        <div class="alert alert-danger mb-4" role="alert">
          <?php if ($error_type == 1) echo 'Pastikan format nomor HP yang ditulis sudah benar!'; ?>
        </div>
        <div class="card">
          <div class="card-header">
            Invoice <?= $mode; ?>
          </div>
          <div class="card-body text-center">
            <h6>Nama Customer :</h6>
            <input type="text" value="<?= $cust['nama']; ?>" class="form-control mb-3" id="input_nama_customer" name="input_nama_customer" placeholder="Nama" style="width:70%;display:block;margin: 0 auto;">
            <?php echo form_error('input_nama_customer', '<div class="text-danger mb-4">', '</div>'); ?>
            <h6>No. HP :</h6>
            <div class="input-group mb-3" style="width:70%;margin: 0 auto;">
              <input type="text" value="<?= $cust['cp']; ?>" class="form-control" id="input_cp_customer" name="input_cp_customer" placeholder="Email Customer" aria-label="Email Customer" aria-describedby="basic-addon2" style="background-color:#FCEFDC">
              <div class="input-group-append">
                <i class="fas fa-comments input-group-text" id="basic-addon2"></i>
              </div>
            </div>
            <?php echo form_error('input_cp_customer', '<div class="text-danger mb-4">', '</div>'); ?>

            <button type="submit" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-paper-plane"></i>
              </span>
              <span class="text">Kirim</span>
            </button>
          </div>
        </div>
      <?php } ?>


    </form>
  </div>
</div>