$(document).ready(function () {

  { // Event tiap checkboxes
    // Check All
    $("#check_all_fitur").click(function () {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    // Persediaan
    $('#persediaan').click(function () {
      $('.persediaan').not(this).prop('checked', this.checked);
    });
    $('.persediaan').change(function () {
      if ($('.persediaan:input:checked').length > 0) {
        $('#persediaan').prop('checked', true);
      } else
        $('#persediaan').prop('checked', false);
    });


    // Penjualan
    $('#penjualan').click(function () {
      $('.penjualan').not(this).prop('checked', this.checked);
    });
    $('.penjualan').change(function () {
      if ($('.penjualan:input:checked').length > 0) {
        $('#penjualan').prop('checked', true);
      } else
        $('#penjualan').prop('checked', false);
    });

    // Pembelian
    $('#pembelian').click(function () {
      $('.pembelian').not(this).prop('checked', this.checked);
    });
    $('.pembelian').change(function () {
      if ($('.pembelian:input:checked').length > 0) {
        $('#pembelian').prop('checked', true);
      } else
        $('#pembelian').prop('checked', false);
    });
    // Daftar
    $('#daftar').click(function () {
      $('.daftar').not(this).prop('checked', this.checked);
    });
    $('.daftar').change(function () {
      if ($('.daftar:input:checked').length > 0) {
        $('#daftar').prop('checked', true);
      } else
        $('#daftar').prop('checked', false);
    });
  }

  $('#form-tambah-pengguna').submit(function () {
    nama_divisi = $('#nama_divisi').val();
    if (!nama_divisi) {
      $('.error_nama_divisi').show();
      $('#nama_divisi').addClass("input-error");
      scrollToTop();
      return false;
    } else {
      $('.error_nama_divisi').hide();
      return true;
    }
  });
});