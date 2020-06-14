<div class="row">
  <div class="col-6">
    <?= $this->session->flashdata('sukses') ?>
    <?= $this->session->flashdata('error') ?>
  </div>
</div>
<!-- <?php var_dump($list_penerimaan); ?> -->
<div class="row mb-5">
  <!-- DataTables Pengguna -->
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Penerimaan Barang</h6>
      </div>
      <div class="card-body">
        <div class="d-flex flex-row-reverse mt-2 mb-4">
          <a href="<?= base_url('Pembelian/PenerimaanBarang/tambahPenerimaanBarang'); ?>">
            <button id="btn-tambah-pengguna" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Tambah Penerimaan Barang Baru</span>
            </button>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="tablePemasok" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="width: 20%;">No Pesanan Diterima</th>
                <th style="width: 15%;">Tanggal Terima</th>
                <th style="width: 25%;">Nama Pemasok</th>
                <th style="width: 35%;">Deskripsi</th>
                <th style="width: 5%;"></th>
              </tr>
            </thead>
            <tbody id="data-table-user">
              <?php $this->load->view('pembelian/penerimaan_barang/tableListPenerimaanBarang', array('model' => $list_penerimaan)); // Load file view.php dan kirim data siswanya 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>