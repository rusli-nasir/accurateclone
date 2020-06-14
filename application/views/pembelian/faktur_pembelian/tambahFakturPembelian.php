<!-- <?php var_dump($list_barang_beli) ?> -->
<div class="row">
  <div class="col-12">
    <h4 class="mb-3">Tambah Faktur Pembelian Baru</h4>
    <!-- <button type="button" id="tes" class="btn btn-primary btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-search"></i>
      </span>
      <span class="text">tes</span>
    </button> -->

    <form id="form" action="<?= base_url('Pembelian/FakturPembelian/tambahFakturPembelian') ?>" method="post">
      <div class="row mb-5">
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="mb-2">Kode Pesanan</div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <input type="hidden" id="id_form_pesanan" name="id_form_pesanan">
                    <input type="text" class="form-control" id="kode_pesanan" readonly>
                  </div>
                </div>
                <div class="col-6 text-center">
                  <button type="button" id="btn-pilih-pesanan" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-search"></i>
                    </span>
                    <span class="text">Pilih Pesanan</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="view-penerimaan-barang">

      </div>

    </form>
  </div>
</div>

<!-- Modal Tambah Pengguna -->
<div id="modal-pilih-pesanan" class="custom-modal mx-auto hide-any">
  <div class="row" style="width: 100%;height: 100vh;">
    <div class="col-6 my-auto mx-auto">
      <div class="card" style="height: 80vh;overflow-y: auto;">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h5 style="width: 100%">Pilih Pesanan Pembelian</h5>
            <span id="btn-close" class="close"><i class="fas fa-times-circle"></i></span>
          </div>
          <hr>
          <div class="text-center mb-3">
            <strong>Jika no pesanan yang dicari tidak ada, kemungkinan pesanan tersebut sudah selesai.</strong>
          </div>
          <form id="getListBarangPesanan">
            <input type="hidden" id="pesanan_terpilih" value="">
            <div class="table-responsive">
              <table class="table table-bordered" id="tablePesanan" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No Pesanan</th>
                    <th>Tanggal</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="data-table-pesanan">
                  <?php $this->load->view('pembelian/penerimaan_barang/tablePilihPesanan', array('model' => $list_pesanan)); // Load file view.php dan kirim data siswanya 
                  ?>
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>