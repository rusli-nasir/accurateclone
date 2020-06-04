<div class="row">
  <div class="col-6">
    <?= $this->session->flashdata('sukses') ?>
    <?= $this->session->flashdata('error') ?>
  </div>
</div>
<!-- <?php var_dump($barang_per_gudang); ?> -->
<div class="row mb-4">
  <div class="col-12">
    <div class="btn-group" role="group" aria-label="Basic example">
      <button class="sub-fitur btn btn-primary active text-white" data-id="barang_jasa">List Barang Jasa</button>
      <button class="sub-fitur btn btn-primary text-white" data-id="kategori">List Kategori</button>
      <button class="sub-fitur btn btn-primary text-white" data-id="barang_per_gudang">Barang Per Gudang</button>
    </div>
  </div>
</div>
<div class="row mb-5 container-fitur" id="barang_jasa">
  <!-- DataTables Pengguna -->
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Barang dan Jasa</h6>
      </div>
      <div class="card-body">
        <div class="d-flex flex-row-reverse mt-2 mb-4">
          <a href="<?= base_url('Persediaan/BarangJasa/tambahBarangJasa'); ?>">
            <button id="btn-tambah-pengguna" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Tambah Barang</span>
            </button>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="tableBarang" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Kategori</th>
                <th>Kode Barang</th>
                <th>Keterangan</th>
                <th>Kuantitas</th>
                <th>Harga Jual Terbaru</th>
                <th>Tipe</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="data-table-user">
              <?php $this->load->view('persediaan/barang_jasa/tableBarangJasa', array('model' => $table_all)); // Load file view.php dan kirim data siswanya 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-5 hide-any container-fitur" id="kategori">
  <!-- DataTables Pengguna -->
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Kategori Barang / Jasa</h6>
      </div>
      <div class="card-body">
        <div class="d-flex flex-row-reverse mt-2 mb-4">
          <a href="<?= base_url('Persediaan/BarangJasa/tambahKategoriBarang'); ?>">
            <button id="btn-tambah-pengguna" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Tambah Kategori Barang</span>
            </button>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="tableKategori" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="data-table-user">
              <?php $this->load->view('persediaan/barang_jasa/tableKategoriBarang', array('model' => $table_kategori)); // Load file view.php dan kirim data siswanya 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-5 hide-any container-fitur" id="barang_per_gudang">
  <!-- DataTables Pengguna -->
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Barang Per Gudang</h6>
      </div>
      <div class="card-body">
        <div class="d-flex flex-row-reverse mt-2 mb-4">
          <a href="<?= base_url('Persediaan/BarangJasa/tambahKategoriBarang'); ?>">
            <button id="btn-tambah-pengguna" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Tambah Kategori Barang</span>
            </button>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="tableBarangPerGudang" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Kode Barang</th>
                <th>Deskripsi</th>
                <?php foreach ($list_gudang as $gudang) { ?>
                  <th><?= $gudang['nama_gudang'] ?></th>
                <?php } ?>
              </tr>
            </thead>
            <tbody id="data-table-user">
              <?php $this->load->view('persediaan/barang_jasa/tableBarangPerGudang', array('barang_per_gudang' => $barang_per_gudang, 'list_gudang' => $list_gudang)); // Load file view.php dan kirim data siswanya 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>