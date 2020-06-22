var table_pesanan, autonum_qty;

function createDataTable() {
  table_pesanan = $('#tablePesanan').DataTable({
    'paging': false,
    'order': [0, 'desc']
  });
}

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

function getViewFormPenerimaanBarang(id_pesanan) {
  $.ajax({
    type: 'POST',
    url: base_url + 'Penjualan/PengirimanPesanan/getViewFormPengirimanPesanan/' + id_pesanan,
    dataType: 'JSON',
    success: function (response) {
      // console.log(response);
      unformatMultipleAutonumeric();
      removeMultipleAutonumeric();
      $('#view-pengiriman-barang').html(response.html);
      $('#modal-pilih-pesanan').hide();
      createAutonumeric();
      createDatePicker();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.responseText);
    }
  });
}

function hitungForm() {
  unformatMultipleAutonumeric();
  removeMultipleAutonumeric();
  statusHitung = true;
  $('.list-barang-dipesan').each(function () {
    id_barang_pesanan_ref = $(this).attr('data-id-barang-pesanan');
    qty_terkirim = parseInt($('#table_qty_dikirim_before_' + id_barang_pesanan_ref).val());
    qty_dijual = parseInt($('#qty_dijual_' + id_barang_pesanan_ref).val());

    $('.row_barang_added').each(function () {
      id_barang_pesanan_act = $(this).attr('data-id');
      row_id = $(this).attr('data-row-id');
      input_qty_kirim = parseInt($('#insert_qty_kirim_' + row_id).val());
      stok_terbaru = parseInt($('#stok_terbaru_' + row_id).val());

      if (id_barang_pesanan_ref == id_barang_pesanan_act) {
        qty_terkirim += input_qty_kirim;
      }

      if (input_qty_kirim > stok_terbaru) {
        statusHitung = false;
        $('#insert_qty_kirim_' + id_barang_pesanan_ref).addClass("input-error");
        $('#error-qty-kirim-lebih-dari-stok-' + row_id).show();
      } else {
        $('#insert_qty_kirim_' + id_barang_pesanan_ref).removeClass("input-error");
        $('#error-qty-kirim-lebih-dari-stok-' + row_id).hide();
      }
    });
    $('#table_qty_dikirim_' + id_barang_pesanan_ref).val(qty_terkirim);
    if (qty_terkirim > qty_dijual) {
      statusHitung = false;
      $('#table_qty_dikirim_' + id_barang_pesanan_ref).addClass("input-error");
      $('#error-qty-kirim-lebih-' + id_barang_pesanan_ref).show();
    } else {
      $('#table_qty_dikirim_' + id_barang_pesanan_ref).removeClass("input-error");
      $('#error-qty-kirim-lebih-' + id_barang_pesanan_ref).hide();
    }
  });
  createAutonumeric();
  return statusHitung;
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
        content: 'Apakah anda yakin untuk mengganti pesanan penjualan? Data pesanan penjualan sebelumnya akan terhapus!',
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
  $(document).on('change', '.input_qty', function () {
    hitungForm();
  });

  $(document).on('click', '.btn-tambah-list-barang', function () {
    id_barang_pesanan = $(this).attr('data-id');
    $.ajax({
      type: 'POST',
      url: base_url + 'Penjualan/PengirimanPesanan/addRowBarangPengirimanPesanan/' + id_barang_pesanan,
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

  $(document).on('change', '.pilih-gudang', function () {
    row_id = $(this).attr('data-row-id');
    id_gudang = $(this).val();
    id_barang = $('#id_barang_' + row_id).val();

    // alert('id_gudang : ' + id_gudang + ', id_barang : ' + id_barang + ', row_id : ' + row_id)

    $.ajax({
      type: 'POST',
      url: base_url + 'Penjualan/PengirimanPesanan/getStokBarangTerbaruByGudangId/' + id_gudang + '/' + id_barang,
      dataType: 'JSON',
      success: function (response) {

        $('#stok_terbaru_' + row_id).val(response.stok);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
      }
    });
  });

  $(document).on('click', '.btn-hapus-row-barang', function () {
    row_id = $(this).attr('data-row-id')
    $('#row_barang_' + row_id).remove();
    hitungForm();
  });

  $(document).on('submit', '#form', function () {
    return hitungForm();
  });
});