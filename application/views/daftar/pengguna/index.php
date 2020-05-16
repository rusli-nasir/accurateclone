<div class="row">
  <div class="col-6">
    <?= $this->session->flashdata('suksesTambahDivisi') ?>
    <?= $this->session->flashdata('suksesUpdateDivisi') ?>
    <?= $this->session->flashdata('suksesTambahPengguna') ?>
    <?= $this->session->flashdata('errorTambahPengguna') ?>
    <?= $this->session->flashdata('suksesUpdatePengguna') ?>
    <?= $this->session->flashdata('suksesHapusPengguna') ?>
    <?= $this->session->flashdata('errorHapusPengguna') ?>
  </div>
</div>

<div class="row mb-5">
  <!-- DataTables Pengguna -->
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Pengguna</h6>
      </div>
      <div class="card-body">
        <div class="d-flex flex-row-reverse mt-2 mb-4">
          <a href="<?= base_url('Daftar/Pengguna/tambahPengguna'); ?>">
            <button id="btn-tambah-pengguna" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Tambah Pengguna</span>
            </button>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Contact Person</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="data-table-user">
              <?php $this->load->view('daftar/pengguna/tablePengguna', array('model' => $pengguna)); // Load file view.php dan kirim data siswanya 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Divisi</h6>
      </div>
      <div class="card-body">
        <div class="d-flex flex-row-reverse mt-2 mb-4">
          <a href="<?= base_url('Daftar/Pengguna/tambahDivisi'); ?>">
            <button id="btn-tambah-pengguna" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Tambah Divisi</span>
            </button>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Divisi</th>
                <th> </th>
              </tr>
            </thead>
            <tbody id="data-table-user">
              <?php $this->load->view('daftar/pengguna/tableDivisi', array('model' => $divisi)); // Load file view.php dan kirim data siswanya 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>