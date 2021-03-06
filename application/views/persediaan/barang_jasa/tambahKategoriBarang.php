<div class="row">

  <div class="col-8 mx-auto">

    <h4 class="mb-3">Tambah Kategori Barang Baru</h4>

    <div class="card">
      <div class="card-body">

        <form action="<?= base_url('Persediaan/BarangJasa/tambahKategoriBarang') ?>" id="form-tambah-kategori">

          <div class="form-group">
            <label for="nama_kategori">Nama Kategori<span style="color: red">*</span></label>
            <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" maxlength="50">
            <span class="text-danger hide-any" id="error-nama-kosong">*Nama Kategori tidak boleh kosong</span>
          </div>

          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <a href="<?= base_url('Persediaan/BarangJasa'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <button type="submit" id="btn-save-pengguna" class="btn btn-primary btn-icon-split btn-lg">
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