<input type="hidden" id="toko-active" value="<?= $toko['id']; ?>">
<div class="row">
  <div class="col-12 d-flex justify-content-between mb-4 mt-4">
    <div id="pesan-sukses" style="width:50%"></div>
    <button id="btn-tambah-operasional" class="btn btn-primary btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">Tambah Biaya Operasional</span>
    </button>
  </div>

  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" id="judul-list-operasional">List Biaya Operasional <?= $toko['nama']; ?></h6>
      </div>
      <div class="card-body">
        <div class="container-table100">
          <div class="wrap-table100">
            <div class="table100">
              <table class="custom-table table-operasional" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>Keperluan</th>
                    <th>Jumlah Biaya</th>
                    <th>Uang yg Digunakan</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody id="view-table-operasional">
                  <?php $this->load->view('operasional/viewTable', array('ops' => $ops)); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal Tambah operasional -->
<div id="modal-operasional" class="hide-any custom-modal">

  <!-- Modal content -->
  <div class="custom-modal-content bg-gray-200 modal-content-operasional">
    <div class="custom-modal-header mb-4">
      <span class="judul-modal-header" style="width: 100%">Modal Form</span>
      <span id="btn-close" class="close"><i class="fas fa-times-circle"></i></span>
    </div>
    <div class="custom-modal-body mb-4">
      <form class='modal-form'>
        <div class="row">
          <div class="col-12 hide-any container-pesan-error">
            <div class="alert alert-danger pesan-error"></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <input type="hidden" id="id-operasional" value="">
            <div class="form-group">
              <label for="input_keperluan">Keperluan<span style="color: red">*</span> <span id="error_keperluan" class="text-danger hide-any">Keperluan Belum Diisi</span></label>
              <textarea class="form-control" id="input_keperluan" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="input_biaya">Jumlah Biaya<span style="color: red">*</span> <span id="error_input_biaya" class="text-danger hide-any">Keperluan Belum Diisi</span></label>
              <input type="text" class="form-control" name="input_biaya" id="input_biaya" placeholder="Biaya Untuk Operasional">
            </div>
            <h6>Uang Yang Digunakan<span style="color: red">*</span> <span id="error_jenis_uang" class="text-danger hide-any">Jenis Uang Belum Dipilih</span></h6>
            <select class="form-control" id="pilih_uang">
              <option value="Pribadi" id="uang_pribadi">Uang Pribadi</option>
              <option value="Toko" id="uang_toko">Uang <?= $toko['nama']; ?></option>
            </select>
          </div>
        </div>
      </form>
    </div>
    <div class="custom-modal-footer">
      <div class="row">
        <div class="col-12 d-flex flex-row-reverse">
          <button type="button" id="btn-cancel" class="btn btn-warning btn-icon-split btn-lg ml-3 hide-any disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-exclamation-triangle"></i>
            </span>
            <span class="text">Cancel</span>
          </button>
          <button type="button" id="btn-delete-operasional" class="btn btn-danger btn-icon-split btn-lg ml-3 hide-any disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-trash"></i>
            </span>
            <span class="text">Delete</span>
          </button>
          <button type="button" id="btn-save-operasional" class="btn btn-primary btn-icon-split btn-lg hide-any disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-save"></i>
            </span>
            <span class="text">Save</span>
          </button>
          <button type="button" id="btn-save-edit-operasional" class="btn btn-primary btn-icon-split btn-lg hide-any disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-save"></i>
            </span>
            <span class="text">Save</span>
          </button>
        </div>
      </div>
    </div>
  </div>

</div>