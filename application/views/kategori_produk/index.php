<div class="row">
  <div class="col-12 col-lg-8 mx-auto">

    <div class="d-flex flex-row-reverse justify-content-between align-items-center mb-4">
      <button id="btn-tambah-kategori" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Kategori</span>
      </button>
      <div id="pesan-sukses"></div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Kategori Produk</h6>
      </div>
      <div class="card-body">
        <div class="container-table100">
          <div class="wrap-table100">
            <div class="table100">
              <table class="custom-table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                  </tr>
                </tfoot>
                <tbody id="data-table-kategori">
                  <?php $this->load->view('kategori_produk/viewTable', array('model' => $model)); // Load file view.php dan kirim data siswanya 
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="modal-kategori" class="hide-any custom-modal">

  <!-- Modal content -->
  <div class="custom-modal-content bg-gray-200 modal-kategori-content">
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
            <div class="form-group">
              <label for="input_nama">Nama Kategori Produk<span style="color: red">*</span></label>
              <input type="text" class="form-control" name="input_nama" id="input_nama" placeholder="Nama Kategori Produk">
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="custom-modal-footer">
      <div class="row">
        <div class="col-12 d-flex flex-row-reverse">
          <button type="button" id="btn-delete-kategori" class="btn btn-danger btn-icon-split btn-lg ml-3 disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-trash"></i>
            </span>
            <span class="text">Delete</span>
          </button>
          <button type="button" id="btn-cancel" class="btn btn-warning btn-icon-split btn-lg ml-3 disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-exclamation-triangle"></i>
            </span>
            <span class="text">Cancel</span>
          </button>
          <button type="button" id="btn-save-kategori" class="btn btn-primary btn-icon-split btn-lg disp-btn-lappenjualan">
            <span class="icon text-white-50">
              <i class="fas fa-save"></i>
            </span>
            <span class="text">Save</span>
          </button>
          <button type="button" id="btn-save-edit-kategori" class="btn btn-primary btn-icon-split btn-lg disp-btn-lappenjualan">
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