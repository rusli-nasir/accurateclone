var autonum_qty, autonum_harga, autonum_diskon;

function createAutonumeric() {
  if (typeof autonum_qty !== 'undefined' && typeof autonum_harga !== 'undefined' && typeof autonum_diskon !== 'undefined')
    removeMultipleAutonumeric();

  autonum_qty = new AutoNumeric.multiple(".input_qty", {
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    allowDecimalPadding: false,
    decimalPlaces: 0,
    emptyInputBehavior: "zero"
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

function createAutonumericOnly() {
  autonum_qty = new AutoNumeric.multiple(".input_qty", {
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    allowDecimalPadding: false,
    decimalPlaces: 0,
    emptyInputBehavior: "zero"
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
  autonum_qty.forEach(item => {
    item.remove();
  });
  autonum_harga.forEach(item => {
    item.remove();
  });
  autonum_diskon.forEach(item => {
    item.remove();
  });
}

function unformatMultipleAutonumeric() {
  autonum_qty.forEach(item => {
    item.unformat();
  });
  autonum_harga.forEach(item => {
    item.unformat();
  });
  autonum_diskon.forEach(item => {
    item.unformat();
  });
  removeMultipleAutonumeric();
}

function checkInputBarang() {
  unformatMultipleAutonumeric();
  statusInputBarang = true;
  jumlah_barang = parseInt($('.row_barang_added').length);

  if (jumlah_barang <= 0) {
    statusInputBarang = false;
    $.confirm({
      title: 'Error!',
      content: 'Tidak ada barang yang dibeli!',
      type: 'red',
      typeAnimated: true,
      buttons: {
        CLOSE: function () {}
      }
    });
  } else {
    $('.row_barang_added').each(function (item) {
      id_barang = $(this).attr('data-id');

      qty_barang = parseInt($('#qty_beli_' + id_barang).val());
      harga_barang = parseInt($('#harga_unit_' + id_barang).val());

      if (qty_barang > 0 && harga_barang > 0) {
        $('#qty_beli_' + id_barang).removeClass("input-error");
        $('#error-qty-beli-kosong-' + id_barang).hide();
        $('#harga_unit_' + id_barang).removeClass("input-error");
        $('#error-harga-unit-kosong-' + id_barang).hide();
      } else {
        if (qty_barang <= 0) {
          $('#qty_beli_' + id_barang).addClass("input-error");
          $('#error-qty-beli-kosong-' + id_barang).show();
          scrollToTop();
        } else {
          $('#qty_beli_' + id_barang).removeClass("input-error");
          $('#error-qty-beli-kosong-' + id_barang).hide();
        }

        if (harga_barang <= 0) {
          $('#harga_unit_' + id_barang).addClass("input-error");
          $('#error-harga-unit-kosong-' + id_barang).show();
          scrollToTop();
        } else {
          $('#harga_unit_' + id_barang).removeClass("input-error");
          $('#error-harga-unit-kosong-' + id_barang).hide();
        }
        statusInputBarang = false;
      }
    });
  }
  createAutonumericOnly();
  return statusInputBarang;
}

function formCheck() {
  supplier = $('#supplier_id').val();
  ship_to = $('#alamat_diterima').val();
  check_input = checkInputBarang();

  if (supplier != 'kosong' && ship_to != '' && check_input) {
    $('#supplier_id').removeClass("input-error");
    $('#error-supplier-kosong').hide();
    $('#alamat_diterima').removeClass("input-error");
    $('#error-ship-to-kosong').hide();
    unformatMultipleAutonumeric();
    return true;
  } else {
    if (supplier == 'kosong') {
      $('#supplier_id').addClass("input-error");
      $('#error-supplier-kosong').show();
      scrollToTop();
    } else {
      $('#supplier_id').removeClass("input-error");
      $('#error-supplier-kosong').hide();
    }

    if (ship_to == '') {
      $('#alamat_diterima').addClass("input-error");
      $('#error-ship-to-kosong').show();
      scrollToTop();
    } else {
      $('#alamat_diterima').removeClass("input-error");
      $('#error-ship-to-kosong').hide();
    }
    return false;
  }
}

function hitungFormPembelian() {
  unformatMultipleAutonumeric();
  subtotal_overall = 0;
  $('.row_barang_added').each(function (item) {
    id_barang = $(this).attr('data-id');

    qty_barang = parseInt($('#qty_beli_' + id_barang).val());
    harga_barang = parseInt($('#harga_unit_' + id_barang).val());
    diskon_barang = parseInt($('#diskon_' + id_barang).val());

    subtotal = qty_barang * harga_barang;
    diskon_subtotal = subtotal * diskon_barang / 100;
    subtotal = subtotal - diskon_subtotal;
    subtotal_overall += subtotal;
    $('#subtotal_' + id_barang).val(subtotal);
  });
  $('#subtotal_overall').val(subtotal_overall);
  diskon_overall = parseInt($('#diskon_overall').val());
  jumlah_diskon_overall = subtotal_overall * diskon_overall / 100;
  $('#jumlah_diskon_overall').val(jumlah_diskon_overall);
  is_hitung_ppn = $("#is_hitung_ppn:checkbox:checked").length;
  total_ppn = 0;
  if (is_hitung_ppn == 1) {
    total_ppn = (subtotal_overall - jumlah_diskon_overall) * 10 / 100;
  }
  $('#pajak_ppn').val(total_ppn);
  biaya_pengiriman = parseInt($('#biaya_pengiriman').val());
  total_biaya = subtotal_overall - jumlah_diskon_overall + total_ppn + biaya_pengiriman;
  $('#total_biaya').val(total_biaya);
  createAutonumericOnly();
}

$(document).ready(function () {
  createAutonumericOnly();
  $('#btn-pilih-barang').click(function () {
    $('#modal-pilih-barang').show();
  });
  $('#btn-close').click(function () {
    $('#modal-pilih-barang').hide();
  });
  $('#btn-close-dp, #btn-cancel-dp').click(function () {
    $('#modal-uang-muka').hide();
  });
  $('#tanggal').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '2020-01-01',
    autoHide: true,
    startView: 1
  });
  $('#tanggal').datepicker('setDate', $('#tanggal').val());
  var table_barang = $('#tableBarang').DataTable({
    'paging': false
  });
  $('#supplier_id').change(function () {
    id = $(this).val();

    if (id != 'kosong') {
      alamat = $('#alamat_supplier_' + id).val();
      $('#alamat_supplier').val(alamat);
    } else
      $('#alamat_supplier').val('');
  });

  $('#select-alamat-ship-to').change(function () {
    id = $(this).val();

    if (id != 'custom') {
      alamat = $('#alamat_id_' + id).val();
      $('#alamat_diterima').val(alamat);
    }
  });

  $('.btn-tambah-list-barang').click(function () {
    id_barang = $(this).attr('data-id');
    value_of_id = '#is_added_' + id_barang;
    is_any_before = '#is_any_before_' + id_barang;

    if ($(value_of_id).val() == '0') {
      if ($(is_any_before).val() == 1) {
        $('#is_delete_' + id_barang).val('0');
        $('#modal-pilih-barang').hide();
        $('#icon-plus-id-' + id_barang).hide();
        $('#icon-check-id-' + id_barang).show();
        $('#row_barang_any_before_id_' + id_barang).show();
        $('#qty_beli_' + id_barang).val('0');
        $('#harga_unit_' + id_barang).val('0');
        $('#diskon_' + id_barang).val('0');
        $('#subtotal_' + id_barang).val('0');
        createAutonumeric();
      } else {
        $.ajax({
          type: 'POST',
          url: base_url + 'Pembelian/PesananPembelian/addRowPesananPembelian/' + id_barang,
          dataType: 'JSON',
          success: function (response) {
            console.log(response);
            $('#tableListPembelian > tbody:last-child').append(response.html);
            createAutonumeric();
            $('#modal-pilih-barang').hide();
            $('#icon-plus-id-' + id_barang).hide();
            $('#icon-check-id-' + id_barang).show();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
          }
        });
      }
    }
    $(value_of_id).val('1');
  });

  $(document).on('click', '.btn-hapus-row-barang', function () {
    id_barang = $(this).attr('data-id');
    is_update = $(this).attr('data-is-update');
    if (is_update == 'yes') {
      $('#row_barang_any_before_id_' + id_barang).hide();
      $('#is_added_' + id_barang).val('0');
      $('#icon-plus-id-' + id_barang).show();
      $('#icon-check-id-' + id_barang).hide();
      $('#is_delete_' + id_barang).val('1');
      $('#qty_beli_' + id_barang).val('1');
      $('#harga_unit_' + id_barang).val('1');
      $('#diskon_' + id_barang).val('1');
      $('#subtotal_' + id_barang).val('1');
      createAutonumeric();
    } else {
      $('#row_barang_id_' + id_barang).remove();
      $('#is_added_' + id_barang).val('0');
      $('#icon-plus-id-' + id_barang).show();
      $('#icon-check-id-' + id_barang).hide();
    }
  });

  $(document).on('change', '.input_qty, .input_harga, .input_diskon', function () {
    hitungFormPembelian();
  });

  $('#is_hitung_ppn').click(function () {
    hitungFormPembelian();
  });

  $('#is_uang_muka_enabled').click(function () {
    is_checked = $('#is_uang_muka_enabled:checked').length;
    if (is_checked === 1) {
      $(this).prop('checked', false);
      $('#modal-uang-muka').show();
    }
  });
  $('#btn-save-dp').click(function () {
    $('#is_uang_muka_enabled').prop('checked', true);
    $('#modal-uang-muka').hide();
  });

  $('#form').submit(function () {
    if (formCheck())
      return true;
    else
      return false;
  });

  $('#btn-delete').click(function () {
    url = $(this).attr('href');
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

  $('#tes').click(function () {
    cek = $("#is_hitung_ppn").val();
    // cek = $("#is_hitung_ppn:checkbox:checked").length;
    alert(cek);
  });
});