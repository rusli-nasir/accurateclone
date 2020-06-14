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
      $('#insert_qty_terima_' + id_barang).addClass("input-error");
      $('#error-qty-terima-lebih-' + id_barang).show();
      statusInputQtyTerima = false;
    }
  });
  createAutonumeric();
  return statusInputQtyTerima;
}

$(document).ready(function () {
  createAutonumeric();
  $('#tanggal').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '2020-01-01',
    autoHide: true,
    startView: 1
  });
  $('#tanggal').datepicker('setDate', $('#tanggal').val());
  $(document).on('submit', '#form', function () {
    if (checkInputQtyTerima()) {
      unformatMultipleAutonumeric();
      removeMultipleAutonumeric();
      return true;
    } else
      return false;
  });
  $('#btn-delete').click(function () {
    url = $(this).attr('href');
    $.confirm({
      title: 'Hapus Data Produk',
      content: 'Apakah anda yakin untuk menghapus data penerimaan barang ini?',
      type: 'red',
      typeAnimated: true,
      buttons: {
        DELETE: {
          btnClass: 'btn-red',
          action: function () {
            window.location.replace(url);
          }
        },
        CANCEL: function () {}
      }
    });
  });
});