<?php print_r($hak_fitur); ?>

<div class="hide-any">
  <input type="hidden" value="<?= $this->uri->segment(4); ?>" id="divisi_id">
  <?php
  foreach ($hak_akses_menu as $data) {
  ?>
    <input type="hidden" value="<?= $data['is_enabled'];  ?>" id="<?= $data['html_id_menu'] . '-x'; ?>">
  <?php
  }
  ?>
  <?php
  foreach ($hak_akses_fitur as $data) {
  ?>
    <input type="hidden" value="<?= $data['is_enabled'];  ?>" id="<?= $data['html_id_fitur'] . '-x'; ?>">
  <?php
  }
  ?>
</div>

<form id="form-edit" action="<?= base_url('Daftar/Pengguna/editDivisi/') . $divisi_id ?>" method="post">
  <div class="row">
    <div class="col-12">
      <h4 class="mb-3">Edit Divisi</h4>
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-4 pr-5">

              <h5 class="mb-4">Informasi Divisi</h5>
              <div class="form-group">
                <label for="input_nama">Nama Divisi<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="nama_divisi" id="nama_divisi" maxlength="50" value="<?php
                                                                                                                  if (!empty($nama_divisi))
                                                                                                                    echo $nama_divisi['nama_divisi']
                                                                                                                  ?>">
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
                        <?php
                        foreach ($hak_menus as $x) {
                          if ($x['html_id_menu'] == $menu['html_id_menu']) {
                        ?>
                            <?php
                            if ($x['is_enabled'] == 0) {
                            ?>
                              <input type="checkbox" name="<?= $menu['html_id_menu'] ?>" id="<?= $menu['html_id_menu'] ?>">
                            <?php
                            } else {
                            ?>
                              <input type="checkbox" name="<?= $menu['html_id_menu'] ?>" id="<?= $menu['html_id_menu'] ?>" checked>
                            <?php
                            }
                            ?>
                        <?php
                          }
                        }
                        ?>
                        <label for=" <?= $menu['html_id_menu'] ?>"><?= $menu['nama_menu'] ?></label>
                      </div>

                      <?php
                      foreach ($features as $fitur) {
                        if ($menu['id'] == $fitur['utility_menu_id']) {
                      ?>

                          <div class="form-group ml-3 m-0">

                            <?php
                            foreach ($hak_fitur as $x) {
                              if ($x['html_id_fitur'] == $fitur['html_id_fitur']) {
                            ?>

                                <?php
                                if ($x['is_enabled'] == 0) {
                                ?>

                                  <input type="checkbox" name="<?= $fitur['html_id_fitur'] ?>" id="<?= $fitur['html_id_fitur'] ?>" class="<?= $menu['html_id_menu'] ?>">

                                <?php
                                } else {
                                ?>

                                  <input type="checkbox" name="<?= $fitur['html_id_fitur'] ?>" id="<?= $fitur['html_id_fitur'] ?>" class="<?= $menu['html_id_menu'] ?>" checked>

                                <?php
                                }
                                ?>
                            <?php
                              }
                            }
                            ?>

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
              <button type="submit" id="btn-save-edit-pengguna" class="btn btn-primary btn-icon-split btn-lg ml-4">
                <span class="icon text-white-50">
                  <i class="fas fa-save"></i>
                </span>
                <span class="text">Save</span>
              </button>
              <a href="" id="btn-delete-pengguna" class="btn btn-danger btn-icon-split btn-lg ml-4">
                <span class="icon text-white-50">
                  <i class="fas fa-trash-alt"></i>
                </span>
                <span class="text">Delete</span>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</form>