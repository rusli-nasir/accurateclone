<div class="row">
  <div class="col-6">
    <?= $this->session->flashdata('sukses') ?>
    <?= $this->session->flashdata('error') ?>
  </div>
</div>
<!-- <?php print_r($list_penyesuaian); ?> -->
<div class="row mb-5">
  <!-- DataTables Pengguna -->
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Penyesuaian Persediaan</h6>
      </div>
      <div class="card-body">
        <div class="d-flex flex-row-reverse mt-2 mb-4">
          <a href="<?= base_url('Persediaan/PenyeseuaianPersediaan/tambahPenyeseuaianPersediaan'); ?>">
            <button id="btn-tambah-pengguna" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Tambah Penyesuaian Persediaan Baru</span>
            </button>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="table-list-penyesuaian" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal Penyesuaian</th>
                <th>Keterangan</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="data-table-user">
              <?php $this->load->view('persediaan/penyesuaian_persediaan/tableListPenyesuaianPersediaan', array('model' => $list_penyesuaian)); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>