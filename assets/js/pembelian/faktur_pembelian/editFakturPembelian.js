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

$(document).ready(function () {
  createDatePicker();
  $('#btn-delete').click(function () {
    url = $(this).attr('href');
    $.confirm({
      title: 'Hapus Data Produk',
      content: 'Apakah anda yakin untuk menghapus data penerimaan barang ini?',
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

  $(document).on('click', '.sub-fitur', function () {
    id = $(this).attr('data-id');
    $('.sub-fitur').removeClass('active');
    $(this).addClass('active');
    $('.view-faktur').hide();
    $('#' + id).show();
  });
});