var autonum_qty;

function createDatePicker() {
  $('#tanggal_kirim').datepicker('destroy');
  $('#tanggal_kirim').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '2020-01-01',
    autoHide: true,
    startView: 1
  });
  $('#tanggal_kirim').datepicker('setDate', $('#tanggal_kirim').val());
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

function hitungForm() {
  unformatMultipleAutonumeric();
  removeMultipleAutonumeric();
  statusHitung = true;
  $('.list-barang-dipesan').each(function () {
    id_barang_pesanan_ref = $(this).attr('data-id-barang-pesanan');
    qty_terkirim = 0;
    qty_dijual = parseInt($('#qty_dijual_' + id_barang_pesanan_ref).val());

    // console.log('id_barang_pesanan_ref :' + id_barang_pesanan_ref);
    // console.log('qty_terkirim :' + qty_terkirim);
    // console.log('qty_dijual :' + qty_dijual);

    $('.row_barang_added').each(function () {
      id_barang_pesanan_act = $(this).attr('data-id');
      row_id = $(this).attr('data-row-id');
      is_any_before = $(this).attr('data-is-any-before');
      is_delete = $('#is_delete_' + row_id).val();

      if (is_any_before == 'yes') {
        input_qty_kirim = parseInt($('#update_qty_kirim_' + row_id).val());

        if (id_barang_pesanan_ref == id_barang_pesanan_act && is_delete == 0) {
          qty_terkirim += input_qty_kirim;
        }
      } else {
        input_qty_kirim = parseInt($('#insert_qty_kirim_' + row_id).val());
        stok_terbaru = parseInt($('#stok_terbaru_' + row_id).val());

        if (id_barang_pesanan_ref == id_barang_pesanan_act) {
          qty_terkirim += input_qty_kirim;
        }
      }
    });
    $('#table_qty_dikirim_' + id_barang_pesanan_ref).val(qty_terkirim);
    if (qty_terkirim > qty_dijual) {
      statusHitung = false;
      $('#table_qty_dikirim_' + id_barang_pesanan_ref).addClass("input-error");
      $('#error-qty-kirim-lebih-' + id_barang_pesanan_ref).show();
      scrollToTop();
    } else {
      $('#table_qty_dikirim_' + id_barang_pesanan_ref).removeClass("input-error");
      $('#error-qty-kirim-lebih-' + id_barang_pesanan_ref).hide();
    }
  });
  createAutonumeric();
  return statusHitung;
}

function checkForm() {
  hitung = hitungForm();
  jml_barang = 0;
  $('.row_barang_added').each(function () {
    row_id = $(this).attr('data-row-id');
    is_any_before = $(this).attr('data-is-any-before');
    is_delete = $('#is_delete_' + row_id).val();

    if (is_any_before == 'yes' && is_delete == 0)
      jml_barang++;
    else if (is_any_before != 'yes') {
      jml_barang++;
    }

  });

  if (jml_barang > 0 && hitung)
    return true;
  else {
    if (jml_barang <= 0) {
      $.confirm({
        title: 'Error!',
        content: 'Tidak ada list barang yang dikirimkan',
        type: 'red',
        typeAnimated: true,
        buttons: {
          OK: function () {}
        }
      });
    }

    return false;
  }
}

$(document).ready(function () {
  $(document).on('change', '.input_qty', function () {
    hitungForm();
  });

  $(document).on('click', '.btn-tambah-list-barang', function () {
    id_barang_pesanan = $(this).attr('data-id');
    $.ajax({
      type: 'POST',
      url: base_url + 'Penjualan/PengirimanPesanan/addRowBarangPengirimanPesananForEdit/' + id_barang_pesanan,
      dataType: 'JSON',
      success: function (response) {
        // console.log(response);
        unformatMultipleAutonumeric();
        removeMultipleAutonumeric();
        $('#tableListBarangDiterima > tbody:last-child').append(response.html);
        createAutonumeric();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
      }
    });
  });

  $(document).on('click', '.btn-hapus-row-barang', function () {
    row_id = $(this).attr('data-row-id')
    is_update = $(this).attr('data-is-update');

    if (is_update == 'yes') {
      $('#is_delete_' + row_id).val(1);
      $('#row_barang_' + row_id).hide();
    } else
      $('#row_barang_' + row_id).remove();
    hitungForm();
  });

  $(document).on('submit', '#form', function () {
    return checkForm();
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
});