function formCheck() {
  kode_barang = $('#kode_barang').val();
  keterangan = $('#keterangan').val();

  if (kode_barang != '' && keterangan != '')
    return true;
  else {
    if (kode_barang != '') {
      $('#kode_barang').removeClass("input-error");
      $('#error-kode-kosong').hide();
    } else {
      $('#kode_barang').addClass("input-error");
      $('#error-kode-kosong').show();
    }
    if (keterangan != '') {
      $('#keterangan').removeClass("input-error");
      $('#error-keterangan-kosong').hide();
    } else {
      $('#keterangan').addClass("input-error");
      $('#error-keterangan-kosong').show();
    }
    scrollToTop();
    return false;
  }
}

$(document).ready(function () {
  {
    var kuantitas = new AutoNumeric("#kuantitas_saldo_awal", {
      decimalCharacter: ",",
      digitGroupSeparator: ".",
      allowDecimalPadding: false,
      decimalPlaces: 0
    });
    var harga_per_unit = new AutoNumeric("#harga_per_unit_saldo_awal", {
      currencySymbol: "Rp ",
      decimalCharacter: ",",
      digitGroupSeparator: ".",
      allowDecimalPadding: false,
      decimalPlaces: 0
    });
    var harga_pokok = new AutoNumeric("#harga_pokok_saldo_awal", {
      currencySymbol: "Rp ",
      decimalCharacter: ",",
      digitGroupSeparator: ".",
      allowDecimalPadding: false,
      decimalPlaces: 0
    });
    var harga_jual = new AutoNumeric("#harga_jual", {
      currencySymbol: "Rp ",
      decimalCharacter: ",",
      digitGroupSeparator: ".",
      allowDecimalPadding: false,
      decimalPlaces: 0
    });
    var diskon_barang = new AutoNumeric("#diskon_barang", {
      suffixText: "%",
      decimalCharacter: ",",
      digitGroupSeparator: ".",
      allowDecimalPadding: false,
      decimalPlaces: 0
    });
  }

  $('#kuantitas_saldo_awal').change(function () {
    qty = kuantitas.getNumber();
    harga = harga_per_unit.getNumber();

    harga_pokok.set(qty * harga);
  });

  $('[data-toggle="datepicker"]').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '2020/01/01',
    autoHide: true,
    startView: 1
  });

  $('[data-toggle="datepicker"]').datepicker('setDate', $('#date-now').val());



  $('#harga_per_unit_saldo_awal').change(function () {
    qty = kuantitas.getNumber();
    harga = harga_per_unit.getNumber();

    harga_pokok.set(qty * harga);
  });

  $('#form-tambah-barang-jasa').submit(function (event) {
    if (formCheck()) {
      harga_per_unit.unformat();
      harga_pokok.unformat();
      kuantitas.unformat();
      harga_jual.unformat();
      diskon_barang.unformat();
      return true;
    } else
      return false;
  });
});