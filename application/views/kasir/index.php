<div class="row kasir-display-phone">

  <!-- Notifikasi Pesan -->
  <?php if ($this->session->flashdata('pesanBayar')) echo $this->session->flashdata('pesanBayar'); ?>

  <div class="col-xl-7 col-lg-6 col-12 d-block d-lg-none">
    <div class="card mb-4">
      <div class="card-header">
        Pengunjung Tidak Beli
      </div>
      <div class="card-body">
        <span style="display:block" class="mb-3">Pengunjung Tidak Beli : <strong><span class="text-danger jml-tdk-beli"><?= $tdk_beli; ?></span></strong></span>
        <span style="display:block">Tambah Pengunjung Tidak Beli</span>
        <button class="btn btn-danger btn-icon-split mt-2 btn-tidak-beli">
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>
          <span class="text">Tambah</span>
        </button>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        Laporan Penjualan Hari Ini
      </div>
      <div class="card-body">
        <table>
          <tr>
            <td>Omset</td>
            <td class="text-center" style="width:20px">:</td>
            <td class="text-primary"><strong><?= $laporan['omset']; ?></strong></td>
          </tr>
          <tr>
            <td>Total Transaksi</td>
            <td class="text-center" style="width:20px">:</td>
            <td class="text-primary"><strong><?= $laporan['transaksi']; ?></strong></td>
          </tr>
          <tr>
            <td>Barang Terjual</td>
            <td class="text-center" style="width:20px">:</td>
            <td class="text-primary"><strong><?= $laporan['jml_brg']; ?></strong></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-7 col-12 mb-4 mt-4 d-none d-lg-block">
    <div class="card">
      <div class="card-header">
        Laporan Penjualan Hari Ini
      </div>
      <div class="card-body">
        <table>
          <tr>
            <td>Omset</td>
            <td class="text-center" style="width:20px">:</td>
            <td class="text-primary"><strong><?= $laporan['omset']; ?></strong></td>
          </tr>
          <tr>
            <td>Total Transaksi</td>
            <td class="text-center" style="width:20px">:</td>
            <td class="text-primary"><strong><?= $laporan['transaksi']; ?></strong></td>
          </tr>
          <tr>
            <td>Barang Terjual</td>
            <td class="text-center" style="width:20px">:</td>
            <td class="text-primary"><strong><?= $laporan['jml_brg']; ?></strong></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-5 col-md-7 col-12 mb-4 mt-4 d-none d-lg-block">
    <div class="card">
      <div class="card-header">
        Pengunjung Tidak Beli
      </div>
      <div class="card-body">
        <span style="display:block" class="mb-3">Pengunjung Tidak Beli : <strong><span class="text-danger jml-tdk-beli"><?= $tdk_beli; ?></span></strong></span>
        <span style="display:block">Tambah Pengunjung Tidak Beli</span>
        <button class="btn btn-danger btn-icon-split mt-2 btn-tidak-beli">
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>
          <span class="text">Tambah</span>
        </button>
      </div>
    </div>
  </div>

  <div class="col-xl-5 col-lg-6 col-12 mt-4 mb-4 tespak">
    <div class="card pembayaran" style="border:1px solid #d1d3e2">
      <div class="card-header">
        Pembayaran
      </div>
      <div class="card-body d-flex flex-column" style="font-size: 1rem;position: relative;">
        <div class="container-barang-pembayaran" id="list-cart">
          <?php $this->load->view('kasir/displayCart') ?>
        </div>
        <hr class="batas-barang-pembayaran">
        <div class="d-flex justify-content-between mt-1 font-weight-bold" style="color: #4e73df;font-size: 1.2rem;">
          <span>
            Total
          </span>
          <span id="disp-grandtotal">
          </span>
        </div>
        <div class="proses-pembayaran">
          <button id="btn-proses-pembayaran" type="submit" class="btn-bayar">
            <span class="btn-bayar-icon">
              <i class="fas fa-check"></i>
            </span>
            <span class="btn-bayar-text">PROSES</span>
          </button>
          <button class="btn btn-danger btn-clear" id="hapus-cart-all">
            CANCEL
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-7 col-lg-6 col-12 mt-4">
    <!-- Search Bar -->
    <form class="my-2 my-md-0 mw-100 navbar-search">
      <input type="hidden" id="input_toko_id" value="<?= $toko_id; ?>">
      <div class="input-group">
        <input type="text" id="cari-barang" class="form-control bg-light small" placeholder="Cari barang berdasarkan SKU atau nama produk" aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button" id="clear-search-bar">
            <i class="fas fa-times fa-sm"></i>
          </button>
        </div>
      </div>
    </form>

    <ul id="container-katalog-cari">
      <?php $this->load->view('kasir/displayProdukCardCari', array('kategori' => $datacat, 'produk' => $datapdk)); // Load file view.php dan kirim data siswanya 
      ?>
    </ul>
    <div id="showProdukCard">
      <?php $this->load->view('kasir/displayProdukCard', array('kategori' => $datacat, 'produk' => $datapdk)); // Load file view.php dan kirim data siswanya 
      ?>
    </div>

  </div>

</div>
<!-- /.End of row -->

<!-- Modal Tambah Pengguna -->
<div id="modal-kasir" class="custom-modal hide-any">

  <!-- Modal content -->
  <div class="custom-modal-content bg-gray-200 modal-kasir-content">
    <div class="custom-modal-header mb-4">
      <span class="judul-modal-header" style="width: 100%">Proses Pembayaran</span>
      <span id="btn-close" class="close"><i class="fas fa-times-circle"></i></span>
    </div>
    <div class="custom-modal-body mb-4" style="overflow-y:scroll">
      <div class="row">

        <div class="col-12 col-lg-5">

          <div class="card mb-4">
            <div class="card-header">
              Detail Pembayaran
            </div>
            <div class="card-body d-flex justify-content-around d-flex flex-column">

              <div class="d-flex justify-content-between mb-1 text-primary" style="font-weight:bold">
                <span>Grand Total :</span>
                <span id="grand-total-modal"></span>
              </div>
              <hr style="height: 2px; width: 100%; display: block" class="bg-primary">
            </div>
          </div>

        </div>

        <div id="displayMetodeBayar" class="col-12 col-lg-7 hide-any">

          <div class="card">
            <div class="card-header">
              Pembayaran
            </div>
            <div class="card-body">
              <div class="form-group mb-5">
                <h6 class="mb-3">Cash Diterima</h6>
                <input type="text" id="input-jumlah-bayar" class="form-control" placeholder="Cash Diterima" style="font-size: 2.5rem;color:#1cc88a">
              </div>
              <div class="form-group mb-5">
                <h6 class="mb-3">Jumlah Customer yang Melakukan Pembelian</h6>
                <input type="text" id="input_jumlah_customer" class="form-control" name="input_jumlah_customer" placeholder="Jumlah Customer">
              </div>
              <h6 class="mb-3">Metode Pembayaran</h6>
              <div class="d-flex justify-content-around">
                <button type="button" id="btn-metode-bayar-cash" class="btn btn-primary btn-icon-split btn-lg btn-metode-bayar disp-btn-lappenjualan">
                  <span class=" icon text-white-50">
                    <i class="fas fa-money-bill-wave"></i>
                  </span>
                  <span class="text">Cash</span>
                </button>
                <button type="button" id="btn-metode-bayar-credit" class="btn btn-primary btn-icon-split btn-lg btn-metode-bayar disp-btn-lappenjualan">
                  <span class=" icon text-white-50">
                    <i class="fas fa-credit-card"></i>
                  </span>
                  <span class="text">Credit Card</span>
                </button>
              </div>
            </div>
          </div>

        </div>

        <div id="displayInvoiceCash" class="col-12 col-lg-7 hide-any">

          <div class="card">
            <div class="card-header">
              Invoice (Cash)
            </div>
            <div class="card-body text-center">
              <h5 class="mb-2">Kembali :</h5>
              <div style="font-size:2.5rem" class="text-success mb-2" id="disp-kembalian-cash"></div>
              <h5 class="mb-4">Invoice :</h5>
              <div class="d-flex flex-wrap justify-content-between mb-3">
                <button type="button" class="btn-invoice mb-3" id="invoice-via-email-cash">
                  <span class="btn-invoice-icon">
                    <i class="fas fa-paper-plane"></i>
                  </span>
                  <span class="btn-invoice-text">Email</span>
                </button>
                <button type="button" class="btn-invoice mb-3" id="invoice-via-sms-cash">
                  <span class="btn-invoice-icon">
                    <i class="fas fa-comments"></i>
                  </span>
                  <span class="btn-invoice-text">SMS</span>
                </button>
              </div>

              <div id="form-email-customer-cash" class="hide-any">
                <h6>Nama Customer :</h6>
                <input type="text" class="form-control mb-1" id="input_nama_email_cash" placeholder="Nama" style="width:70%;display:block;margin: 0 auto;">
                <div id="error_nama_email_cash" class="text-danger hide-any">*Nama harus diisi!</div>

                <h6 class="mt-3">Email :</h6>
                <div class="input-group mb-1" style="width:70%;margin: 0 auto;">
                  <input type="text" class="form-control" id="input_email_customer" placeholder="Email Customer" aria-label="Email Customer" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <i class="fas fa-paper-plane input-group-text" id="basic-addon2"></i>
                  </div>
                </div>
                <div id="error_email_cash" class="text-danger mb-3 hide-any">*Email tidak valid!</div>

                <button type="button" id="btn-email-customer-cash" class="btn btn-primary btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-paper-plane"></i>
                  </span>
                  <span class="text">Kirim</span>
                </button>
              </div>

              <div id="form-sms-customer-cash" class="hide-any">
                <h6>Nama Customer :</h6>
                <input type="text" class="form-control mb-1" id="input_nama_cp_cash" placeholder="Nama" style="width:70%;display:block;margin: 0 auto;">
                <div id="error_nama_cp_cash" class="text-danger hide-any">*Nama harus diisi!</div>

                <h6 class="mt-3">No. HP Customer :</h6>
                <div class="input-group mb-1" style="width:70%;margin: 0 auto;">
                  <input type="text" id="input_cp_cash" class="form-control" placeholder="No. HP Customer" aria-label="No. HP Customer" aria-describedby="basic-addon1">
                  <div class="input-group-prepend">
                    <i class="fas fa-comments input-group-text" id="basic-addon1"></i>
                  </div>
                </div>
                <div id="error_cp_cash" class="text-danger mb-3 hide-any">*No. HP tidak valid!</div>

                <button type="button" id="btn-cp-customer-cash" class="btn btn-primary btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-comments"></i>
                  </span>
                  <span class="text">Kirim</span>
                </button>
              </div>
            </div>

          </div>

        </div>


        <div id="displayInvoiceCredit" class="col-12 col-lg-7 hide-any">

          <div class="card">
            <div class="card-header">
              Invoice (Credit Card)
            </div>
            <div class="card-body text-center">
              <h5 class="mb-2">Kembali :</h5>
              <div style="font-size:2.5rem" class="text-success mb-2" id="disp-kembalian-credit"></div>
              <h5 class="mb-4">Invoice :</h5>
              <div class="d-flex flex-wrap justify-content-between mb-3">
                <button type="submit" class="btn-invoice mb-3" id="invoice-via-email-credit">
                  <span class="btn-invoice-icon">
                    <i class="fas fa-paper-plane"></i>
                  </span>
                  <span class="btn-invoice-text">Email</span>
                </button>
                <button type="submit" class="btn-invoice mb-3" id="invoice-via-sms-credit">
                  <span class="btn-invoice-icon">
                    <i class="fas fa-comments"></i>
                  </span>
                  <span class="btn-invoice-text">SMS</span>
                </button>
              </div>

              <div id="form-email-customer-credit" class="hide-any">
                <h6>Nama Customer :</h6>
                <input type="text" class="form-control mb-1" id="input_nama_email_credit" placeholder="Nama" style="width:70%;display:block;margin: 0 auto;">
                <div id="error_nama_email_credit" class="text-danger">*Nama harus diisi!</div>

                <h6 class="mt-3">Email :</h6>
                <div class="input-group mb-1" style="width:70%;margin: 0 auto;">
                  <input type="text" class="form-control" id="input_email_customer_credit" placeholder="Email Customer" id="input_email_customer_credit" aria-label="Email Customer" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <i class="fas fa-paper-plane input-group-text" id="basic-addon2"></i>
                  </div>
                </div>
                <div id="error_email_credit" class="text-danger mb-3">*Email tidak valid!</div>

                <button type="button" id="btn-email-customer-credit" class="btn btn-primary btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-paper-plane"></i>
                  </span>
                  <span class="text">Kirim</span>
                </button>
              </div>

              <div id="form-sms-customer-credit" class="hide-any">
                <h6>Nama Customer :</h6>
                <input type="text" class="form-control mb-1" id="input_nama_cp_credit" placeholder="Nama" style="width:70%;display:block;margin: 0 auto;">
                <div id="error_nama_cp_credit" class="text-danger">*Nama harus diisi!</div>

                <h6 class="mt-3">No. HP Customer :</h6>
                <div class="input-group mb-1" style="width:70%;margin: 0 auto;">
                  <input type="text" id="input_cp_credit" class="form-control" placeholder="No. HP Customer" aria-label="No. HP Customer" aria-describedby="basic-addon1">
                  <div class="input-group-prepend">
                    <i class="fas fa-comments input-group-text" id="basic-addon1"></i>
                  </div>
                </div>
                <div id="error_cp_credit" class="text-danger mb-3">*No. HP tidak valid!</div>

                <button type="button" id="btn-cp-customer-credit" class="btn btn-primary btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-comments"></i>
                  </span>
                  <span class="text">Kirim</span>
                </button>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>

  </div>
</div>