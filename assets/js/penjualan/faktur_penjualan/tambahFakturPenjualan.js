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

function getViewFormFakturPenjualan(id_delivery) {
  $.ajax({
    type: 'POST',
    url: base_url + 'Penjualan/FakturPenjualan/getViewFormFakturPenjualan/' + id_delivery,
    dataType: 'JSON',
    success: function (response) {
      console.log(response);
      unformatMultipleAutonumeric();
      removeMultipleAutonumeric();
      $('#view-faktur-penjualan').html(response.html);
      $('#modal-pilih-pengiriman').hide();
      createAutonumeric();
      createDatePicker();
      hitungFormPenjualan();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.responseText);
    }
  });
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

$(document).ready(function () {
  $('#btn-pilih-pengiriman').click(function () {
    $('#modal-pilih-pengiriman').show();
  });
  $('#btn-close').click(function () {
    $('#modal-pilih-pengiriman').hide();
  });

  $('input[name=add_pengiriman]').click(function () {
    terpilih_before = $('#id_pengiriman_before').val();
    id_delivery = $(this).val();
    no_delivery = $(this).attr('data-no-pesanan');
    if (terpilih_before == 'kosong') {
      $('#id_pengiriman_before').val(id_delivery);
      $('#kode_pesanan').val(no_delivery);
      getViewFormFakturPenjualan(id_delivery);
    } else {
      $.confirm({
        title: 'Hapus Data Fakur',
        content: 'Apakah anda yakin untuk mengganti data pengiriman untuk faktur ini? Data faktur sebelumnya akan terhapus!',
        type: 'red',
        typeAnimated: true,
        buttons: {
          YES: {
            btnClass: 'btn-red',
            action: function () {
              $('#id_pengiriman_before').val(id_delivery);
              $('#kode_pesanan').val(no_delivery);
              getViewFormPenerimaanBarang(id_pesanan);
            }
          },
          CANCEL: function () {
            $('#getListPengirimanBarang').trigger('reset');
            $('#id_pengiriman_before').val(terpilih_before);
            $('#add_pesanan_' + terpilih_before).prop('checked', true);
            $('#modal-pilih-pesanan').hide();
          }
        }
      });
    }
  });

  $('#form').submit(function () {
    unformatMultipleAutonumeric();
    removeMultipleAutonumeric();
    return true;
  });
});