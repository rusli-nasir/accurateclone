var table_pesanan, autonum_qty;

function createDataTable() {
  table_pesanan = $('#tablePesanan').DataTable({
    'paging': false
  });
}

function destroyDataTable() {
  if ($.fn.DataTable.isDataTable('#tablePesanan'))
    table_pesanan.destroy();
}

function createAutonumeric() {
  autonum_qty = new AutoNumeric.multiple(".input_qty", {
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    allowDecimalPadding: false,
    decimalPlaces: 0,
    emptyInputBehavior: "zero"
  });
}

function removeMultipleAutonumeric() {
  if (typeof autonum_qty !== 'undefined') {
    autonum_qty.forEach(item => {
      item.remove();
    });
  }
}

function unformatMultipleAutonumeric() {
  if (typeof autonum_qty !== 'undefined') {
    autonum_qty.forEach(item => {
      item.unformat();
    });
  }
}

function checkInputQtyTerima() {
  unformatMultipleAutonumeric();
  removeMultipleAutonumeric();
  statusInputQtyTerima = 0;
  jumlah_barang = parseInt($('.row_barang_added').length);

  if (jumlah_barang <= 0) {
    statusInputQtyTerima = 1;
  } else {
    $('.row_barang_added').each(function (item) {
      id_barang = $(this).attr('data-id');

      qty_barang = parseInt($('#insert_qty_terima_' + id_barang).val());
      qty_beli = parseInt($('#insert_qty_terbeli_' + id_barang).val());

      if (qty_barang > 0 && qty_barang <= qty_beli) {
        $('#insert_qty_terima_' + id_barang).removeClass("input-error");
        $('#error-qty-terima-kosong-' + id_barang).hide();
        $('#error-qty-terima-lebih-' + id_barang).hide();
      } else {
        if (qty_barang <= 0) {
          $('#insert_qty_terima_' + id_barang).addClass("input-error");
          $('#error-qty-terima-kosong-' + id_barang).show();
          statusInputQtyTerima = 2;
        } else {
          $('#insert_qty_terima_' + id_barang).removeClass("input-error");
          $('#error-qty-terima-kosong-' + id_barang).hide();
        }
        if (qty_barang > qty_beli) {
          $('#insert_qty_terima_' + id_barang).addClass("input-error");
          $('#error-qty-terima-lebih-' + id_barang).show();
          statusInputQtyTerima = 2;
        } else {
          $('#insert_qty_terima_' + id_barang).removeClass("input-error");
          $('#error-qty-terima-lebih-' + id_barang).hide();
        }
      }
    });
  }
  if (statusInputQtyTerima == 2)
    scrollToTop();
  createAutonumeric();
  return statusInputQtyTerima;
}

function formCheck() {
  supplier = $('#supplier_id').val();
  check_input = checkInputQtyTerima();

  if (supplier != 'kosong' && check_input == 0) {
    $('#supplier_id').removeClass("input-error");
    $('#error-supplier-kosong').hide();
    unformatMultipleAutonumeric();
    removeMultipleAutonumeric();
    return true;
  } else {
    if (supplier == 'kosong') {
      $('#supplier_id').addClass("input-error");
      $('#error-supplier-kosong').show();
    } else {
      $('#supplier_id').removeClass("input-error");
      $('#error-supplier-kosong').hide();
    }

    if (check_input == 1) {
      $.confirm({
        title: 'Error!',
        content: 'Tidak ada barang yang dibeli!',
        type: 'red',
        typeAnimated: true,
        buttons: {
          CLOSE: function () {}
        }
      });
    }
    scrollToTop();
    return false;
  }
}

$(document).ready(function () {
  var select_supplier = $('#supplier_id');
  select_supplier.data("current", "kosong");
  $('#btn-pilih-pesanan').click(function () {
    supplier = $('#supplier_id').val();

    if (supplier != 'kosong') {
      $('#modal-pilih-pesanan').show();
    } else {
      $.confirm({
        title: 'Error!',
        content: 'Pilih supplier dahulu!',
        type: 'red',
        typeAnimated: true,
        buttons: {
          CLOSE: function () {}
        }
      });
    }
  });
  $('#btn-close').click(function () {
    $('#modal-pilih-pesanan').hide();
  });
  $('#tanggal').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '2020-01-01',
    autoHide: true,
    startView: 1
  });
  $('#tanggal').datepicker('setDate', $('#tanggal').val());
  $('#supplier_id').change(function () {
    id = $(this).val();
    row_barang_pesanan = $('.row_barang_added').length;

    if (row_barang_pesanan <= 0) {
      if (id != 'kosong') {
        alamat = $('#alamat_supplier_' + id).val();
        $('#alamat_supplier').val(alamat);
      } else
        $('#alamat_supplier').val('');
      $(this).data("current", $(this).val());
      $.ajax({
        type: 'POST',
        url: base_url + 'Pembelian/PenerimaanBarang/getTableListPesanan/' + id,
        dataType: 'JSON',
        success: function (response) {
          console.log(response);
          // destroyDataTable();
          $('#data-table-pesanan').html(response.html);
          // createDataTable();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(xhr.responseText);
        }
      });
    } else {
      previous_data_value = $(this).data("current");
      $(this).val(previous_data_value);
      $.confirm({
        title: 'Error!',
        content: 'Supplier tidak bisa diganti kecuali semua barang dihapus dahulu !',
        type: 'red',
        typeAnimated: true,
        buttons: {
          CLOSE: function () {}
        }
      });
      return false;
    }
  });
  $('#form').submit(function () {
    if (formCheck())
      return true;
    else
      return false;
  })
  $('#getListBarangPesanan').submit(function () {
    tes = $(this).serialize();
    $.ajax({
      type: 'POST',
      data: tes,
      url: base_url + 'Pembelian/PenerimaanBarang/getListRowBarangPesanan',
      dataType: 'JSON',
      success: function (response) {
        // console.log(response);
        unformatMultipleAutonumeric();
        removeMultipleAutonumeric();
        $('#bodyListBarangDiterima').html(response.html);
        $('#modal-pilih-pesanan').hide();
        createAutonumeric();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.responseText);
      }
    });
    return false;
  });
});