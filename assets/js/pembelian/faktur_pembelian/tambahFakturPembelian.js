function createDatePicker() {
  $('#tanggal-faktur').datepicker('destroy');
  $('#tanggal-faktur').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '2020-01-01',
    autoHide: true,
    startView: 1
  });
  $('#tanggal-faktur').datepicker('setDate', $('#tanggal-faktur').val());
}

function getViewFormFakturPembelian(id_form_pembelian) {
  $.ajax({
    type: 'POST',
    url: base_url + 'Pembelian/FakturPembelian/getViewFormFakturPembelian/' + id_form_pembelian,
    dataType: 'JSON',
    success: function (response) {
      console.log(response);
      $('#view-penerimaan-barang').html(response.html);
      createDatePicker();
      $('#modal-pilih-pesanan').hide();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr.responseText);
    }
  });
}

$(document).ready(function () {
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
      $('#id_form_pesanan').val(id_pesanan);
      $('#kode_pesanan').val(no_pesanan);
      getViewFormFakturPembelian(id_pesanan);
    } else {
      $.confirm({
        title: 'Hapus Data Produk',
        content: 'Apakah anda yakin untuk mengganti pesanan pembelian? Data pesanan pembelian sebelumnya akan terhapus!',
        type: 'red',
        typeAnimated: true,
        buttons: {
          YES: {
            btnClass: 'btn-red',
            action: function () {
              $('#pesanan_terpilih').val(id_pesanan);
              $('#id_form_pesanan').val(id_pesanan);
              $('#kode_pesanan').val(no_pesanan);
              getViewFormFakturPembelian(id_pesanan);
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

  $(document).on('click', '.sub-fitur', function () {
    id = $(this).attr('data-id');
    $('.sub-fitur').removeClass('active');
    $(this).addClass('active');
    $('.view-faktur').hide();
    $('#' + id).show();
  });
});