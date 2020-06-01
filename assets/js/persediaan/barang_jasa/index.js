$(document).ready(function () {
  var table_barang = $('#tableBarang').DataTable({
    "lengthMenu": [
      [25, 50, -1],
      [25, 50, "All"]
    ],
    "ordering": false,
    "columnDefs": [{
      "visible": false,
      "targets": 0
    }],
    order: [
      [0, 'asc']
    ],
    rowGroup: {
      dataSrc: 0
    }
  });

  var table_kategori = $('#tableKategori').DataTable({
    "columnDefs": [{
      "searchable": false,
      "orderable": false,
      "targets": [0, 2]
    }],
    "order": [
      [1, 'asc']
    ]
  });

  table_kategori.on('order.dt search.dt', function () {
    table_kategori.column(0, {
      search: 'applied',
      order: 'applied'
    }).nodes().each(function (cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();
})