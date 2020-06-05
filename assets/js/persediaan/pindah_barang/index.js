$(document).ready(function () {
  var table_pindah_barang = $('#tablePemindahanBarang').DataTable({
    "lengthMenu": [
      [25, 50, -1],
      [25, 50, "All"]
    ],
    "columnDefs": [{
      "searchable": false,
      "orderable": false,
      "targets": [0]
    }],
    "order": [
      [1, 'asc']
    ]
  });

  table_pindah_barang.on('order.dt search.dt', function () {
    table_pindah_barang.column(0, {
      search: 'applied',
      order: 'applied'
    }).nodes().each(function (cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();
});