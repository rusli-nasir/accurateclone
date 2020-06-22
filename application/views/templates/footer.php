  </div>
  <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Grafika 2019</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Apakah anda yakin untuk logout dari sesi sekarang?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary load-link" href="<?= base_url("Auth/logout"); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('vendor/sbadmin2/'); ?>js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/chart.js/Chart.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/dataTables.rowGroup.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/dataTables.buttons.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/buttons.flash.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/jszip.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/pdfmake.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/vfs_fonts.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/buttons.html5.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/buttons.print.min.js"></script>
  <script src="<?= base_url("plugin/autoNumeric/"); ?>autoNumeric.min.js"></script>

  <!-- Custom Modal -->
  <script src="<?= base_url('plugin/jquery-confirm/'); ?>jquery-confirm.min.js"></script>
  <script src="<?= base_url('assets/js/'); ?>ajax-modal.js"></script>
  <script src="<?= base_url('assets/js/'); ?>form-custom.js"></script>
  <script src="<?= base_url('plugin/datepicker/'); ?>datepicker.min.js"></script>

  <!-- Page level custom scripts -->

  <?php if ($this->uri->segment(1) == "redirect" && $this->uri->segment(2) == "InfoPerusahaan" && ($this->uri->segment(3) == "" || $this->uri->segment(3) == "index")) { ?>
    <script src="<?= base_url('assets/js/'); ?>InfoPerusahaan.js"></script>
  <?php } ?>

  <!-- ======================================================================================== -->
  <!-- PERSEDIAAN -->
  <!-- ======================================================================================== -->

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "DaftarGudang" && $this->uri->segment(3) == "tambahGudang") { ?>
    <script src="<?= base_url('assets/js/persediaan/daftar_gudang/'); ?>tambahGudang.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "DaftarGudang" && $this->uri->segment(3) == "editGudang") { ?>
    <script src="<?= base_url('assets/js/persediaan/daftar_gudang/'); ?>editGudang.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "BarangJasa" && $this->uri->segment(3) == "tambahKategoriBarang") { ?>
    <script src="<?= base_url('assets/js/persediaan/barang_jasa/'); ?>tambahKategoriBarang.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "BarangJasa" && $this->uri->segment(3) == "editKategoriBarang") { ?>
    <script src="<?= base_url('assets/js/persediaan/barang_jasa/'); ?>editKategoriBarang.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "BarangJasa" && ($this->uri->segment(3) == "" || $this->uri->segment(3) == "index")) { ?>
    <script src="<?= base_url('assets/js/persediaan/barang_jasa/'); ?>index.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "BarangJasa" && $this->uri->segment(3) == "tambahBarangJasa") { ?>
    <script src="<?= base_url('assets/js/persediaan/barang_jasa/'); ?>tambahBarangJasa.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "BarangJasa" && $this->uri->segment(3) == "editBarangJasa") { ?>
    <script src="<?= base_url('assets/js/persediaan/barang_jasa/'); ?>editBarangJasa.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "SetHargaPenjualan" && ($this->uri->segment(3) == "" || $this->uri->segment(3) == "index")) { ?>
    <script src="<?= base_url('assets/js/persediaan/set_harga_penjualan/'); ?>index.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "SetHargaPenjualan" && $this->uri->segment(3) == "tambahSetHargaPenjualan") { ?>
    <script src="<?= base_url('assets/js/persediaan/set_harga_penjualan/'); ?>tambahSetHargaPenjualan.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "SetHargaPenjualan" && $this->uri->segment(3) == "editSetHargaPenjualan") { ?>
    <script src="<?= base_url('assets/js/persediaan/set_harga_penjualan/'); ?>editSetHargaPenjualan.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "PenyeseuaianPersediaan" && ($this->uri->segment(3) == "" || $this->uri->segment(3) == "index")) { ?>
    <script src="<?= base_url('assets/js/persediaan/penyesuaian_persediaan/'); ?>index.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "PenyeseuaianPersediaan" && $this->uri->segment(3) == "tambahPenyeseuaianPersediaan") { ?>
    <script src="<?= base_url('assets/js/persediaan/penyesuaian_persediaan/'); ?>tambahPenyeseuaianPersediaan.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "PenyeseuaianPersediaan" && $this->uri->segment(3) == "editPenyeseuaianPersediaan") { ?>
    <script src="<?= base_url('assets/js/persediaan/penyesuaian_persediaan/'); ?>editPenyeseuaianPersediaan.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "PindahBarang" && ($this->uri->segment(3) == "" || $this->uri->segment(3) == "index")) { ?>
    <script src="<?= base_url('assets/js/persediaan/pindah_barang/'); ?>index.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "PindahBarang" && $this->uri->segment(3) == "tambahPemindahanBarang") { ?>
    <script src="<?= base_url('assets/js/persediaan/pindah_barang/'); ?>tambahPemindahanBarang.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Persediaan" && $this->uri->segment(2) == "PindahBarang" && $this->uri->segment(3) == "editPemindahanBarang") { ?>
    <script src="<?= base_url('assets/js/persediaan/pindah_barang/'); ?>editPemindahanBarang.js"></script>
  <?php } ?>

  <!-- ======================================================================================== -->
  <!-- DAFTAR -->
  <!-- ======================================================================================== -->

  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "Pengguna" && $this->uri->segment(3) == "tambahPengguna") { ?>
    <script src="<?= base_url('assets/js/daftar/pengguna/'); ?>tambahPengguna.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "Pengguna" && $this->uri->segment(3) == "editPengguna") { ?>
    <script src="<?= base_url('assets/js/daftar/pengguna/'); ?>editPengguna.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "Pengguna" && $this->uri->segment(3) == "tambahDivisi") { ?>
    <script src="<?= base_url('assets/js/daftar/pengguna/'); ?>tambahDivisi.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "Pengguna" && $this->uri->segment(3) == "editDivisi") { ?>
    <script src="<?= base_url('assets/js/daftar/pengguna/'); ?>editDivisi.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "Pemasok" && ($this->uri->segment(3) == "" || $this->uri->segment(3) == "index")) { ?>
    <script src="<?= base_url('assets/js/daftar/pemasok/'); ?>index.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "Pemasok" && ($this->uri->segment(3) == "tambahPemasok" || $this->uri->segment(3) == "editPemasok")) { ?>
    <script src="<?= base_url('assets/js/daftar/pemasok/'); ?>tambahPemasok.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "Pelanggan" && ($this->uri->segment(3) == "" || $this->uri->segment(3) == "index")) { ?>
    <script src="<?= base_url('assets/js/daftar/pelanggan/'); ?>index.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "Pelanggan" && ($this->uri->segment(3) == "tambahPelanggan" || $this->uri->segment(3) == "editPelanggan")) { ?>
    <script src="<?= base_url('assets/js/daftar/pelanggan/'); ?>tambahPelanggan.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "JasaPengiriman" && ($this->uri->segment(3) == "" || $this->uri->segment(3) == "index")) { ?>
    <script src="<?= base_url('assets/js/daftar/pelanggan/'); ?>index.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Daftar" && $this->uri->segment(2) == "JasaPengiriman" && ($this->uri->segment(3) == "tambahJasaPengiriman" || $this->uri->segment(3) == "editJasaPengiriman")) { ?>
    <script src="<?= base_url('assets/js/daftar/pelanggan/'); ?>tambahPelanggan.js"></script>
  <?php } ?>

  <!-- ======================================================================================== -->
  <!-- PEMBELIAN -->
  <!-- ======================================================================================== -->

  <?php if ($this->uri->segment(1) == "Pembelian" && $this->uri->segment(2) == "PesananPembelian" && $this->uri->segment(3) == "tambahPembelian") { ?>
    <script src="<?= base_url('assets/js/pembelian/pesanan_pembelian/'); ?>tambahPembelian.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Pembelian" && $this->uri->segment(2) == "PesananPembelian" && $this->uri->segment(3) == "editPembelian") { ?>
    <script src="<?= base_url('assets/js/pembelian/pesanan_pembelian/'); ?>editPembelian.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Pembelian" && $this->uri->segment(2) == "PenerimaanBarang" && $this->uri->segment(3) == "tambahPenerimaanBarang") { ?>
    <script src="<?= base_url('assets/js/pembelian/penerimaan_barang/'); ?>tambahPenerimaanBarang.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Pembelian" && $this->uri->segment(2) == "PenerimaanBarang" && $this->uri->segment(3) == "editPenerimaanBarang") { ?>
    <script src="<?= base_url('assets/js/pembelian/penerimaan_barang/'); ?>editPenerimaanBarang.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Pembelian" && $this->uri->segment(2) == "FakturPembelian" && $this->uri->segment(3) == "tambahFakturPembelian") { ?>
    <script src="<?= base_url('assets/js/pembelian/faktur_pembelian/'); ?>tambahFakturPembelian.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Pembelian" && $this->uri->segment(2) == "FakturPembelian" && $this->uri->segment(3) == "editFakturPembelian") { ?>
    <script src="<?= base_url('assets/js/pembelian/faktur_pembelian/'); ?>editFakturPembelian.js"></script>
  <?php } ?>

  <!-- ======================================================================================== -->
  <!-- PENJUALAN -->
  <!-- ======================================================================================== -->

  <?php if ($this->uri->segment(1) == "Penjualan" && $this->uri->segment(2) == "PesananPenjualan" && $this->uri->segment(3) == "tambahPesananPenjualan") { ?>
    <script src="<?= base_url('assets/js/penjualan/pesanan_penjualan/'); ?>tambahPesananPenjualan.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Penjualan" && $this->uri->segment(2) == "PesananPenjualan" && $this->uri->segment(3) == "editPesananPenjualan") { ?>
    <script src="<?= base_url('assets/js/penjualan/pesanan_penjualan/'); ?>editPesananPenjualan.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Penjualan" && $this->uri->segment(2) == "PengirimanPesanan" && $this->uri->segment(3) == "tambahPengirimanPesanan") { ?>
    <script src="<?= base_url('assets/js/penjualan/pengiriman_pesanan/'); ?>tambahPengirimanPesanan.js"></script>
  <?php } ?>
  <?php if ($this->uri->segment(1) == "Penjualan" && $this->uri->segment(2) == "PengirimanPesanan" && $this->uri->segment(3) == "editPengirimanPesanan") { ?>
    <script src="<?= base_url('assets/js/penjualan/pengiriman_pesanan/'); ?>editPengirimanPesanan.js"></script>
  <?php } ?>

  <!-- End of page level custom scripts -->

  <script>
    function scrollToTop() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }
    $(document).ready(function() {
      jconfirm.defaults = {
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false
      };
      $('#container-wait').hide();
      $(".alert").fadeTo(5000, 500).slideUp(500, function() {
        $(".alert").slideUp(500);
      });
      $("a").click(function() {
        toggle = $(this).attr('data-toggle');
        if (toggle != 'dropdown' && toggle != 'modal')
          $('#container-wait').show();
      });
      setTimeout(function() {
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
      }, 3000);
    });
  </script>

  </body>

  </html>