var autonum_qty, autonum_harga, autonum_diskon;

function createAutonumeric() {
  autonum_qty = new AutoNumeric.multiple(".input_qty", {
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    allowDecimalPadding: false,
    decimalPlaces: 0,
    emptyInputBehavior: "zero",
    minimumValue: "0"
  });
  autonum_harga = new AutoNumeric.multiple(".input_harga", {
    currencySymbol: "Rp ",
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    allowDecimalPadding: false,
    decimalPlaces: 0,
    emptyInputBehavior: "zero"
  });
  autonum_diskon = new AutoNumeric.multiple(".input_diskon", {
    suffixText: "%",
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
      if (AutoNumeric.isManagedByAutoNumeric(item.domElement))
        item.remove();
    });
    autonum_harga.forEach(item => {
      if (AutoNumeric.isManagedByAutoNumeric(item.domElement))
        item.remove();
    });
    autonum_diskon.forEach(item => {
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
    autonum_harga.forEach(item => {
      if (AutoNumeric.isManagedByAutoNumeric(item.domElement))
        item.unformat();
    });
    autonum_diskon.forEach(item => {
      if (AutoNumeric.isManagedByAutoNumeric(item.domElement))
        item.unformat();
    });
  }
}

function hitungFormPenjualan() {
  unformatMultipleAutonumeric();
  removeMultipleAutonumeric();
  subtotal_overall = 0;
  $('.row_barang_added').each(function (item) {
    row_id = $(this).attr('data-row-id');

    qty_kirim = parseInt($('#qty_terkirim_' + row_id).val());
    harga_unit = parseInt($('#harga_unit_' + row_id).val());
    diskon_barang = parseInt($('#diskon_' + row_id).val());

    subtotal = qty_kirim * harga_unit;
    diskon_subtotal = subtotal * diskon_barang / 100;
    subtotal = subtotal - diskon_subtotal;
    subtotal_overall += subtotal;
    $('#subtotal_' + row_id).val(subtotal);
  });
  $('#subtotal_overall').val(subtotal_overall);
  diskon_overall = parseInt($('#diskon_overall').val());
  jumlah_diskon_overall = subtotal_overall * diskon_overall / 100;
  $('#jumlah_diskon_overall').val(jumlah_diskon_overall);
  $('#jumlah_diskon_overall').val(jumlah_diskon_overall);
  biaya_pengiriman = parseInt($('#biaya_pengiriman').val());
  total_biaya = subtotal_overall - jumlah_diskon_overall + biaya_pengiriman;
  $('#total_biaya').val(total_biaya);
  createAutonumeric();
}

function createDatePicker() {
  $('#tanggal_faktur').datepicker('destroy');
  $('#tanggal_faktur').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '2020-01-01',
    autoHide: true,
    startView: 1
  });
  $('#tanggal_faktur').datepicker('setDate', $('#tanggal_faktur').val());
}


$(document).ready(function () {
  hitungFormPenjualan();
  createDatePicker();
  createDatePicker();

  $('#form').submit(function () {
    unformatMultipleAutonumeric();
    removeMultipleAutonumeric();
    return true;
  });

  $('#btn-delete').click(function () {
    url = $(this).attr('href');
    // alert(url)
    $.confirm({
      title: 'Hapus Data Produk',
      content: 'Apakah anda yakin untuk menghapus data pesanan pembelian ini?',
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

  $('.sub-fitur').click(function () {
    id_view = '#' + $(this).attr('data-id');
    $('.view-faktur').hide();
    $('.sub-fitur').removeClass('active');
    $(this).addClass('active');
    $(id_view).show();
  })
});