<!-- Tombol Tambah Pengguna -->
<div class="d-flex flex-row-reverse justify-content-between align-items-center mb-4">
  <button id="btn-tambah-pengguna" class="btn btn-primary btn-icon-split">
    <span class="icon text-white-50">
      <i class="fas fa-plus"></i>
    </span>
    <span class="text">Tambah Karyawan</span>
  </button>
  <div id="pesan-sukses"></div>
</div>

<!-- DataTables Pengguna -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">List karyawan atau pengguna</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Peran</th>
            <th>Tanggal Gajian</th>
            <th>Gaji</th>
            <th>Aktif ?</th>
          </tr>
        </thead>
        <tbody id="data-table-user">
          <?php $this->load->view('karyawan/viewTable', array('model' => $model)); // Load file view.php dan kirim data siswanya 
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Pengguna -->
<div id="modal-pengguna" class="hide-any custom-modal">

  <!-- Modal content -->
  <div class="custom-modal-content bg-gray-200 modal-pengguna-content">
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
          <div class="col-lg-7">
            <div class="card mb-3">
              <div class="card-header">
                Data Pengguna
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="input_nama">Nama <span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="input_nama" id="input_nama" placeholder="Nama">
                </div>
                <div class="form-group">
                  <label for="input_cp">Nomor HP</label>
                  <input type="text" class="form-control" name="input_cp" id="input_cp" placeholder="Nomor HP">
                </div>
                <div class="form-group">
                  <label for="input_username">Username <span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="input_username" id="input_username" placeholder="Username">
                </div>
                <div id="change-password-form" style="margin-bottom:1rem">
                  <span style="margin-bottom: .5rem;display:inline-block;">Password</span>
                  <button type="button" class="btn btn-primary btn-icon-split" style="display:block">
                    <span class="icon text-white-50">
                      <i class="fas fa-edit"></i>
                    </span>
                    <span class="text">Ganti Password</span>
                  </button>
                </div>
                <div id="password-form">
                  <div class="form-group">
                    <label for="input_password">Password <span style="color: red">*</span></label>
                    <input type="password" class="form-control" name="input_password" id="input_password" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="input_passconf">Konfirmasi Password <span style="color: red">*</span></label>
                    <input type="password" class="form-control" name="input_passconf" id="input_passconf" placeholder="Konfirmasi Password">
                  </div>
                </div>
                <div class="form-group" id="form-alamat">
                  <label for="input_alamat">Alamat Pengguna</label>
                  <textarea class="form-control" id="input_alamat" name="input_alamat" rows="3" placeholder="Alamat Pengguna"></textarea>
                </div>
              </div>
            </div>
            <div class="card" id="modal-pengguna-toko">
              <div class="card-header">
                Penempatan Kerja
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="input_toko">Pilih Lokasi Toko</label>
                  <select class="form-control" id="input_toko" name="input_toko">
                    <option value="">----- Pilih Toko -----</option>
                    <?php foreach ($toko as $tkdata) { ?>
                      <option value="<?= $tkdata['id']; ?>"><?= $tkdata['nama']; ?></option>
                    <?php } ?>
                  </select>
                  <?php echo form_error('input_toko', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="card mb-3" id="modal-pengguna-peran">
              <div class="card-header">
                Peran
              </div>
              <div class="card-body">
                <div class="form-check hide-any">
                  <input class="form-check-input" type="radio" name="input_peran" id="peran1" value="1">
                  <label class="form-check-label" for="peran1">
                    Web Administrator
                  </label>
                </div>
                <div class="form-check hide-any">
                  <input class="form-check-input" type="radio" name="input_peran" id="peran2" value="2">
                  <label class="form-check-label" for="peran1">
                    Owner
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="input_peran" id="peran3" value="3">
                  <label class="form-check-label" for="peran1">
                    Admin
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="input_peran" id="peran4" value="4">
                  <label class="form-check-label" for="peran3">
                    Karyawan
                  </label>
                </div>
              </div>
            </div>
            <div class="card mb-3 d-none" id="modal-pengguna-shift">
              <div class="card-header">
                Shift Kerja
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="input_shift">Pilih Shift Kerja Karyawan</label>
                  <select class="form-control" id="input_shift" name="input_shift">
                    <option value="">----- Pilih Shift -----</option>
                    <option value="pagi">Pagi</option>
                    <option value="sore">Sore</option>
                  </select>
                  <?php echo form_error('input_toko', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>
            <div class="card mb-3" id="modal-pengguna-gaji">
              <div class="card-header">
                Gaji
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="input_tgl_gaji">Tanggal Gaji</label>
                  <input type="text" data-toggle="datepicker" class="form-control" id="input_tgl_gaji" name="input_tgl_gaji" placeholder="Tanggal Gaji format YYYY/MM/DD" readonly="readonly" style="background-color:white">
                </div>
                <div class="form-group">
                  <label for="input_jml_gaji">Jumlah Gaji</label>
                  <input type="text" class="form-control" id="input_jml_gaji" name="input_jml_gaji" placeholder="Jumlah Gaji misal 1700000">
                </div>
              </div>
            </div>
            <div class="card" id="modal-pengguna-status">
              <div class="card-header">
                Status Pengguna
              </div>
              <div class="card-body">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="input_is_active" name="input_is_active">
                  <label class="form-check-label" for="input_is_active">
                    Aktif?
                  </label>
                </div>
              </div>
            </div>
          </div>
      </form>
    </div>
  </div>
  <div class="custom-modal-footer">
    <div class="row">
      <div class="col-12 d-flex flex-row-reverse">
        <button type="button" id="btn-cancel" class="btn btn-warning btn-icon-split btn-lg ml-3">
          <span class="icon text-white-50">
            <i class="fas fa-exclamation-triangle"></i>
          </span>
          <span class="text">Cancel</span>
        </button>
        <button type="button" id="btn-delete-pengguna" class="btn btn-danger btn-icon-split btn-lg ml-3">
          <span class="icon text-white-50">
            <i class="fas fa-trash"></i>
          </span>
          <span class="text">Delete</span>
        </button>
        <button type="button" id="btn-save-pengguna" class="btn btn-primary btn-icon-split btn-lg">
          <span class="icon text-white-50">
            <i class="fas fa-save"></i>
          </span>
          <span class="text">Save</span>
        </button>
        <button type="button" id="btn-save-edit-pengguna" class="btn btn-primary btn-icon-split btn-lg">
          <span class="icon text-white-50">
            <i class="fas fa-save"></i>
          </span>
          <span class="text">Save</span>
        </button>
      </div>
    </div>
  </div>
</div>