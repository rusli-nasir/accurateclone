<div class="row">
  <!-- <?php var_dump($data) ?> -->
  <div class="col-8 mx-auto">
    <?= $this->session->flashdata('sukses') ?>
    <?= $this->session->flashdata('error') ?>

    <div class="card mt-4">
      <div class="card-body">

        <form action="<?= base_url('redirect/InfoPerusahaan/index') ?>" id="form" method="post">

          <div class="form-group">
            <label for="input_nama">Nama Pemasok<span style="color: red">*</span></label>
            <input type="text" class="form-control input" name="nama" id="nama" maxlength="80" value="<?= $data['nama_perusahaan'] ?>">
            <span class="text-danger hide-any" id="error-nama-kosong">*Nama Perusahaan tidak boleh kosong</span>
          </div>

          <div class="form-group" id="form-alamat">
            <label for="input_alamat">Alamat<span style="color: red">*</span></label>
            <textarea class="form-control input" id="alamat" name="alamat" rows="3"><?= $data['alamat'] ?></textarea>
            <span class="text-danger hide-any" id="error-alamat-kosong">*Alamat tidak boleh kosong</span>
          </div>

          <div class="form-group">
            <label for="input_nama">Telepon</label>
            <input type="text" class="form-control input" name="telepon" id="telepon" maxlength="20" value="<?= $data['telepon'] ?>">
          </div>

          <hr>
          <!-- Button -->
          <div class="d-flex flex-row-reverse">
            <a href="<?= base_url('Daftar/Pengguna'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
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