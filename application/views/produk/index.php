<div class="row">

  <div class="col-12 d-flex flex-row-reverse justify-content-between align-items-center mb-4 container-index-produk">
    <a href="<?= base_url('Produk/tambahProduk'); ?>" id="btn-tambah-pengguna" class="load-link btn btn-primary btn-icon-split mt-3">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">Tambah Produk Baru</span>
    </a>
    <?php echo $this->session->flashdata('suksesAddProduk'); ?>
    <?php echo $this->session->flashdata('suksesEditProduk'); ?>
  </div>

  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Semua Produk Yang Ada</h6>
      </div>
      <div class="card-body">
        <div class="container-table100">
          <div class="wrap-table100">
            <div class="table100">
              <table class="custom-table table-produk" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>Nama Produk</th>
                    <th>SKU</th>
                    <th>Modal</th>
                    <th>Jual</th>
                    <th>Diskon</th>
                    <th>Profit</th>
                  </tr>
                </thead>
                <tbody class="table-w-foto">
                  <?php $this->load->view('produk/viewTable', array('model' => $model)); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>