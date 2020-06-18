<div class="row">

  <div class="col-8 mx-auto">

    <h4 class="mb-3">Tambah Jasa Pengiriman Baru</h4>

    <div class="card">
      <div class="card-body">

        <form action="<?= base_url('Daftar/JasaPengiriman/tambahJasaPengiriman') ?>" id="form" method="post">

          <div class="form-group">
            <label for="nama">Nama Jasa Pengiriman<span style="color: red">*</span></label>
            <input type="text" class="form-control input" name="nama" id="nama" maxlength="80">
            <span class="text-danger hide-any" id="error-nama-kosong">*Nama Jasa Pengiriman tidak boleh kosong</span>
          </div>

          <hr>
          <!-- Button -->
          <div class="d-flex flex-row-reverse">
            <a href="<?= base_url('Daftar/JasaPengiriman'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <button type="submit" id="btn-save" class="btn btn-primary btn-icon-split btn-lg">
              <span class="icon text-white-50">
                <i class="fas fa-save"></i>
              </span>
              <span class="text">Save</span>
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>