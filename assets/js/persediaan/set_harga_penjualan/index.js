$(document).ready(function () {
  var table_set_harga = $('#table-list-harga').DataTable({
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

  table_set_harga.on('order.dt search.dt', function () {
    table_set_harga.column(0, {
      search: 'applied',
      order: 'applied'
    }).nodes().each(function (cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();
});