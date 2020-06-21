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

function checkInputBarang() {
  unformatMultipleAutonumeric();
  removeMultipleAutonumeric();
  statusInputBarang = true;

  jumlah_barang = 0;
  $('.row_barang_added').each(function (item) {
    row_id = $(this).attr('data-row-id');
    is_any_before = $(this).attr('data-is-any-before');

    if (is_any_before != 'yes') {
      insert_qty_jual = parseInt($('#insert_qty_jual_' + row_id).val());
      stok_sekarang = parseInt($('#stok_terbaru_' + row_id).val());
      harga_barang = parseInt($('#insert_harga_unit_' + row_id).val());

      if (insert_qty_jual > 0 && insert_qty_jual <= stok_sekarang && harga_barang > 0) {
        $('#insert_qty_jual_' + row_id).removeClass("input-error");
        $('#error-qty-jual-kosong-' + row_id).hide();
        $('#insert_qty_jual_' + row_id).removeClass("input-error");
        $('#error-qty-jual-lebih-' + row_id).hide();
        $('#insert_harga_unit_' + row_id).removeClass("input-error");
        $('#error-harga-unit-kosong-' + row_id).hide();
      } else {
        if (insert_qty_jual <= 0) {
          $('#insert_qty_jual_' + row_id).addClass("input-error");
          $('#error-qty-jual-kosong-' + row_id).show();
        } else {
          $('#insert_qty_jual_' + row_id).removeClass("input-error");
          $('#error-qty-jual-kosong-' + row_id).hide();
        }
        if (insert_qty_jual > stok_sekarang) {
          $('#insert_qty_jual_' + row_id).addClass("input-error");
          $('#error-qty-jual-lebih-' + row_id).show();
        } else {
          $('#insert_qty_jual_' + row_id).removeClass("input-error");
          $('#error-qty-jual-lebih-' + row_id).hide();
        }

        if (harga_barang <= 0) {
          $('#insert_harga_unit_' + row_id).addClass("input-error");
          $('#error-harga-unit-kosong-' + row_id).show();
        } else {
          $('#insert_harga_unit_' + row_id).removeClass("input-error");
          $('#error-harga-unit-kosong-' + row_id).hide();
        }
        statusInputBarang = false;
      }
      jumlah_barang++;
    } else {
      update_qty_jual = parseInt($('#update_qty_jual_' + row_id).val());
      stok_sekarang = parseInt($('#stok_terbaru_' + row_id).val());
      harga_barang = parseInt($('#update_harga_unit_' + row_id).val());
      is_delete = parseInt($('#is_delete_' + row_id).val());

      if (is_delete == 0) {
        if (update_qty_jual > 0 && update_qty_jual <= stok_sekarang && harga_barang > 0) {
          $('#update_qty_jual_' + row_id).removeClass("input-error");
          $('#error-qty-jual-kosong-' + row_id).hide();
          $('#update_qty_jual_' + row_id).removeClass("input-error");
          $('#error-qty-jual-lebih-' + row_id).hide();
          $('#update_harga_unit_' + row_id).removeClass("input-error");
          $('#error-harga-unit-kosong-' + row_id).hide();
        } else {
          if (update_qty_jual <= 0) {
            $('#update_qty_jual_' + row_id).addClass("input-error");
            $('#error-qty-jual-kosong-' + row_id).show();
          } else {
            $('#update_qty_jual_' + row_id).removeClass("input-error");
            $('#error-qty-jual-kosong-' + row_id).hide();
          }
          if (update_qty_jual > stok_sekarang) {
            $('#update_qty_jual_' + row_id).addClass("input-error");
            $('#error-qty-jual-lebih-' + row_id).show();
          } else {
            $('#update_qty_jual_' + row_id).removeClass("input-error");
            $('#error-qty-jual-lebih-' + row_id).hide();
          }

          if (harga_barang <= 0) {
            $('#update_harga_unit_' + row_id).addClass("input-error");
            $('#error-harga-unit-kosong-' + row_id).show();
          } else {
            $('#update_harga_unit_' + row_id).removeClass("input-error");
            $('#error-harga-unit-kosong-' + row_id).hide();
          }
          statusInputBarang = false;
        }
        jumlah_barang++;
      }
    }
  });

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
  }
  createAutonumeric();
  return statusInputBarang;
}

function hitungFormPenjualan() {
  unformatMultipleAutonumeric();
  removeMultipleAutonumeric();
  subtotal_overall = 0;
  $('.row_barang_added').each(function () {
    row_id = $(this).attr('data-row-id');
    is_any_before = $(this).attr('data-is-any-before');
    is_delete = parseInt($('#is_delete_' + row_id).val());

    if (is_any_before == 'yes' && is_delete == 0) {
      qty_jual = parseInt($('#update_qty_jual_' + row_id).val());
      harga_unit = parseInt($('#update_harga_unit_' + row_id).val());
      diskon_barang = parseInt($('#update_diskon_' + row_id).val());

      subtotal = qty_jual * harga_unit;
      diskon_subtotal = subtotal * diskon_barang / 100;
      subtotal = subtotal - diskon_subtotal;
      subtotal_overall += subtotal;
      $('#update_subtotal_' + row_id).val(subtotal);
    } else {
      qty_jual = parseInt($('#insert_qty_jual_' + row_id).val());
      harga_unit = parseInt($('#insert_harga_unit_' + row_id).val());
      diskon_barang = parseInt($('#insert_diskon_' + row_id).val());

      subtotal = qty_jual * harga_unit;
      diskon_subtotal = subtotal * diskon_barang / 100;
      subtotal = subtotal - diskon_subtotal;
      subtotal_overall += subtotal;
      $('#insert_subtotal_' + row_id).val(subtotal);
    }
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

function formCheck() {
  pelanggan = $('#order_by_pelanggan_id').val();
  ship_via = $('#ship_via').val();
  check_input = checkInputBarang();
  hitungFormPenjualan();

  if (pelanggan != 'kosong' && ship_via != 'kosong' && check_input) {
    $('#order_by_pelanggan_id').removeClass("input-error");
    $('#error-pelanggan-kosong').hide();
    $('#ship_via').removeClass("input-error");
    $('#error-ship-via-kosong').hide();
    unformatMultipleAutonumeric();
    removeMultipleAutonumeric();
    return true;
  } else {
    if (pelanggan == 'kosong') {
      $('#order_by_pelanggan_id').addClass("input-error");
      $('#error-pelanggan-kosong').show();
    } else {
      $('#order_by_pelanggan_id').removeClass("input-error");
      $('#error-pelanggan-kosong').hide();
    }

    if (ship_via == 'kosong') {
      $('#ship_via').addClass("input-error");
      $('#error-ship-via-kosong').show();
    } else {
      $('#ship_via').removeClass("input-error");
      $('#error-ship-via-kosong').hide();
    }
    scrollToTop();
    return false;
  }
}

$(document).ready(function () {
  {
    createAutonumeric();
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      startDate: '2020-01-01',
      autoHide: true,
      startView: 1
    });
    $('#tanggal_penjualan').datepicker('setDate', $('#tanggal_penjualan').val());
    $('#ship_date').datepicker('setDate', $('#ship_date').val());
  }

  $('#btn-pilih-barang').click(function () {
    $.ajax({
      type: 'POST',
      url: base_url + 'Penjualan/PesananPenjualan/getViewTablePilihBarang',
      dataType: 'JSON',
      success: function (response) {
        // console.log(response);
        $('#tableBarang').html(response.html);
        $('#modal-pilih-barang').show();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
      }
    });
  });
  $('#btn-close').click(function () {
    $('#modal-pilih-barang').hide();
  });

  $('#order_by_pelanggan_id').change(function () {
    id = $(this).val();

    if (id != 'kosong') {
      alamat = $('#alamat_pelanggan_' + id).val();
      $('#tagihan_ke').val(alamat);
      $('#alamat_ship_to').val(alamat);
    } else {
      $('#tagihan_ke').val('');
      $('#alamat_ship_to').val('');
    }
  });

  $(document).on('click', '.btn-tambah-list-barang', function () {
    id_barang = $(this).attr('data-id');

    stok_aktual = parseInt($('#stok_di_gudang_' + id_barang).val());

    if (stok_aktual <= 0) {
      if (stok_aktual <= 0)
        $('#error-stok-kosong-' + id_barang).show();
      else
        $('#error-stok-kosong-' + id_barang).hide();
    } else {
      $('#error-stok-kosong-' + id_barang).hide();
      $.ajax({
        type: 'POST',
        url: base_url + 'Penjualan/PesananPenjualan/addRowPesananPenjualanForEdit/' + id_barang,
        dataType: 'JSON',
        success: function (response) {
          // console.log(response);
          unformatMultipleAutonumeric();
          removeMultipleAutonumeric();
          $('#tableListPenjualan > tbody:last-child').append(response.html);
          createAutonumeric();
          $('#modal-pilih-barang').hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        }
      });
    }
  });

  $(document).on('click', '.btn-hapus-row-barang', function () {
    row_id = $(this).attr('data-row-id');
    is_any_before = $(this).attr('data-is-any-before');

    if (is_any_before == 'yes') {
      $('#row_barang_' + row_id).hide();
      $('#is_delete_' + row_id).val(1);
    } else
      $('#row_barang_' + row_id).remove();

    hitungFormPenjualan();
  });

  $(document).on('change', '.input_qty, .input_harga, .input_diskon', function () {
    hitungFormPenjualan();
  });
  $(document).on('click', '.input_qty, .input_harga, .input_diskon', function () {
    hitungFormPenjualan();
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

  $('#form').submit(function () {
    return formCheck();
  });
});