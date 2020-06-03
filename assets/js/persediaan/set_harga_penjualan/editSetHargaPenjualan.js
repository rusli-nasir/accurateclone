var autonum;

function createAutonumeric() {
  if (typeof autonum !== 'undefined')
    removeMultipleAutonumeric();

  autonum = new AutoNumeric.multiple(".input_harga", {
    currencySymbol: "Rp ",
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    allowDecimalPadding: false,
    decimalPlaces: 0
  });
}

function removeMultipleAutonumeric() {
  autonum.forEach(item => {
    item.remove();
  });
}

function unformatMultipleAutonumeric() {
  autonum.forEach(item => {
    item.unformat();
  });
  removeMultipleAutonumeric();
}

function formCheck() {

  added = 0;
  $('.count-is-added').each(function () {
    if ($(this).val() == '1')
      added++;
  });
  keterangan = $('#keterangan').val();

  if (keterangan != '' && added > 0) {
    $('#keterangan').removeClass("input-error");
    $('#error-keterangan-kosong').hide();
    unformatMultipleAutonumeric();
    return true;
  } else {
    if (keterangan == '') {
      $('#keterangan').addClass("input-error");
      $('#error-keterangan-kosong').show();
      scrollToTop();
    } else {
      $('#keterangan').removeClass("input-error");
      $('#error-keterangan-kosong').hide();
    }

    if (added <= 0) {
      $.confirm({
        title: 'Error!',
        content: 'Tidak ada barang yang disesuaikan harganya!',
        type: 'red',
        typeAnimated: true,
        buttons: {
          CLOSE: function () {}
        }
      });
    }
  }
}

$(document).ready(function () {
  $('#btn-pilih-barang').click(function () {
    $('#modal-pilih-barang').show();
  });
  $('#btn-close').click(function () {
    $('#modal-pilih-barang').hide();
  });
  var table_barang = $('#tableBarang').DataTable({
    'paging': false
  });

  autonum = new AutoNumeric.multiple(".input_harga", {
    currencySymbol: "Rp ",
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    allowDecimalPadding: false,
    decimalPlaces: 0
  });

  $('.btn-tambah-list-barang').click(function () {
    id_harga = $(this).attr('data-id-harga');
    id_barang = $(this).attr('data-id');
    value_of_id = '#is_added_' + id_barang;
    is_any_before = '#is_any_before_' + id_barang;
    if ($(value_of_id).val() == '0') {

      if ($(is_any_before).val() == 1) {
        alert('oi');
        $('#is_delete_' + id_harga).val('0');
        $('#modal-pilih-barang').hide();
        $('#icon-plus-id-' + id_barang).hide();
        $('#icon-check-id-' + id_barang).show();
        $('#row_harga_any_before_id_' + id_harga).show();
      } else {
        $.ajax({
          type: 'POST',
          url: base_url + 'Persediaan/SetHargaPenjualan/addRowHargaPenjualanBarang/' + id_barang,
          dataType: 'JSON',
          success: function (response) {
            $('#tableListPenyesuaian > tbody:last-child').append(response.html);
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

  $(document).on('click', '.btn-hapus-row-data-harga', function () {
    id_harga = $(this).attr('data-id');
    id_barang = $(this).attr('data-toggle');
    is_update = $(this).attr('data-is-update');
    if (is_update == 'yes') {
      $('#row_harga_any_before_id_' + id_harga).hide();
      $('#is_added_' + id_barang).val('0');
      $('#icon-plus-id-' + id_barang).show();
      $('#icon-check-id-' + id_barang).hide();
      $('#is_delete_' + id_harga).val('1');
    } else {
      $('#row_harga_id_' + id_harga).remove();
      $('#is_added_' + id_barang).val('0');
      $('#icon-plus-id-' + id_barang).show();
      $('#icon-check-id-' + id_barang).hide();
    }
  });

  $('#form-tambah-penyesuaian-harga').submit(function () {
    if (formCheck())
      return true;
    else
      return false;
  })

  $('#btn-delete').click(function () {
    url = $(this).attr('href');
    $.confirm({
      title: 'Hapus Data Produk',
      content: 'Apakah anda yakin untuk menghapus data set harga penjualan ini?',
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