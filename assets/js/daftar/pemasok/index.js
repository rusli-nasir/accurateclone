$(document).ready(function () {
  var tablePemasok = $('#tablePemasok').DataTable({
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

  tablePemasok.on('order.dt search.dt', function () {
    tablePemasok.column(0, {
      search: 'applied',
      order: 'applied'
    }).nodes().each(function (cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();
});