var table_pesanan, autonum_qty;

function createDataTable() {
  table_pesanan = $('#tablePesanan').DataTable({
    'paging': false,
    'order': [0, 'desc']
  });
}

function createDatePicker() {
  $('#tanggal').datepicker('destroy');
  $('#tanggal').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '2020-01-01',
    autoHide: true,
    startView: 1
  });
  $('#tanggal').datepicker('setDate', $('#tanggal').val());
}

function createAutonumeric() {
  autonum_qty = new AutoNumeric.multiple(".input_qty", {
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    allowDecimalPadding: false,
    decimalPlaces: 0,
    emptyInputBehavior: "zero",
    minimumValue: "0"
  });
}

function removeMultipleAutonumeric() {
  if (typeof autonum_qty !== 'undefined') {
    autonum_qty.forEach(item => {
      if (AutoNumeric.isManagedByAutoNumeric(item.domElement))
        item.remove();
    });
  }
}

function unformatMultipleAutonumeric() {
  if (typeof autonum_qty !== 'undefined') {
    autonum_qty.forEach(item => {
      if (AutoNumeric.isManagedByAutoNumeric(item.domElement))
        item.unformat();
    });
  }
}

function checkInputQtyTerima() {
  unformatMultipleAutonumeric();
  removeMultipleAutonumeric();
  statusInputQtyTerima = true;
  jumlah_barang = parseInt($('.row_barang_added').length);

  $('.row_barang_added').each(function (item) {
    id_barang = $(this).attr('data-id');

    qty_barang = parseInt($('#insert_qty_terima_' + id_barang).val());
    qty_beli = parseInt($('#insert_qty_terbeli_' + id_barang).val());

    if (qty_barang <= qty_beli) {
      $('#insert_qty_terima_' + id_barang).removeClass("input-error");
      $('#error-qty-terima-lebih-' + id_barang).hide();
    } else {
      if (qty_barang > qty_beli) {
        $('#insert_qty_terima_' + id_barang).addClass("input-error");
        $('#error-qty-terima-lebih-' + id_barang).show();
        statusInputQtyTerima = false;
      } else {
        $('#insert_qty_terima_' + id_barang).removeClass("input-error");
        $('#error-qty-terima-lebih-' + id_barang).hide();
      }
    }
  });
  createAutonumeric();
  return statusInputQtyTerima;
}

function getViewFormPenerimaanBarang(id_form_pembelian) {
  $.ajax({
    type: 'POST',
    url: base_url + 'Pembelian/PenerimaanBarang/getViewPenerimaanBarang/' + id_form_pembelian,
    dataType: 'JSON',
    success: function (response) {
      // console.log(response);
      unformatMultipleAutonumeric();
      removeMultipleAutonumeric();
      $('#view-penerimaan-barang').html(response.html);
      $('#modal-pilih-pesanan').hide();
      createAutonumeric();
      createDatePicker();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr.responseText);
    }
  });
}

$(document).ready(function () {
  createDataTable();
  $('#btn-pilih-pesanan').click(function () {
    $('#modal-pilih-pesanan').show();
  });
  $('#btn-close').click(function () {
    $('#modal-pilih-pesanan').hide();
  });
  $('input[name=add_pesanan]').click(function () {
    terpilih = $('#pesanan_terpilih').val();
    id_pesanan = $(this).val();
    no_pesanan = $(this).attr('data-no-pesanan');
    if (terpilih == '') {
      $('#pesanan_terpilih').val(id_pesanan);
      $('#id_pesanan').val(id_pesanan);
      $('#kode_pesanan').val(no_pesanan);
      getViewFormPenerimaanBarang(id_pesanan);
    } else {
      $.confirm({
        title: 'Hapus Data Produk',
        content: 'Apakah anda yakin untuk mengganti pesanan pembelian? Data pesanan pembelian sebelumnya akan terhapus!',
        type: 'red',
        typeAnimated: true,
        buttons: {
          YES: {
            btnClass: 'btn-red',
            action: function () {
              $('#pesanan_terpilih').val(id_pesanan);
              $('#id_pesanan').val(id_pesanan);
              $('#kode_pesanan').val(no_pesanan);
              getViewFormPenerimaanBarang(id_pesanan);
            }
          },
          CANCEL: function () {
            id_radio_previous = '#add_pesanan_' + terpilih;
            $('#getListBarangPesanan').trigger('reset');
            $('#pesanan_terpilih').val(terpilih);
            $(id_radio_previous).prop('checked', true);
            $('#modal-pilih-pesanan').hide();
          }
        }
      });
    }
  });
  $(document).on('submit', '#form', function () {
    if (checkInputQtyTerima()) {
      unformatMultipleAutonumeric();
      removeMultipleAutonumeric();
      return true;
    } else
      return false;
  });
});