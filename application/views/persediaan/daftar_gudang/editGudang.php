<input type="hidden" id="id_gudang" value="<?= $gudang['id'] ?>">
<div class="row">

  <div class="col-8 mx-auto">

    <h4 class="mb-3">Edit Gudang</h4>

    <div class="card">
      <div class="card-body">

        <form action="<?= base_url('Persediaan/DaftarGudang/editGudang') ?>" id="form-tambah-gudang">

          <div class="form-group">
            <label for="nama_gudang">Nama Gudang<span style="color: red">*</span></label>
            <input type="text" class="form-control" name="nama_gudang" id="nama_gudang" maxlength="50" value="<?= $gudang['nama_gudang'] ?>">
            <span class="text-danger hide-any" id="error-nama-kosong">*Nama Gudang tidak boleh kosong</span>
          </div>

          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" rows="3" name="keterangan" value="<?= $gudang['keterangan'] ?>"></textarea>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" value="<?= $gudang['alamat'] ?>"></textarea>
          </div>

          <div class="form-group">
            <label for="penanggung_jawab">Penanggung Jawab<span style="color: red">*</span></label>
            <input type="text" class="form-control" name="penanggung_jawab" id="penanggung_jawab" maxlength="50" value="<?= $gudang['penanggung_jawab'] ?>">
            <span class="text-danger hide-any" id="error-penanggungjawab-kosong">*Penanggung Jawab tidak boleh kosong</span>
          </div>

          <div class="d-flex flex-row-reverse mt-5 pt-3" style="border-top: 1px solid #ebebeb">
            <a href="<?= base_url('Persediaan/DaftarGudang'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <a href="<?= base_url('Persediaan/DaftarGudang/hapusGudang/') . $this->uri->segment(4); ?>" id="btn-delete-pengguna" class="btn btn-danger btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-trash"></i>
              </span>
              <span class="text">Delete</span>
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