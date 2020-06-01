<!-- <?php print_r($menus); ?>
<hr>
<?php print_r($features); ?> -->
<form id="form-tambah-pengguna" action="<?= base_url('Daftar/Pengguna/tambahDivisi') ?>" method="post">
  <div class="row">
    <div class="col-12">
      <h4 class="mb-3">Tambah Divisi Baru</h4>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-4 pr-5">

              <h5 class="mb-4">Informasi Divisi</h5>
              <div class="form-group">
                <label for="input_nama">Nama Divisi<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="nama_divisi" id="nama_divisi" maxlength="50">
                <span class="error_nama_divisi hide-any text-danger">Nama Divisi Harus Di Isi</span>
              </div>

            </div>

            <div class="col-8">
              <h5 class="mb-4">Hak Akses Fitur</h5>

              <div class="form-group mb-3">
                <input type="checkbox" name="check_all_fitur" value="" id="check_all_fitur">
                <label for="check_all_fitur">Check All</label>
              </div>

              <div class="row">
                <?php
                $i = 1;
                foreach ($menus as $menu) {
                ?>

                  <?php if (fmod($i, 2) == 1) { ?>
                    <div class="col-6">
                    <?php } ?>

                    <div class="mb-2">

                      <div class="form-group m-0">
                        <input type="checkbox" name="<?= $menu['html_id_menu'] ?>" id="<?= $menu['html_id_menu'] ?>">
                        <label for=" <?= $menu['html_id_menu'] ?>"><?= $menu['nama_menu'] ?></label>
                      </div>

                      <?php
                      foreach ($features as $fitur) {
                        if ($menu['id'] == $fitur['utility_menu_id']) {
                      ?>

                          <div class="form-group ml-3 m-0">
                            <input type="checkbox" name="<?= $fitur['html_id_fitur'] ?>" id="<?= $fitur['html_id_fitur'] ?>" class="<?= $menu['html_id_menu'] ?>">
                            <label for="<?= $fitur['html_id_fitur'] ?>"><?= $fitur['html_id_fitur'] ?></label>
                          </div>

                      <?php
                        }
                      }
                      ?>

                    </div>

                    <?php if (fmod($i, 2) == 0) { ?>
                    </div>
                  <?php } ?>

                <?php
                  $i++;
                }
                ?>
              </div>
            </div>

          </div>
          <div class="row pt-3 mt-3" style="border-top: 1px solid #ebebeb">
            <div class="col-12 d-flex flex-row-reverse">
              <a href="<?= base_url('Daftar/Pengguna'); ?>" class="btn btn-warning btn-icon-split btn-lg ml-4">
                <span class="icon text-white-50">
                  <i class="fas fa-undo-alt"></i>
                </span>
                <span class="text">Back</span>
              </a>
              <button type="submit" id="btn-save-pengguna" class="btn btn-primary btn-icon-split btn-lg ml-4">
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
  </div>
</form>