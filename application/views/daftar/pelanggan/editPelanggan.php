<!-- <?php var_dump($pelanggan); ?> -->
<div class="row">

  <div class="col-8 mx-auto">

    <h4 class="mb-3">Edit Pelanggan</h4>

    <div class="card">
      <div class="card-body">

        <form action="<?= base_url('Daftar/Pelanggan/editPelanggan/' . $id) ?>" id="form" method="post">

          <div class="form-group">
            <label for="nama">Nama Pelanggan<span style="color: red">*</span></label>
            <input type="text" class="form-control input" name="nama" id="nama" maxlength="80" value="<?= $pelanggan['nama_pelanggan'] ?>">
            <span class="text-danger hide-any" id="error-nama-kosong">*Nama Pelanggan tidak boleh kosong</span>
          </div>

          <div class="form-group" id="form-alamat">
            <label for="alamat">Alamat<span style="color: red">*</span></label>
            <textarea class="form-control input" id="alamat" name="alamat" rows="3"><?= $pelanggan['alamat'] ?></textarea>
          </div>

          <div class="form-group">
            <label for="telepon">Telepon</label>
            <input type="text" class="form-control input" name="telepon" id="telepon" maxlength="20" value="<?= $pelanggan['telepon'] ?>">
          </div>

          <div class="form-group">
            <label for="kontak">Kontak</label>
            <input type="text" class="form-control input" name="kontak" id="kontak" maxlength="50" value="<?= $pelanggan['kontak'] ?>">
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
            <a href="<?= base_url('Daftar/Pelanggan/hapusPelanggan/' . $id) ?>" id="btn-delete-pengguna" class="btn btn-danger btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-trash"></i>
              </span>
              <span class="text">Delete</span>
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