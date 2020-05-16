<?php $pengguna; ?>
<div class="row">

  <div class="col-8 mx-auto">

    <h4 class="mb-3">Edit Pengguna</h4>

    <div class="card">
      <div class="card-body">

        <form action="<?= base_url('Daftar/Pengguna/editPengguna') ?>" id="form-tambah-pengguna">

          <div class="form-group">
            <label for="input_nama">Nama <span style="color: red">*</span></label>
            <input type="text" class="form-control" name="input_nama" id="input_nama" maxlength="50" value="<?= $pengguna['nama']; ?>">
            <span class="text-danger hide-any" id="error-nama-kosong">*Nama tidak boleh kosong</span>
          </div>

          <div class="form-group">
            <label for="input_username">Username <span style="color: red">*</span></label>
            <input type="text" class="form-control" name="input_username" id="input_username" maxlength="20" value="<?= $pengguna['username']; ?>">
            <span class="text-success hide-any" id="status-username-unique">*Username bisa dipakai</span>
            <span class="text-danger hide-any" id="status-username-notunique">*Username sudah dipakai orang lain. Gunakan username lain</span>
            <span class="text-danger hide-any" id="error-username-kosong">*Username tidak boleh kosong</span>
          </div>

          <div class="form-group" id="change-password-div">
            <label for="btn-change-password">Password</label>
            <button type="button" class="btn btn-primary btn-icon-split" id="btn-change-password" style="display:block">
              <span class="icon text-white-50">
                <i class="fas fa-edit"></i>
              </span>
              <span class="text">Ganti Password</span>
            </button>
          </div>

          <div class="form-group hide-any" id="input-group-password">
            <label for="input_password">Password <span style="color: red">*</span></label>
            <input type="password" class="form-control" name="input_password" id="input_password" value="<?= $pengguna['password']; ?>">
            <span class="text-danger hide-any" id="error-password-kosong">*Password tidak boleh kosong</span>
            <span class="text-danger hide-any" id="error-password-kurang">*Password minimal 8 karakter</span>
          </div>

          <div class="form-group hide-any" id="input-group-passconf">
            <label for="input_passconf">Konfirmasi Password <span style="color: red">*</span></label>
            <input type="password" class="form-control" name="input_passconf" id="input_passconf" value="<?= $pengguna['password']; ?>">
            <span class="text-danger hide-any" id="error-passwordconf-kosong">*Konfirmasi Password tidak boleh kosong</span>
            <span class="text-danger hide-any" id="error-passwordconf-beda">*Konfirmasi Password beda dengan field Password</span>
          </div>

          <div class="form-group">
            <label for="input_cp">Contact Person</label>
            <input type="text" class="form-control" name="input_cp" id="input_cp" maxlength="20" value="<?= $pengguna['cp']; ?>">
          </div>

          <div class="form-group" id="form-alamat">
            <label for="input_alamat">Alamat Pengguna</label>
            <textarea class="form-control" id="input_alamat" name="input_alamat" rows="3" value="<?= $pengguna['alamat']; ?>"></textarea>
          </div>

          <div class="form-group">
            <label for="input_divisi">Pilih Divisi</label>
            <select class="form-control" id="input_divisi" name="input_divisi">
              <option value="0">----- Pilih Divisi -----</option>
              <?php
              foreach ($divisi as $x) {
              ?>
                <option value="<?= $x['id'] ?>" <?php if ($x['id'] == $pengguna['divisi_id']) echo 'selected="selected"' ?>>
                  <?= $x['nama']; ?>
                </option>
              <?php
              }
              ?>
            </select>
            <span class="text-danger hide-any" id="error-divisi-kosong">*Divisi harus dipilih</span>
          </div>


          <!-- Button -->
          <div class="d-flex flex-row-reverse mt-5">
            <a href="<?= base_url('Daftar/Pengguna'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-3">
              <span class="icon text-white-50">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span class="text">Cancel</span>
            </a>
            <a href="<?= base_url('Daftar/Pengguna/hapusPengguna/') . $this->uri->segment(4); ?>" id="btn-delete-pengguna" class="btn btn-danger btn-icon-split btn-lg ml-3">
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