var autonum;
var list_barang_disesuaikan = 0;

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
  keterangan = $('#keterangan').val();
  if (keterangan != '' && list_barang_disesuaikan > 0) {
    $('#jumlah_barang_disesuaikan').val(list_barang_disesuaikan);
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

    if (list_barang_disesuaikan <= 0) {
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

  $('.btn-tambah-list-barang').click(function () {
    id_barang = $(this).attr('data-id');
    value_of_id = '#is_added_' + id_barang;
    if ($(value_of_id).val() == '0') {
      $.ajax({
        type: 'POST',
        url: base_url + 'Persediaan/SetHargaPenjualan/addRowHargaPenjualanBarang/' + id_barang,
        dataType: 'JSON',
        success: function (response) {
          $('#tableListPenyesuaian > tbody:last-child').append(response.html);
          createAutonumeric();
          $('#modal-pilih-barang').hide();
          list_barang_disesuaikan++;
          $('#icon-plus-id-' + id_barang).hide();
          $('#icon-check-id-' + id_barang).show();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(xhr.responseText);
        }
      });
    }
    $(value_of_id).val('1');
  });

  $(document).on('click', '.btn-hapus-row-data-harga', function () {
    id_harga = $(this).attr('data-id');
    id_barang = $(this).attr('data-toggle');
    $('#row_harga_id_' + id_harga).remove();
    $('#is_added_' + id_barang).val('0');
    list_barang_disesuaikan--;
    $('#icon-plus-id-' + id_barang).show();
    $('#icon-check-id-' + id_barang).hide();
  });

  $('#form-tambah-penyesuaian-harga').submit(function () {
    if (formCheck())
      return true;
    else
      return false;
  })
});