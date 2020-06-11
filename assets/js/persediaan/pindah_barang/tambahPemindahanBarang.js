var autonum;
var table_barang;
var is_pilih_barang_done = 0;

// var jancok = [];

function createAutonumeric() {
  if (typeof autonum !== 'undefined')
    removeMultipleAutonumeric();

  autonum = new AutoNumeric.multiple(".input_qty_pindah", {
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

function createDataTable() {
  table_barang = $('#tableBarang').DataTable({
    'paging': false
  });
}

function destroyDataTable() {
  if (typeof table_barang !== 'undefined')
    table_barang.destroy();
}



function checkInputQtyPindah() {
  is_allowed = true;
  $('.input_qty_pindah').each(function () {
    ctx = $(this);
    id_barang = $(this).attr('data-id');
    input_pindah = parseInt($(this).val());
    stok = parseInt($('#stok_aktual_' + id_barang).val());

    if (input_pindah > 0 && input_pindah <= stok && !isNaN(input_pindah)) {
      ctx.removeClass("input-error");
      $('#error_input_qty_pindah_lebih_' + id_barang).hide();
      $('#error_input_qty_pindah_kosong_' + id_barang).hide();
    } else {
      if (isNaN(input_pindah) || input_pindah <= 0) {
        ctx.addClass("input-error");
        $('#error_input_qty_pindah_kosong_' + id_barang).show();
      } else {
        ctx.removeClass("input-error");
        $('#error_input_qty_pindah_kosong_' + id_barang).hide();
      }

      if (input_pindah > stok) {
        ctx.addClass("input-error");
        $('#error_input_qty_pindah_lebih_' + id_barang).show();
      } else {
        ctx.removeClass("input-error");
        $('#error_input_qty_pindah_lebih_' + id_barang).hide();
      }
      is_allowed = false;
    }
  })
  return is_allowed;
}

function formCheck() {
  list_barang_disesuaikan = $('.add-new').length;
  keterangan = $('#keterangan').val();
  done_gudang = $('#value-done-gudang').val();
  check_input_qty = checkInputQtyPindah();

  if (keterangan != '' && list_barang_disesuaikan > 0 && done_gudang != '0' && check_input_qty) {
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

    if (done_gudang == '0') {
      $.confirm({
        title: 'Error!',
        content: 'Lengkapi field pemilihan gudang dahulu, lalu klik "Selesai Memilih Gudang" ! ',
        type: 'red',
        typeAnimated: true,
        buttons: {
          OK: function () {}
        }
      });
    }

    if (list_barang_disesuaikan <= 0) {
      $.confirm({
        title: 'Error!',
        content: 'Tidak ada barang yang dipindahkan!',
        type: 'red',
        typeAnimated: true,
        buttons: {
          CLOSE: function () {}
        }
      });
    }
    return false;
  }
}

$(document).ready(function () {
  $('#tes').click(function () {
    checkInputQtyPindah();
  });
  $('.pilih-gudang').change(function () {
    alamat_id = $(this).attr('data-id');
    gudang_id = $(this).val();
    dari = $('#dari_gudang').val();
    ke = $('#ke_gudang').val();

    if (dari != ke) {
      alamat = $('#alamat_gudang_id_' + gudang_id).val();
      $('#' + alamat_id).val(alamat);
    } else {
      $(this).val('0');
      $.confirm({
        title: 'Error!',
        content: 'Pemindahan harus dari berbeda gudang',
        type: 'red',
        typeAnimated: true,
        buttons: {
          OK: function () {}
        }
      });
    }
  });

  $('#btn-done-gudang').click(function () {
    dari = $('#dari_gudang').val();
    ke = $('#ke_gudang').val();
    $('#dari_gudang_value').val(dari);
    $('#ke_gudang_value').val(ke);
    if (dari != '0' && ke != '0') {
      $('#dari_gudang').prop('disabled', 'disabled');
      $('#ke_gudang').prop('disabled', 'disabled');
      $(this).removeClass('btn-danger');
      $(this).addClass('btn-primary');
      $('#value-done-gudang').val('1');
    } else {
      $.confirm({
        title: 'Error!',
        content: 'Lengkapi field pemilihan gudang dahulu!',
        type: 'red',
        typeAnimated: true,
        buttons: {
          OK: function () {}
        }
      });
    }
  });

  $('#btn-pilih-barang').click(function () {
    done_gudang = $('#value-done-gudang').val();
    if (done_gudang != '0') {
      if (is_pilih_barang_done == 0) {
        $.ajax({
          type: 'POST',
          url: base_url + 'Persediaan/PindahBarang/getTableBarangFromGudangId/' + dari,
          dataType: 'JSON',
          success: function (response) {
            // console.log(response);
            destroyDataTable();
            $('#data-tableBarang').html(response.html);
            $('#modal-pilih-barang').show();
            createDataTable();
            is_pilih_barang_done = 1;
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
          }
        });
      } else {
        $('#modal-pilih-barang').show();
      }
    } else {
      $.confirm({
        title: 'Error!',
        content: 'Pilih dahulu gudang yang akan dilakukan pemindahan. Lalu click "Selesai Memilih Gudang.',
        type: 'red',
        typeAnimated: true,
        buttons: {
          OK: function () {}
        }
      });
    }
  });
  $('#btn-close').click(function () {
    $('#modal-pilih-barang').hide();
  });

  $(document).on('click', '.btn-tambah-list-barang', function () {
    id_barang = $(this).attr('data-id');
    value_of_id = '#is_added_' + id_barang;

    if ($(value_of_id).val() == '0') {
      $.ajax({
        type: 'POST',
        url: base_url + 'Persediaan/PindahBarang/addRowPemindahanBarang/' + id_barang,
        dataType: 'JSON',
        success: function (response) {
          // console.log(response);
          $('#tableListPenyesuaian > tbody:last-child').append(response.html);
          stok = $('#stok_aktual_' + response.id).val();
          $('#qty_actual_' + response.id).val(stok);
          createAutonumeric();
          $('#modal-pilih-barang').hide();
          $('#icon-plus-id-' + id_barang).hide();
          $('#icon-check-id-' + id_barang).show();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(xhr.responseText);
        }
      });
      $(value_of_id).val('1');
    }
  });

  $(document).on('click', '.btn-hapus-row-barang', function () {
    id_barang = $(this).attr('data-id');
    $('#row_barang_id_' + id_barang).remove();
    $('#is_added_' + id_barang).val('0');
    $('#icon-plus-id-' + id_barang).show();
    $('#icon-check-id-' + id_barang).hide();
  });

  $('#form').submit(function () {
    if (formCheck())
      return true;
    else
      return false;
  });
});