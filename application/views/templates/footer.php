  </div>
  <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Rocketjaket.com 2019</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Apakah anda yakin untuk logout dari sesi sekarang?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary load-link" href="<?= base_url("Auth/logout"); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('vendor/sbadmin2/'); ?>js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/chart.js/Chart.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('vendor/sbadmin2/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?= base_url("plugin/autoNumeric/"); ?>autoNumeric.min.js"></script>

  <?php if ($this->uri->segment(1) == "Karyawan" || $this->uri->segment(1) == "Dashboard" || $this->uri->segment(1) == "LapPenjualan" || $this->uri->segment(1) == "Absen") { ?>
    <script src="<?= base_url('plugin/datepicker/'); ?>datepicker.min.js"></script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Absen") { ?>
    <script src="<?= base_url('plugin/lightbox/'); ?>lightbox.min.js"></script>
  <?php } ?>

  <!-- Custom Modal -->
  <script src="<?= base_url('plugin/jquery-confirm/'); ?>jquery-confirm.min.js"></script>
  <script src="<?= base_url('assets/js/'); ?>ajax-modal.js"></script>
  <script src="<?= base_url('assets/js/'); ?>form-custom.js"></script>

  <?php if ($this->uri->segment(1) == "Dashboard" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      function changeDisplayJudul() {
        toko = $('#list-toko').val();
        start = $('#input_start_date').val();
        end = $('#input_end_date').val();

        if (!start || !end) {
          start = 0;
          end = 0;
        }

        console.log(toko);
        console.log(start);
        console.log(end);

        $.ajax({
          type: 'POST',
          url: base_url + 'Dashboard/getDisplayJudul',
          data: {
            'id': toko,
            'start': start,
            'end': end
          },
          dataType: 'JSON',
          success: function(response) {
            $('#show-toko').html(response.nama);
            if (response.range == "0") {
              $('#show-range').html(' ');
            } else {
              $('#show-range').html(response.range);
            }
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });
      }

      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        $.ajax({
          type: 'GET',
          url: base_url + 'Dashboard/getFirstAndLastRecordDate',
          dataType: 'JSON',
          success: function(response) {
            $('[data-toggle="datepicker"]').datepicker({
              format: 'yyyy-mm-dd',
              startDate: response.start,
              endDate: response.end,
              autoHide: true,
              startView: 1
            });
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });

        toko_id = $('#list-toko').val();

        $.ajax({
          type: 'GET',
          url: base_url + 'Dashboard/getDashboardContent/' + toko_id,
          dataType: 'JSON',
          success: function(response) {
            changeDisplayJudul();
            $('#dashboard-content').html(response);
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });

        $('#list-toko').change(function() {
          tk_id = $(this).val();

          $('[data-toggle="datepicker"]').datepicker('reset');
          $('#container-wait').show();
          $.ajax({
            type: 'GET',
            url: base_url + 'Dashboard/getDashboardContent/' + tk_id,
            dataType: 'JSON',
            success: function(response) {
              changeDisplayJudul();
              $('#dashboard-content').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });

        $('#btn-custom-reset').click(function() {
          tk_id = $('#list-toko').val();
          $('[data-toggle="datepicker"]').datepicker('reset');

          $('#container-wait').show();
          $.ajax({
            type: 'GET',
            url: base_url + 'Dashboard/getDashboardContent/' + tk_id,
            dataType: 'JSON',
            success: function(response) {
              changeDisplayJudul();
              $('#dashboard-content').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });

        $('#btn-custom-range').click(function() {
          tk_id = $('#list-toko').val();
          start = $('#input_start_date').val();
          end = $('#input_end_date').val();

          $('#container-wait').show();
          $.ajax({
            type: 'POST',
            url: base_url + 'Dashboard/getCustomContent',
            data: "start=" + start + "&end=" + end + "&tk_id=" + tk_id,
            dataType: 'JSON',
            success: function(response) {
              changeDisplayJudul();
              $('#dashboard-content').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Dashboard" && $this->uri->segment(2) == "chart") { ?>
    <script type="text/javascript">
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#858796';
      var c1, c2, c3, c4, c5, c6;
      var ctx1, ctx2, ctx3, ctx4, ctx5, ctx6;
      var is_chart_used = 0;

      function number_format(value) {
        if (value >= 1000000) {
          value = Math.round(value / 1000000);
          return value + ' jt';
        } else if (value >= 1000) {
          value = Math.round(value / 1000);
          return value + ' k';
        }
        return value;
      }

      function chart1(data, time) {
        //profit
        //console.log(data);
        timeline = [];
        dataset = [];

        if (time == "hari") {
          time = 'Hari: ';
        } else if (time == "bulan") {
          time = "Bulan: "
        } else if (time == "tahun") {
          time = "Tahun: "
        }

        data.forEach(function(x) {
          timeline.push(x.tick);
          dataset.push(x.profit)
        });

        c1 = new Chart(ctx1, {
          type: 'bar',
          data: {
            labels: timeline,
            datasets: [{
              label: "Profit",
              backgroundColor: "#4e73df",
              hoverBackgroundColor: "#2e59d9",
              borderColor: "#4e73df",
              data: dataset,
            }],
          },
          options: {
            scales: {
              xAxes: [{
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                maxBarThickness: 25,
              }],
              yAxes: [{
                ticks: {
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return 'Rp ' + number_format(value);
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }]
            },
            legend: {
              display: false
            },
            tooltips: {
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
              callbacks: {
                title: function(tooltipItem, data) {
                  return time + timeline[tooltipItem[0].index];
                },
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel);
                }
              }
            }
          }
        });
      }

      function chart2(data, time) {
        //Omset
        //console.log(data);
        timeline = [];
        dataset = [];

        if (time == "hari") {
          time = 'Hari: ';
        } else if (time == "bulan") {
          time = "Bulan: "
        } else if (time == "tahun") {
          time = "Tahun: "
        }

        data.forEach(function(x) {
          timeline.push(x.tick);
          dataset.push(x.omset)
        });

        c2 = new Chart(ctx2, {
          type: 'bar',
          data: {
            labels: timeline,
            datasets: [{
              label: "Omset",
              backgroundColor: "#4e73df",
              hoverBackgroundColor: "#2e59d9",
              borderColor: "#4e73df",
              data: dataset,
            }],
          },
          options: {
            scales: {
              xAxes: [{
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                maxBarThickness: 25,
              }],
              yAxes: [{
                ticks: {
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return 'Rp ' + number_format(value);
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }]
            },
            legend: {
              display: false
            },
            tooltips: {
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
              callbacks: {
                title: function(tooltipItem, data) {
                  return time + timeline[tooltipItem[0].index];
                },
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel);
                }
              }
            }
          }
        });
      }

      function chart3(data, time) {
        //jumlah transaksi
        //console.log(data);
        timeline = [];
        dataset = [];

        if (time == "hari") {
          time = 'Hari: ';
        } else if (time == "bulan") {
          time = "Bulan: "
        } else if (time == "tahun") {
          time = "Tahun: "
        }

        data.forEach(function(x) {
          timeline.push(x.tick);
          dataset.push(x.transaksi)
        });

        c3 = new Chart(ctx3, {
          type: 'bar',
          data: {
            labels: timeline,
            datasets: [{
              label: "Jml Transaksi",
              backgroundColor: "#4e73df",
              hoverBackgroundColor: "#2e59d9",
              borderColor: "#4e73df",
              data: dataset,
            }],
          },
          options: {
            scales: {
              xAxes: [{
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                maxBarThickness: 25,
              }],
              yAxes: [{
                ticks: {
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return value + ' x';
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }]
            },
            legend: {
              display: false
            },
            tooltips: {
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
              callbacks: {
                title: function(tooltipItem, data) {
                  return time + timeline[tooltipItem[0].index];
                },
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': ' + tooltipItem.yLabel + ' x';
                }
              }
            }
          }
        });
      }

      function chart4(data, time) {
        //produk terjual
        timeline = [];
        dataset = [];

        if (time == "hari") {
          time = 'Hari: ';
        } else if (time == "bulan") {
          time = "Bulan: "
        } else if (time == "tahun") {
          time = "Tahun: "
        }

        data.forEach(function(x) {
          timeline.push(x.tick);
          dataset.push(x.terjual)
        });

        c4 = new Chart(ctx4, {
          type: 'bar',
          data: {
            labels: timeline,
            datasets: [{
              label: "Terjual",
              backgroundColor: "#4e73df",
              hoverBackgroundColor: "#2e59d9",
              borderColor: "#4e73df",
              data: dataset,
            }],
          },
          options: {
            scales: {
              xAxes: [{
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                maxBarThickness: 25,
              }],
              yAxes: [{
                ticks: {
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return value + ' x';
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }]
            },
            legend: {
              display: false
            },
            tooltips: {
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
              callbacks: {
                title: function(tooltipItem, data) {
                  return time + timeline[tooltipItem[0].index];
                },
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': ' + tooltipItem.yLabel + ' barang';
                }
              }
            }
          }
        });
      }

      function chart5(data, time) {
        //pengunjung beli vs tidak beli
        timeline = [];
        dataset1 = [];
        dataset2 = [];

        if (time == "hari") {
          time = 'Hari: ';
        } else if (time == "bulan") {
          time = "Bulan: "
        } else if (time == "tahun") {
          time = "Tahun: "
        }

        data.forEach(function(x) {
          timeline.push(x.tick);
          dataset1.push(x.beli);
          dataset2.push(x.tdk_beli);
        });

        c5 = new Chart(ctx5, {
          type: 'bar',
          data: {
            labels: timeline,
            datasets: [{
              label: "Beli",
              backgroundColor: "#4e73df",
              hoverBackgroundColor: "#2e59d9",
              borderColor: "#4e73df",
              data: dataset1,
            }, {
              label: "Tidak Beli",
              backgroundColor: "#FF3E4D",
              hoverBackgroundColor: "#D63031",
              borderColor: "#B83227",
              data: dataset2,
            }],
          },
          options: {
            scales: {
              xAxes: [{
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                maxBarThickness: 25,
              }],
              yAxes: [{
                ticks: {
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return value + ' x';
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }]
            },
            legend: {
              display: true
            },
            tooltips: {
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
              callbacks: {
                title: function(tooltipItem, data) {
                  return time + timeline[tooltipItem[0].index];
                },
                label: function(tooltipItem, chart) {
                  console.log(chart.datasets[tooltipItem.datasetIndex]);
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': ' + tooltipItem.yLabel + ' orang';
                }
              }
            }
          }
        });
      }

      function chart6(data, time) {
        //operasional
        //Omset
        //console.log(data);
        timeline = [];
        dataset = [];

        if (time == "hari") {
          time = 'Hari: ';
        } else if (time == "bulan") {
          time = "Bulan: "
        } else if (time == "tahun") {
          time = "Tahun: "
        }

        data.forEach(function(x) {
          timeline.push(x.tick);
          dataset.push(x.operasional)
        });

        c6 = new Chart(ctx6, {
          type: 'bar',
          data: {
            labels: timeline,
            datasets: [{
              label: "Operasional",
              backgroundColor: "#4e73df",
              hoverBackgroundColor: "#2e59d9",
              borderColor: "#4e73df",
              data: dataset,
            }],
          },
          options: {
            scales: {
              xAxes: [{
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                maxBarThickness: 25,
              }],
              yAxes: [{
                ticks: {
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return 'Rp ' + number_format(value);
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }]
            },
            legend: {
              display: false
            },
            tooltips: {
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
              callbacks: {
                title: function(tooltipItem, data) {
                  return time + timeline[tooltipItem[0].index];
                },
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel);
                }
              }
            }
          }
        });
      }

      function makeChart(toko, mode, bulan, tahun) {
        $.ajax({
          type: 'POST',
          url: base_url + 'Dashboard/getChartData',
          data: {
            "toko": toko,
            "mode": mode,
            "bulan": bulan,
            "tahun": tahun
          },
          dataType: "JSON",
          success: function(response) {
            //make chart
            console.log(response);
            if (is_chart_used == 1)
              destroyChart();

            chart1(response.c1, mode);
            chart2(response.c2, mode);
            chart3(response.c3, mode);
            chart4(response.c4, mode);
            chart5(response.c5, mode);
            chart6(response.c6, mode);
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          },
          complete: function() {
            $('#container-wait').hide();
            is_chart_used = 1;
          }
        });
      }

      function destroyChart() {
        c1.destroy();
        c2.destroy();
        c3.destroy();
        c4.destroy();
        c5.destroy();
        c6.destroy();
      }

      $(document).ready(function() {
        $('#container-wait').hide();
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        ctx1 = document.getElementById("cProfit").getContext('2d');
        ctx2 = document.getElementById("cOmset").getContext('2d');
        ctx3 = document.getElementById("cTransaksi").getContext('2d');
        ctx4 = document.getElementById("cProduk").getContext('2d');
        ctx5 = document.getElementById("cPengunjung").getContext('2d');
        ctx6 = document.getElementById("cOperasional").getContext('2d');

        $('#tampilan-mode--select').change(function() {
          if ($(this).val() == "hari") {
            $('#tampilan-bulan').show();
            $('#tampilan-tahun').show();
          }
          if ($(this).val() == "bulan") {
            $('#tampilan-bulan').hide();
            $('#tampilan-tahun').show();
          }
          if ($(this).val() == "tahun" || $(this).val() == "") {
            $('#tampilan-bulan').hide();
            $('#tampilan-tahun').hide();
          }
          $('#tampilan-bulan option:first').prop('selected', true);
          $('#tampilan-tahun option:first').prop('selected', true);
        });

        $('#btn-tampilkan').click(function() {

          toko = $('#tampilan-toko--select').val();
          mode = $('#tampilan-mode--select').val();
          bulan = $('#tampilan-bulan--select').val();
          tahun = $('#tampilan-tahun--select').val();

          if (toko != "" && mode != "") {
            if (mode == "hari") {
              if (bulan != "" && tahun != "") {
                // PROSES BIKIN CHART

                $('#container-wait').show();
                makeChart(toko, mode, bulan, tahun);
                $('#chart-area').show();

              } else {
                if (bulan == "")
                  $('#error-bulan').show();
                if (tahun == "")
                  $('#error-tahun').show();
              }
              if (toko == "")
                $('#error-toko').show();
              else
                $('#error-toko').hide();
              if (mode == "")
                $('#error-mode').show();
              else
                $('#error-mode').hide();
              if (bulan == "")
                $('#error-bulan').show();
              else
                $('#error-bulan').hide();
              if (tahun == "")
                $('#error-tahun').show();
              else
                $('#error-tahun').hide();
            } else if (mode == "bulan") {
              if (tahun != "") {
                // PROSES BIKIN CHART

                $('#container-wait').show();
                makeChart(toko, mode, bulan, tahun);
                $('#chart-area').show();

              } else {
                if (tahun == "")
                  $('#error-tahun').show();
              }
              if (toko == "")
                $('#error-toko').show();
              else
                $('#error-toko').hide();
              if (mode == "")
                $('#error-mode').show();
              else
                $('#error-mode').hide();
              if (tahun == "")
                $('#error-tahun').show();
              else
                $('#error-tahun').hide();
            } else if (mode == "tahun") {
              // PROSES BIKIN CHART

              $('#container-wait').show();
              makeChart(toko, mode, bulan, tahun);
              $('#chart-area').show();
              if (toko == "")
                $('#error-toko').show();
              else
                $('#error-toko').hide();
              if (mode == "")
                $('#error-mode').show();
              else
                $('#error-mode').hide();
              if (tahun == "")
                $('#error-tahun').show();
              else
                $('#error-tahun').hide();
            }
          } else {
            $('#container-wait').hide();
            if (toko == "")
              $('#error-toko').show();
            else
              $('#error-toko').hide();
            if (mode == "")
              $('#error-mode').show();
            else
              $('#error-mode').hide();
            if (bulan == "")
              $('#error-bulan').show();
            else
              $('#error-bulan').hide();
            if (tahun == "")
              $('#error-tahun').show();
            else
              $('#error-tahun').hide();
          }

          //makeChart(mode, harian, bulanan);
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Dashboard" && $this->uri->segment(2) == "net") { ?>
    <script type="text/javascript">
      function changeDisplayJudul() {
        toko = $('#list-toko').val();
        start = $('#input_start_date').val();
        end = $('#input_end_date').val();

        if (!start || !end) {
          start = 0;
          end = 0;
        }

        console.log(toko);
        console.log(start);
        console.log(end);

        $.ajax({
          type: 'POST',
          url: base_url + 'Dashboard/getDisplayJudul',
          data: {
            'id': toko,
            'start': start,
            'end': end
          },
          dataType: 'JSON',
          success: function(response) {
            $('#show-toko').html(response.nama);
            if (response.range == "0") {
              $('#show-range').html(' ');
            } else {
              $('#show-range').html(response.range);
            }
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });
      }

      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        $.ajax({
          type: 'GET',
          url: base_url + 'Dashboard/getFirstAndLastRecordDate',
          dataType: 'JSON',
          success: function(response) {
            $('[data-toggle="datepicker"]').datepicker({
              format: 'yyyy-mm-dd',
              startDate: response.start,
              endDate: response.end,
              autoHide: true,
              startView: 1
            });
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });

        toko_id = $('#list-toko').val();

        $.ajax({
          type: 'GET',
          url: base_url + 'Dashboard/getDashboardContentNet/' + toko_id,
          dataType: 'JSON',
          success: function(response) {
            changeDisplayJudul();
            $('#dashboard-content').html(response);
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });

        $('#list-toko').change(function() {
          tk_id = $(this).val();

          $('[data-toggle="datepicker"]').datepicker('reset');
          $('#container-wait').show();
          $.ajax({
            type: 'GET',
            url: base_url + 'Dashboard/getDashboardContentNet/' + tk_id,
            dataType: 'JSON',
            success: function(response) {
              changeDisplayJudul();
              $('#dashboard-content').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });

        $('#btn-custom-reset').click(function() {
          tk_id = $('#list-toko').val();
          $('[data-toggle="datepicker"]').datepicker('reset');

          $('#container-wait').show();
          $.ajax({
            type: 'GET',
            url: base_url + 'Dashboard/getDashboardContentNet/' + tk_id,
            dataType: 'JSON',
            success: function(response) {
              changeDisplayJudul();
              $('#dashboard-content').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });

        $('#btn-custom-range').click(function() {
          tk_id = $('#list-toko').val();
          start = $('#input_start_date').val();
          end = $('#input_end_date').val();

          $('#container-wait').show();
          $.ajax({
            type: 'POST',
            url: base_url + 'Dashboard/getCustomContentNet',
            data: "start=" + start + "&end=" + end + "&tk_id=" + tk_id,
            dataType: 'JSON',
            success: function(response) {
              changeDisplayJudul();
              $('#dashboard-content').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });

      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Dashboard" && $this->uri->segment(2) == "rankingProduk") { ?>
    <script type="text/javascript">
      var table;

      function changeDisplayJudul(toko, range) {
        $('#show-toko').html(toko);
        $('#show-range').html(range);
      }

      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
        $.ajax({
          type: 'GET',
          url: base_url + 'Dashboard/getFirstAndLastRecordDate',
          dataType: 'JSON',
          success: function(response) {
            $('[data-toggle="datepicker"]').datepicker({
              format: 'yyyy-mm-dd',
              startDate: response.start,
              endDate: response.end,
              autoHide: true,
              startView: 1
            });
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });

        $('#btn-custom-reset').click(function() {
          $('#list-toko').val('all');
          $('[data-toggle="datepicker"]').datepicker('reset');
          if ($.fn.dataTable.isDataTable("#dataTable")) {
            table.destroy();
            $('#ranking-content').html('');
            $('#show-toko').html('');
            $('#show-range').html('');
          }
        });

        $('#btn-custom-range').click(function() {
          tk_id = $('#list-toko').val();
          start = $('#input_start_date').val();
          end = $('#input_end_date').val();

          if (!start || !end) {
            if (!end) {
              $.confirm({
                title: 'Error!',
                content: 'Tanggal akhir belum diisi!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
            if (!start) {
              $.confirm({
                title: 'Error!',
                content: 'Tanggal mulai belum diisi!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
          } else {
            $('#container-wait').show();
            if (tk_id == 'all') {
              $.ajax({
                type: 'POST',
                url: base_url + 'Dashboard/getViewRankingAll',
                data: {
                  'start': start,
                  'end': end
                },
                dataType: 'JSON',
                success: function(response) {
                  if ($.fn.dataTable.isDataTable("#dataTable")) {
                    table.destroy();
                  }
                  changeDisplayJudul(response.nama_toko, response.range);
                  $('#ranking-content').html(response.html);
                  table = $('#dataTable').DataTable({
                    "order": [
                      [0, "asc"]
                    ]
                  });
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                  console.log(xhr.responseText) // munculkan alert
                },
                complete: function() {
                  $('#container-wait').hide();
                }
              });
            } else {
              $.ajax({
                type: 'POST',
                url: base_url + 'Dashboard/getViewRankingByToko/' + tk_id,
                data: {
                  'start': start,
                  'end': end
                },
                dataType: 'JSON',
                success: function(response) {
                  if ($.fn.dataTable.isDataTable("#dataTable")) {
                    table.destroy();
                  }
                  changeDisplayJudul(response.nama_toko, response.range);
                  $('#ranking-content').html(response.html);
                  table = $('#dataTable').DataTable({
                    "order": [
                      [0, "asc"]
                    ]
                  });
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                  console.log(xhr.responseText) // munculkan alert
                },
                complete: function() {
                  $('#container-wait').hide();
                }
              });
            }
          }
        });

      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Dashboard" && $this->uri->segment(2) == "rankingKaryawan") { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
        $('#tampilan-kategori--select').change(function() {
          kategori = $(this).val();
          $('#tampilan-tahun--select').prop('selectedIndex', 0);
          $('#tampilan-bulan--select').prop('selectedIndex', 0);

          if (kategori == 'jual' || kategori == 'absen') {
            $.ajax({
              type: 'POST',
              url: base_url + 'Dashboard/getFirstAndLastRecordKaryawan',
              data: {
                'mode': kategori
              },
              dataType: 'JSON',
              success: function(response) {
                $('#tampilan-rentang').show();
                $('#tampilan-tahun').show();
                $('#tampilan-bulan').show();
                $('#tampilan-rentang').html(response.range);
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              },
              complete: function() {
                $('#container-wait').hide();
              }
            });
          } else {
            $('#tampilan-rentang').hide();
            $('#tampilan-tahun').hide();
            $('#tampilan-bulan').hide();
            $('#tampilan-rentang').html(' ');
          }
        });
        $('#btn-custom-reset').click(function() {
          $('#tampilan-kategori--select').prop('selectedIndex', 0);
          $('#tampilan-tahun--select').prop('selectedIndex', 0);
          $('#tampilan-bulan--select').prop('selectedIndex', 0);
          $('#tampilan-rentang').hide();
          $('#tampilan-tahun').hide();
          $('#tampilan-bulan').hide();
          if ($.fn.dataTable.isDataTable("#dataTable")) {
            table.destroy();
          }
        });
        $('#btn-custom-range').click(function() {
          $.ajax({
            type: 'POST',
            url: base_url + 'Dashboard/getViewRankingKaryawan',
            data: {
              'mode': $('#tampilan-kategori--select').val(),
              'bulan': $('#tampilan-bulan--select').val(),
              'tahun': $('#tampilan-tahun--select').val()
            },
            dataType: 'JSON',
            success: function(response) {
              $('#show-range').html(response.range);
              $('#ranking-content').html(response.html);
              console.log(response);
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Notifikasi" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        var table = $('#dataTable').DataTable({
          "order": [
            [0, "desc"]
          ]
        });

        $(document).on('click', '.row-notifikasi', function() {
          is_baca = $(this).find('.row-is_baca').val();
          id = $(this).find('.row-id').val();
          if (is_baca != 1) {
            $('#container-wait').show();
            $.ajax({
              type: 'POST',
              url: base_url + 'Notifikasi/terbaca',
              data: "id=" + id,
              success: function(response) {
                $('#data-table-notifikasi').html(response);
                table.destroy();
                table = $('#dataTable').DataTable({
                  "order": [
                    [0, "desc"]
                  ]
                });
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              },
              complete: function() {
                $('#container-wait').hide();
              }
            });
          }
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Produk" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script>
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        var table = $('#dataTable').DataTable({
          dom: 'Blfrtip',
          buttons: [{
            extend: 'excel',
            exportOptions: {
              columns: ':visible'
            }
          }, {
            extend: 'pdf',
            orientation: 'landscape',
            exportOptions: {
              columns: ':visible'
            }
          }, {
            extend: 'print',
            exportOptions: {
              columns: ':visible'
            }
          }],
          "destroy": true,
          "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
          }],
          "order": [
            [1, 'asc']
          ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
          "aLengthMenu": [
            [25, 50, 100],
            [25, 50, 100]
          ]
        });

        table.on('order.dt search.dt', function() {
          table.column(0, {
            search: 'applied',
            order: 'applied'
          }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
            table.cell(cell).invalidate('dom');
          });
        }).draw();
      })
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Produk" && ($this->uri->segment(2) == "tambahProduk" || $this->uri->segment(2) == "save")) { ?>
    <script>
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        var k = new FileReader();
        k.onload = function(d) {
          $("#tampil-foto-produk").attr("src", d.target.result)
        };

        function a(d) {
          if (d.files && d.files[0]) {
            var file = d.files[0];
            if (file.type.match(/\/(gif|jpg|jpeg|png)$/)) {
              alert('yes')
              k.readAsDataURL(d.files[0]);
            } else {
              $.confirm({
                title: 'Ekstensi tidak sesuai!',
                content: 'Ekstensi file yang anda upload tidak termasuk gif, jpg, jpeg, atau png.',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
          }
        }
        $("#btn-upload-produk").change(function() {
          a(this)
        });
        var c = $("#is_error").val();
        if (c == "1") {
          if ($("#bkp_sku").val() != "") {
            $("#input_sku").val($("#bkp_sku").val())
          }
          if ($("#bkp_kategori").val() != "") {
            $("#input_kategori").val($("#bkp_kategori").val())
          }
          if ($("#bkp_nama").val() != "") {
            $("#input_nama").val($("#bkp_nama").val())
          }
          if ($("#bkp_merk").val() != "") {
            $("#input_merk").val($("#bkp_merk").val())
          }
          if ($("#bkp_deskripsi").val() != "") {
            $("#input_deskripsi").val($("#bkp_deskripsi").val())
          }
          if ($("#bkp_harga_modal").val() != "") {
            $("#input_harga_modal").val($("#bkp_harga_modal").val())
          }
          if ($("#bkp_harga_jual").val() != "") {
            $("#input_harga_jual").val($("#bkp_harga_jual").val())
          }
          if ($("#bkp_profit").val() != "") {
            $("#input_profit").val($("#bkp_profit").val())
          }
          if ($("#bkp_diskon").val() != "") {
            $("#input_diskon").val($("#bkp_diskon").val())
          }
        } else {
          $("#input_kategori").val($("#disp_kategori").val())
        }
        var j = new AutoNumeric("#input_harga_modal", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        var b = new AutoNumeric("#input_harga_jual", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        var z = new AutoNumeric("#input_diskon", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        var l = new AutoNumeric("#input_profit", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        $("#input_diskon").click(function() {
          var modal = $("#input_harga_modal").val();
          var jual = $("#input_harga_jual").val();

          if (jual == "" || modal == "") {
            $.confirm({
              title: 'Error',
              content: 'Anda harus mengisi harga modal dan harga jual!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          }
        });
        $("#input_diskon").change(function() {
          var w = j.getNumber();
          var x = b.getNumber();
          var y = z.getNumber();

          var profitDiskon = x - w - y;

          if (x > w) {
            l.set(profitDiskon);
          } else {
            l.set("");
          }
        });
        $("#input_harga_modal, #input_harga_jual").change(function() {
          var e = j.getNumber();
          var d = b.getNumber();
          if (d > e) {
            l.set(d - e)
          } else {
            l.set("")
          }
        });
        $('#input_nama').change(function() {
          x = $(this).val();
          caps = x.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
          });
          $(this).val(caps);
        });
        $("#btn-save-produk").click(function() {
          $('#container-wait').show();
          if (j.getNumber() == "") {
            $("#input_harga_modal").val("")
          } else {
            $("#input_harga_modal").val(j.getNumber())
          }
          if (b.getNumber() == "") {
            $("#input_harga_jual").val("")
          } else {
            $("#input_harga_jual").val(b.getNumber())
          }
          if (z.getNumber() == "") {
            $("#input_diskon").val("")
          } else {
            $("#input_diskon").val(z.getNumber())
          }
          if (l.getNumber() == "") {
            $("#input_profit").val("")
          } else {
            $("#input_profit").val(l.getNumber())
          }
          $("#form-produk").submit()
        });
        $("#btn-update-produk").click(function() {
          $('#container-wait').show();
          $("#form-produk").submit()
        })
      });
    </script>;
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Produk" && ($this->uri->segment(2) == "editProduk" || $this->uri->segment(2) == "edit")) { ?>
    <script>
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        var e = new FileReader();
        e.onload = function(a) {
          $("#tampil-foto-produk").attr("src", a.target.result);
        };

        function i(a) {
          if (a.files && a.files[0]) {
            e.readAsDataURL(a.files[0]);
          }
        }
        $("#btn-upload-produk").change(function() {
          i(this);
        });
        $('#btn-delete-produk').click(function(e) {
          e.preventDefault();
          var lokasi = ($(this).attr('href'));
          $.confirm({
            title: 'Hapus Data Produk',
            content: 'Apakah anda yakin untuk menghapus produk ini?',
            type: 'red',
            typeAnimated: true,
            buttons: {
              DELETE: {
                btnClass: 'btn-red',
                action: function() {
                  location.href = lokasi;
                }
              },
              CANCEL: function() {}
            }
          });
        });
        $("#input_kategori").val($("#disp_kategori").val());
        var f = new AutoNumeric("#input_harga_modal", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        var h = new AutoNumeric("#input_harga_jual", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        var z = new AutoNumeric("#input_diskon", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        var d = new AutoNumeric("#input_profit", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        $("#input_diskon").click(function() {
          var modal = $("#input_harga_modal").val();
          var jual = $("#input_harga_jual").val();

          if (jual == "" || modal == "") {
            $.confirm({
              title: 'Error',
              content: 'Anda harus mengisi harga modal dan harga jual!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          }
        });
        $("#input_diskon").change(function() {
          var w = f.getNumber();
          var x = h.getNumber();
          var y = z.getNumber();

          if (x > w) {
            d.set(x - w - y)
          } else {
            d.set("")
          }
        });
        $("#input_harga_modal, #input_harga_jual").change(function() {
          var a = f.getNumber();
          var b = h.getNumber();
          if (b > a) {
            d.set(b - a)
          } else {
            d.set("")
          }
        });
        $("#btn-update-produk").click(function() {
          if (f.getNumber() == "") {
            $("#input_harga_modal").val("")
          } else {
            $("#input_harga_modal").val(f.getNumber())
          }
          if (h.getNumber() == "") {
            $("#input_harga_jual").val("")
          } else {
            $("#input_harga_jual").val(h.getNumber())
          }
          if (z.getNumber() == "") {
            $("#input_diskon").val("")
          } else {
            $("#input_diskon").val(z.getNumber())
          }
          if (d.getNumber() == "") {
            $("#input_profit").val("")
          } else {
            $("#input_profit").val(d.getNumber())
          }
          $("#form-produk").submit()
        })
        $('#btn-update-produk').click(function() {
          $("#form-produk").submit()
        })
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Kasir"  && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "admin" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      var url_orig = window.location.href;

      function deleteOne(rowid) {
        $('#container-wait').show();
        $.ajax({
          type: 'POST',
          url: base_url + 'Kasir/remove',
          data: 'rowid=' + rowid,
          success: function(responsedel) {
            $('.barang' + rowid).remove('.barang' + rowid);
            $('#list-cart').html(responsedel);
            $.ajax({
              type: "GET",
              url: base_url + 'Kasir/getGrandTotal/text',
              success: function(response) {
                $('#disp-grandtotal').text(response);
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                alert(xhr.responseText) // munculkan alert
              }
            });
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          },
          complete: function() {
            $('#container-wait').hide();
          }
        });
      }

      function goTop() {
        $("html, body").animate({
          scrollTop: 0
        }, "slow");
        return false;
      }
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        $("#pesan-bayar").fadeTo(2000, 500).slideUp(500, function() {
          $("#pesan-bayar").slideUp(500);
        });
        $("#berhasil-hapus").hide();
        var nama;
        var contact;
        const input_jumlah_bayar = new AutoNumeric('#input-jumlah-bayar', {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        const disp_kembalian_cash = new AutoNumeric('#disp-kembalian-cash', {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        const disp_kembalian_credit = new AutoNumeric('#disp-kembalian-credit', {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        const input_jumlah_customer = new AutoNumeric('#input_jumlah_customer', {
          allowDecimalPadding: false
        });
        const harga = AutoNumeric.multiple('.disp-harga', {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });
        const cpcash = new AutoNumeric('#input_cp_cash', {
          allowDecimalPadding: false,
          digitGroupSeparator: "",
          leadingZero: "keep"
        });
        const cpcredit = new AutoNumeric('#input_cp_credit', {
          allowDecimalPadding: false,
          digitGroupSeparator: "",
          leadingZero: "keep"
        });
        $('#input_nama_email_cash').change(function() {
          x = $(this).val();
          caps = x.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
          });
          $(this).val(caps);
        });
        $('#input_nama_cp_cash').change(function() {
          x = $(this).val();
          caps = x.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
          });
          $(this).val(caps);
        });
        $('#input_nama_email_credit').change(function() {
          x = $(this).val();
          caps = x.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
          });
          $(this).val(caps);
        });
        $('#input_nama_cp_credit').change(function() {
          x = $(this).val();
          caps = x.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
          });
          $(this).val(caps);
        });
        $('.btn-tidak-beli').click(function() {
          tk_id = $('#input_toko_id').val();

          $('#container-wait').show();
          $.ajax({
            type: "POST",
            url: base_url + 'Kasir/tambahPengunjungTidakBeli',
            data: "toko_id=" + tk_id,
            success: function(res) {
              $('.jml-tdk-beli').text(res);
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });
        $.ajax({
          type: "GET",
          url: base_url + 'Kasir/getGrandTotal',
          success: function(response) {
            $('#disp-grandtotal').text(response);
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });
        $("#container-katalog-cari").hide();
        $('#cari-barang').keyup(function() {
          $("#container-katalog-cari").show();
          $("#showProdukCard").hide();
          var cari = $(this).val().toLowerCase();

          $('#container-katalog-cari li').hide();

          $("#container-katalog-cari li").each(function() {
            var cari_sku = $(this).find('.cari-sku').text().toLowerCase();
            var cari_nama = $(this).find('.cari-nama').text().toLowerCase();

            if (cari_sku.indexOf(cari) != -1 || cari_nama.indexOf(cari) != -1) {
              $(this).show();
            }
          });
          if ($('#cari-barang').val() == "") {
            $("#container-katalog-cari").hide();
            $("#showProdukCard").show();
          }
        });
        $("#berhasil-hapus").hide();
        $('#hapus-cart-all').click(function() {
          $('#container-wait').show();
          $.ajax({
            type: "GET",
            url: base_url + 'Kasir/cekCartAny',
            success: function(response) {
              if (response == "true") {
                $.confirm({
                  title: 'Hapus Data Produk',
                  content: 'Apakah anda yakin untuk menghapus produk ini?',
                  type: 'red',
                  typeAnimated: true,
                  buttons: {
                    DELETE: {
                      btnClass: 'btn-red',
                      action: function() {
                        $.ajax({
                          type: 'POST',
                          url: base_url + 'Kasir/remove',
                          data: 'rowid=all',
                          success: function(responsedel) {
                            $('#list-cart').html('<div id="berhasil-hapus" class="alert alert-success alert-dismissible fade show" role="alert">Cart berhasil di hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            $.ajax({
                              type: "GET",
                              url: base_url + 'Kasir/getGrandTotal',
                              success: function(response) {
                                $('#disp-grandtotal').text(response);
                              },
                              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                                console.log(xhr.responseText) // munculkan alert
                              }
                            });
                            $("#berhasil-hapus").fadeTo(2000, 500).slideUp(500, function() {
                              $("#berhasil-hapus").slideUp(500);
                            });
                          },
                          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                            console.log(xhr.responseText) // munculkan alert
                          }
                        });
                      }
                    },
                    CANCEL: function() {}
                  }
                });
              }
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        })
        $('.btn-beli').click(function() {
          var inputsku = $(this).attr('rel');
          var max_beli = $(this).find('.qty-tersedia').val();
          $('#container-wait').show();

          $.ajax({
            type: 'POST',
            url: base_url + 'Kasir/getTotalQtyCart/' + inputsku,
            success: function(terbeli) {
              terbeli = parseInt(terbeli);
              terbeli += 1;
              selisih = max_beli - terbeli;
              console.log('max_beli: ' + max_beli);
              console.log('terbeli: ' + terbeli);
              console.log(selisih);
              if (selisih >= 0) {
                $.ajax({
                  type: 'POST',
                  url: base_url + 'Kasir/add',
                  data: "sku=" + inputsku + "&max_beli=" + max_beli,
                  success: function(responseadd) {
                    $('#list-cart').html(responseadd);
                    $('html, body').animate({
                      scrollTop: $("div.tespak").offset().top
                    }, 100);
                  },
                  error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                    console.log(xhr.responseText) // munculkan alert
                  },
                  complete: function() {
                    $.ajax({
                      type: "GET",
                      url: base_url + 'Kasir/getGrandTotal',
                      success: function(response) {
                        $('#disp-grandtotal').text(response);
                      },
                      error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                        console.log(xhr.responseText) // munculkan alert
                      }
                    });
                  }
                });
              } else {
                $.confirm({
                  title: 'Error',
                  content: 'Stok produk ini di toko ini sudah habis!',
                  type: 'red',
                  typeAnimated: true,
                  buttons: {
                    CLOSE: function() {}
                  }
                });
              }
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });
        $(document).on('click', '.btn-tambah-beli', function() {
          var inputsku = $(this).attr('rel');
          var max_beli = $(this).find('.qty-tersedia').val();


          $('#container-wait').show();
          $.ajax({
            type: 'GET',
            url: base_url + 'Kasir/getTotalQtyCart/' + inputsku,
            success: function(terbeli) {
              terbeli = parseInt(terbeli);
              terbeli += 1;
              selisih = max_beli - terbeli;
              console.log('max_beli: ' + max_beli);
              console.log('terbeli: ' + terbeli);
              console.log(selisih);
              if (selisih >= 0) {
                $.ajax({
                  type: 'POST',
                  url: base_url + 'Kasir/add',
                  data: "sku=" + inputsku + "&max_beli=" + max_beli,
                  success: function(responseadd) {
                    $('#list-cart').html(responseadd);
                  },
                  error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                    console.log(xhr.responseText) // munculkan alert
                  },
                  complete: function() {
                    $.ajax({
                      type: "GET",
                      url: base_url + 'Kasir/getGrandTotal',
                      success: function(response) {
                        $('#disp-grandtotal').text(response);
                      },
                      error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                        console.log(xhr.responseText) // munculkan alert
                      }
                    });
                  }
                });
              } else {
                $.confirm({
                  title: 'Error',
                  content: 'Stok produk ini di toko ini sudah habis!',
                  type: 'red',
                  typeAnimated: true,
                  buttons: {
                    CLOSE: function() {}
                  }
                });
              }
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });
        $(document).on('click', '.btn-kurang-beli', function() {
          rowid = $(this).find('.cart-rowid').val();
          qty_bfr = parseInt($(this).find('.bk-qty-terbeli').val());
          qty_after = qty_bfr - 1;

          $('#container-wait').show();
          $.ajax({
            type: 'POST',
            url: base_url + 'Kasir/removeItemByOneQty',
            data: 'rowid=' + rowid + '&qty_after=' + qty_after,
            success: function(responsedel) {
              $('.barang' + rowid).remove('.barang' + rowid);
              $('#list-cart').html(responsedel);
              $.ajax({
                type: "GET",
                url: base_url + 'Kasir/getGrandTotal/text',
                success: function(response) {
                  $('#disp-grandtotal').text(response);
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                  alert(xhr.responseText) // munculkan alert
                }
              });
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });
        $('#btn-proses-pembayaran').click(function() {
          $('#container-wait').show();
          $.ajax({
            type: "GET",
            url: base_url + 'Kasir/cekCartAny',
            success: function(response) {
              if (response == "true") {
                $.ajax({
                  type: "GET",
                  url: base_url + 'Kasir/getGrandTotalNumberAjax',
                  success: function(response) {
                    input_jumlah_bayar.set(response);
                  },
                  error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                    console.log(xhr.responseText) // munculkan alert
                  },
                  complete: function() {
                    $.ajax({
                      type: "GET",
                      url: base_url + 'Kasir/getGrandTotal',
                      success: function(response) {
                        $('#grand-total-modal').text(response);
                      },
                      error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                        console.log(xhr.responseText) // munculkan alert
                      },
                      complete: function() {
                        $('#displayMetodeBayar').show();
                        $('#modal-kasir').show();
                        $('#displayInvoiceCash').hide();
                        $('#displayInvoiceCredit').hide();
                        goTop();
                      }
                    });
                  }
                });
              } else {
                $.confirm({
                  title: 'Error',
                  content: 'Tidak ada item pada cart pembayaran!',
                  type: 'red',
                  typeAnimated: true,
                  buttons: {
                    CLOSE: function() {}
                  }
                });
              }
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        });
        // CASH
        $('#btn-metode-bayar-cash').click(function() {
          jml_cust = $('#input_jumlah_customer').val();
          cek_jml = /[0-9]{1,}/.test(jml_cust);
          jml_cust = parseInt(jml_cust);

          if (cek_jml === true && jml_cust > 0) {
            $('#invoice-via-email-cash').removeClass('active');
            $('#invoice-via-sms-cash').removeClass('active');
            $("#form-sms-customer-cash").hide();
            $("#form-email-customer-cash").hide();
            $("#form-email-customer-credit").hide();
            $("#form-sms-customer-credit").hide();
            $.ajax({
              type: "GET",
              url: base_url + 'Kasir/getGrandTotalNumberAjax',
              success: function(response) {
                var uangMasuk = input_jumlah_bayar.getNumber();
                if (uangMasuk >= response) {
                  disp_kembalian_cash.set(uangMasuk - response);
                  $('#displayMetodeBayar').hide();
                  $('#displayInvoiceCredit').hide();
                  $('#displayInvoiceCash').show();
                } else {
                  $.confirm({
                    title: 'Error',
                    content: 'Jumlah uang masuk harus lebih besar atau sama dengan grand total!',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                      CLOSE: function() {}
                    }
                  });
                }
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              },
            });
          } else if (cek_jml === true && jml_cust <= 0) {
            $.confirm({
              title: 'Error',
              content: 'Jumlah customer tidak boleh kurang dari atau sama dengan 0!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          } else {
            $.confirm({
              title: 'Error',
              content: 'Jumlah customer harus diisi!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          }
        });
        $('#invoice-via-email-cash').click(function() {
          $('#invoice-via-email-cash').addClass('active');
          $('#invoice-via-sms-cash').removeClass('active');
          $("#form-sms-customer-cash").hide();
          $("#form-email-customer-cash").show();
        });
        $('#btn-email-customer-cash').click(function() {
          $('#error_nama_email_cash').hide();
          $('#error_email_cash').hide();
          nama = $('#input_nama_email_cash').val();
          contact = $('#input_email_customer').val();
          if (nama != "" && contact != "") {
            data = '{"nama":"' + nama + '", "contact":"' + contact + '"}';
            prosesInvoice('email', 'Cash', data);
          } else {
            if (nama == "")
              $('#error_nama_email_cash').show();
            if (contact == "")
              $('#error_email_cash').show();
          }
        });
        $('#invoice-via-sms-cash').click(function() {
          $('#invoice-via-sms-cash').addClass('active');
          $('#invoice-via-email-cash').removeClass('active');
          $("#form-email-customer-cash").hide();
          $("#form-sms-customer-cash").show();
        });
        $('#btn-cp-customer-cash').click(function() {
          $('#error_nama_cp_cash').hide();
          $('#error_cp_cash').hide();
          nama = $('#input_nama_cp_cash').val();
          contact = $('#input_cp_cash').val();
          if (nama != "" && contact != "") {
            data = '{"nama":"' + nama + '", "contact":"' + contact + '"}';
            prosesInvoice('cp', 'Cash', data);
          } else {
            if (nama == "")
              $('#error_nama_cp_cash').show();
            if (contact == "")
              $('#error_cp_cash').show();
          }
        });
        // END OF CASH
        // CREDIT
        $('#btn-metode-bayar-credit').click(function() {
          jml_cust = $('#input_jumlah_customer').val();
          cek_jml = /[0-9]{1,}/.test(jml_cust);
          jml_cust = parseInt(jml_cust);

          if (cek_jml === true && jml_cust > 0) {
            $("#form-sms-customer-credit").hide();
            $("#form-email-customer-credit").hide();
            $("#form-email-customer-credit").hide();
            $("#form-sms-customer-credit").hide();
            $.ajax({
              type: "GET",
              url: base_url + 'Kasir/getGrandTotalNumberAjax',
              success: function(response) {
                var uangMasuk = input_jumlah_bayar.getNumber();
                if (uangMasuk >= response) {
                  disp_kembalian_credit.set(uangMasuk - response);
                  $('#displayMetodeBayar').hide();
                  $('#displayInvoiceCash').hide();
                  $('#displayInvoiceCredit').show();
                } else {
                  $.confirm({
                    title: 'Error',
                    content: 'Jumlah uang masuk harus lebih besar atau sama dengan grand total!',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                      CLOSE: function() {}
                    }
                  });
                }
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              },
            });
          } else if (cek_jml === true && jml_cust <= 0) {
            $.confirm({
              title: 'Error',
              content: 'Jumlah customer tidak boleh kurang dari atau sama dengan 0!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          } else {
            $.confirm({
              title: 'Error',
              content: 'Jumlah customer harus diisi!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          }
        });
        $('#invoice-via-email-credit').click(function() {
          $('#invoice-via-email-credit').addClass('active');
          $('#invoice-via-sms-credit').removeClass('active');
          $("#form-sms-customer-credit").hide();
          $("#form-email-customer-credit").show();
        });
        $('#btn-email-customer-credit').click(function() {
          $('#error_nama_email_credit').hide();
          $('#error_email_credit').hide();
          nama = $('#input_nama_email_credit').val();
          contact = $('#input_email_customer_credit').val();
          if (nama != "" && contact != "") {
            data = '{"nama":"' + nama + '", "contact":"' + contact + '"}';
            prosesInvoice('cp', 'Cash', data);
          } else {
            if (nama == "")
              $('#error_nama_email_credit').show();
            if (contact == "")
              $('#error_email_credit').show();
          }
        });
        $('#invoice-via-sms-credit').click(function() {
          $('#invoice-via-sms-credit').addClass('active');
          $('#invoice-via-email-credit').removeClass('active');
          $("#form-email-customer-credit").hide();
          $("#form-sms-customer-credit").show();
        });
        $('#btn-cp-customer-credit').click(function() {
          $('#error_nama_cp_credit').hide();
          $('#error_cp_credit').hide();
          nama = $('#input_nama_cp_credit').val();
          contact = $('#input_cp_credit').val();
          data = '{"nama":"' + nama + '", "contact":"' + contact + '"}';
          prosesInvoice('cp', 'Credit Card', data);

          nama = $('#input_nama_cp_credit').val();
          contact = $('#input_cp_credit').val();
          if (nama != "" && contact != "") {
            data = '{"nama":"' + nama + '", "contact":"' + contact + '"}';
            prosesInvoice('cp', 'Cash', data);
          } else {
            if (nama == "")
              $('#error_nama_cp_credit').show();
            if (contact == "")
              $('#error_cp_credit').show();
          }
        });
        // END OF CREDIT

        function prosesInvoice(contact_mode, metode, data) {
          $('#container-wait').show();
          obj = JSON.parse(data);

          cek_nama = /\S/.test(obj.nama);

          $('#error_email_cash').hide();
          $('#error_email_credit').hide();
          $('#error_cp_cash').hide();
          $('#error_cp_credit').hide();

          if (contact_mode == 'email') {
            cek_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(obj.contact);
            if (cek_email && cek_nama) {
              prosesInvoice2(contact_mode, metode, data);
            } else {
              if (metode == 'Cash')
                $('#error_email_cash').show();
              else
                $('#error_email_credit').show();
            }
          } else {
            cek_cp = /[0-9]{10,}/.test(obj.contact);
            if (cek_cp && cek_nama) {
              prosesInvoice2(contact_mode, metode, data);
            } else {
              if (metode == 'Cash')
                $('#error_cp_cash').show();
              else
                $('#error_cp_credit').show();
            }
          }

        }

        function prosesInvoice2(contact_mode, metode, data) {
          obj = JSON.parse(data);

          var toko_id = $('#input_toko_id').val();
          var jml_customer = input_jumlah_customer.getNumber();
          $.ajax({
            type: "POST",
            url: base_url + 'Kasir/prosesPembayaran',
            data: "contact_mode=" + contact_mode + "&nama=" + obj.nama + "&contact=" + obj.contact + "&metode=" + metode + "&toko_id=" + toko_id + "&jml_cust=" + jml_customer,
            dataType: 'JSON',
            success: function(res) {
              str_res = JSON.stringify(res);
              console.log(str_res)
              if (res.mode_receipt == 'email') {
                if (res.status_receipt == 'error') {

                  window.location.replace(base_url + 'Kasir/invoiceError/' + res.mode_receipt + '/0/' + res.cust_id);
                } else {
                  prosesInvoice3(obj.nama, res.mode_receipt);
                }
              } else {
                if (res.status_receipt == 0) {
                  prosesInvoice3(obj.nama, 'sms');
                } else if (res.status_receipt == 1) {
                  $.confirm({
                    title: 'Error',
                    content: 'Nomor HP yang dimasukkan tidak valid!',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                      CLOSE: function() {
                        window.location.replace(base_url + 'Kasir/invoiceError/' + res.mode_receipt + '/' + res.status_receipt + '/' + res.cust_id);
                      }
                    }
                  });
                }
              }
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        }

        function prosesInvoice3(nama, mode) {
          $('#modal-kasir').hide();
          $.confirm({
            title: 'Sukses',
            content: 'Invoice berhasil dikirim ke customer <span style="text-transform:capitalize">' + nama + '</span> melalui ' + mode + '.',
            type: 'green',
            typeAnimated: true,
            buttons: {
              CLOSE: function() {
                window.location.replace(url_orig);
              }
            }
          });
        }
        $('#xxx').click(function() {
          $.ajax({
            type: "GET",
            url: base_url + 'Kasir/tes',
            success: function(response) {
              alert(response)
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
          });
        });
        $('#btn-close').click(function() {
          $('#modal-kasir').hide();
        });
        $('#clear-search-bar').click(function() {
          $('#cari-barang').val("");
          $("#container-katalog-cari").hide();
          $("#showProdukCard").show();
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Kasir"  && $this->uri->segment(2) == "invoiceError") { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        const cpcredit = new AutoNumeric('#input_cp_customer', {
          allowDecimalPadding: false,
          digitGroupSeparator: "",
          leadingZero: "keep"
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "LapPenjualan" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      function ribuan(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        $('#tes').click(function() {
          $.ajax({
            url: base_url + 'LapPenjualan/tes', // URL tujuan
            type: 'GET', // Tentukan type nya POST atau GET
            success: function(response) {
              alert(response)
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              alert(xhr.responseText) // munculkan alert
            }
          });
        });
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
        var datenow = new Date();
        $('[data-toggle="datepicker"]').datepicker({
          format: 'yyyy-mm-dd',
          startDate: datenow.getFullYear() + '/01/01',
          autoHide: true,
          startView: 1
        });
        $('#dataTable').DataTable({
          dom: 'Blfrtip',
          buttons: [
            'excel', 'pdf'
          ],
          "destroy": true,
          "processing": true,
          "serverSide": true,
          "ordering": true, // Set true agar bisa di sorting
          "order": [
            [1, 'desc']
          ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
          "ajax": {
            "url": base_url + 'LapPenjualan/dataTables/all', // URL file untuk proses select datanya
            "type": "POST",
            "data": {
              "tgl_start": 'all',
              "tgl_end": 'all'
            }
          },
          "deferRender": true,
          "aLengthMenu": [
            [25, 50, 100],
            [25, 50, 100]
          ], // Combobox Limit
          "columns": [{
              "render": function(data, type, row) { // Tampilkan kolom aksi
                html = '<a href="#" class="link-view-invoice" rel="' + row.id + '">' + row.kode_invoice + '</a>';
                return html;
              }
            },
            {
              "data": "time"
            },
            {
              "data": "k_nama"
            },
            {
              "data": "c_nama"
            },
            {
              "data": "t_nama"
            },
            {
              "data": "jenis_pembayaran"
            },
            {
              "render": function(data, type, row) { // Tampilkan jenis kelamin
                return 'Rp ' + ribuan(row.total); // Tampilkan jenis kelaminnya
              }
            },
            {
              "render": function(data, type, row) { // Tampilkan kolom aksi
                html = "";
                if (row.status == 0)
                  html = '<span class="badge badge-pill badge-success">Sukses</span>';
                else if (row.status == 1)
                  html = '<span class="badge badge-pill badge-warning">Refund Sebagian</span>';
                else
                  html = '<span class="badge badge-pill badge-danger">Refund</span>';
                return html;
              }
            }
          ],
        });
        $('#btn-close, #btn-close-foot').click(function() {
          $('#modal-invoice').hide();
        });
        $('#list-toko').change(function() {
          toko_id = $(this).val();
          nama_toko = $(this).attr('rel');

          $('[data-toggle="datepicker"]').each(function() {
            $(this).val('');
          });

          $('#dataTable').DataTable().destroy();
          $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
              [1, 'desc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
              "url": base_url + 'LapPenjualan/dataTables/' + toko_id, // URL file untuk proses select datanya
              "type": "POST",
              "data": {
                "tgl_start": 'all',
                "tgl_end": 'all'
              }
            },
            "deferRender": true,
            "aLengthMenu": [
              [25, 50, 100],
              [25, 50, 100]
            ], // Combobox Limit
            "columns": [{
                "render": function(data, type, row) { // Tampilkan kolom aksi
                  html = '<a href="#" class="link-view-invoice" rel="' + row.id + '">' + row.kode_invoice + '</a>';
                  return html;
                }
              },
              {
                "data": "time"
              },
              {
                "data": "k_nama"
              },
              {
                "data": "c_nama"
              },
              {
                "data": "t_nama"
              },
              {
                "data": "jenis_pembayaran"
              },
              {
                "render": function(data, type, row) { // Tampilkan jenis kelamin
                  return 'Rp ' + ribuan(row.total); // Tampilkan jenis kelaminnya
                }
              },
              {
                "render": function(data, type, row) { // Tampilkan kolom aksi
                  html = "";
                  if (row.status == 0)
                    html = '<span class="badge badge-pill badge-success">Sukses</span>';
                  else if (row.status == 1)
                    html = '<span class="badge badge-pill badge-warning">Refund Sebagian</span>';
                  else
                    html = '<span class="badge badge-pill badge-danger">Refund</span>';
                  return html;
                }
              }
            ],
          });
        });
        $('#data-table-lappenjualan').on('click', 'a', function() {
          inv_id = $(this).attr('rel');
          $.ajax({
            url: base_url + 'LapPenjualan/getStatusInv/' + inv_id, // URL tujuan
            type: 'GET', // Tentukan type nya POST atau GET
            dataType: 'JSON',
            success: function(response) { // Ketika proses pengiriman berhasil
              if (response.status_inv == 0 && response.status_tgl == 1) {
                $('#btn-refund').show();
              } else {
                $('#btn-refund').hide();
              }
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            }
          });
          $.ajax({
            url: base_url + 'LapPenjualan/getViewInvoiceDetails/' + inv_id, // URL tujuan
            type: 'GET', // Tentukan type nya POST atau GET
            success: function(response) { // Ketika proses pengiriman berhasil
              $('#view-invoice-details').html(response);
              $('#modal-invoice').show();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#btn-replay-invoice').attr('href', base_url + 'LapPenjualan/sendUlangInvoice/' + inv_id);
              $('#btn-refund').attr('href', base_url + 'LapPenjualan/refund/' + inv_id);
            }
          });
        });
        $(document).on('click', '#btn-custom-range', function() {
          start = $('#input_start_date').val();
          end = $('#input_end_date').val();
          toko_id = $('#list-toko').val();

          if (start == '') {
            $('#error_input_start_date').text('Tanggal mulai belum terisi');
            $('#error_input_start_date').show();
          } else {
            $('#error_input_start_date').hide();
          }
          if (end == '') {
            $('#error_input_end_date').text('Tanggal akhir belum terisi');
            $('#error_input_end_date').show();
          } else {
            $('#error_input_end_date').hide();
          }

          if (start != '' && end != '') {
            $('#dataTable').DataTable().destroy();
            $('#dataTable').DataTable({
              "destroy": true,
              "processing": true,
              "serverSide": true,
              "ordering": true, // Set true agar bisa di sorting
              "order": [
                [1, 'desc']
              ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
              "ajax": {
                "url": base_url + 'LapPenjualan/dataTables/' + toko_id, // URL file untuk proses select datanya
                "type": "POST",
                "data": {
                  "tgl_start": start,
                  "tgl_end": end
                }
              },
              "deferRender": true,
              "aLengthMenu": [
                [25, 50, 100],
                [25, 50, 100]
              ], // Combobox Limit
              "columns": [{
                  "render": function(data, type, row) { // Tampilkan kolom aksi
                    html = '<a href="#" class="link-view-invoice" rel="' + row.id + '">' + row.kode_invoice + '</a>';
                    return html;
                  }
                },
                {
                  "data": "time"
                },
                {
                  "data": "k_nama"
                },
                {
                  "data": "c_nama"
                },
                {
                  "data": "t_nama"
                },
                {
                  "data": "jenis_pembayaran"
                },
                {
                  "render": function(data, type, row) { // Tampilkan jenis kelamin
                    return 'Rp ' + ribuan(row.total); // Tampilkan jenis kelaminnya
                  }
                },
                {
                  "render": function(data, type, row) { // Tampilkan kolom aksi
                    html = "";
                    if (row.status == 0)
                      html = '<span class="badge badge-pill badge-success">Sukses</span>';
                    else if (row.status == 1)
                      html = '<span class="badge badge-pill badge-warning">Refund Sebagian</span>';
                    else
                      html = '<span class="badge badge-pill badge-danger">Refund</span>';
                    return html;
                  }
                }
              ],
            });
          }
        });
        $(document).on('click', '#btn-custom-range-reset', function() {
          toko_id = $('#list-toko').val();
          nama_toko = $('#list-toko').attr('rel');

          $('#dataTable').DataTable().destroy();
          $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
              [1, 'desc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
              "url": base_url + 'LapPenjualan/dataTables/' + toko_id, // URL file untuk proses select datanya
              "type": "POST",
              "data": {
                "tgl_start": 'all',
                "tgl_end": 'all'
              }
            },
            "deferRender": true,
            "aLengthMenu": [
              [25, 50, 100],
              [25, 50, 100]
            ], // Combobox Limit
            "columns": [{
                "render": function(data, type, row) { // Tampilkan kolom aksi
                  html = '<a href="#" class="link-view-invoice" rel="' + row.id + '">' + row.kode_invoice + '</a>';
                  return html;
                }
              },
              {
                "data": "time"
              },
              {
                "data": "k_nama"
              },
              {
                "data": "c_nama"
              },
              {
                "data": "t_nama"
              },
              {
                "data": "jenis_pembayaran"
              },
              {
                "render": function(data, type, row) { // Tampilkan jenis kelamin
                  return 'Rp ' + ribuan(row.total); // Tampilkan jenis kelaminnya
                }
              },
              {
                "render": function(data, type, row) { // Tampilkan kolom aksi
                  html = "";
                  if (row.status == 0)
                    html = '<span class="badge badge-pill badge-success">Sukses</span>';
                  else if (row.status == 1)
                    html = '<span class="badge badge-pill badge-warning">Refund Sebagian</span>';
                  else
                    html = '<span class="badge badge-pill badge-danger">Refund</span>';
                  return html;
                }
              }
            ],
          });
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "LapPenjualan" && $this->uri->segment(2) == "refund") { ?>
    <script type="text/javascript">
      function digitSeparation(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      function replaceUangKembali() {
        total_barang_kembali = 0;
        total_uang_kembali = 0;
        $('.barang-row').each(function() {
          id = $(this).attr('rel');
          terbeli = parseInt($('#bk_jml_terbeli' + id).val());

          jml_kembali = parseInt($('#input_jml_kembali' + id).val());
          harga = parseInt($('#bk_harga' + id).val());
          total_diskon = parseInt($('#bk_diskon' + id).val());
          if (total_diskon == 0)
            diskon = 0;
          else
            diskon = total_diskon / terbeli;
          subtotal = parseInt($('#bk_subtotal' + id).val());

          total_barang_kembali += jml_kembali;
          total_uang_kembali = total_uang_kembali + ((jml_kembali * harga) - (jml_kembali * diskon));
          console.log('terbeli=' + terbeli + ', jml_kembali=' + jml_kembali + ', harga=' + harga + ', total_diskon=' + total_diskon + ', diskon=' + diskon + ', subtotal=' + subtotal + ', total_uang_kembali=' + total_uang_kembali);
        });

        str_uang_kembali = digitSeparation(total_uang_kembali);
        $('#disp-uang-kembali').text(str_uang_kembali);
        $('#disp-total-kembali').text(total_barang_kembali);
      }

      function goTop() {
        $("html, body").animate({
          scrollTop: 0
        }, "fast");
        return false;
      }
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        const jumlah_kembali = new AutoNumeric('#jumlah_kembali', {
          allowDecimalPadding: false,
          digitGroupSeparator: ""
        });

        $('#btn-close, #btn-refund-cancel').click(function() {
          $('#modal-refund').hide();
        });

        $('.check-to-refund').click(function() {
          if ($(this).is(':checked')) {
            idx = $(this).attr('rel');
            $('#container-wait').show();
            $.ajax({
              url: base_url + 'LapPenjualan/getQtyBarangInvoice/' + idx, // URL tujuan
              type: 'GET', // Tentukan type nya POST atau GET
              success: function(response) {
                $('#id-barang-modal').val(idx);
                $('#jml-terbeli').val(response);
                $('#disp-jml-terbeli').text(response);

                jumlah_kembali.set(0);
                goTop();
                $('#container-wait').hide();
                $('#modal-refund').show();
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              }
            });
          } else {
            idx = $(this).attr('rel');
            $('#id-barang-modal').val('');
            $('#jml_kembali' + idx).text(0);
            $('#jml-terbeli' + idx).val(0);
            $('#disp-jml-terbeli').text(0);
            jumlah_kembali.set(0);
            $('#input_jml_kembali' + idx).val(0);
          }
          replaceUangKembali();
        });

        $('#check-all-refund').click(function() {
          total_qty = 0;
          uang_kembali = 0;
          if ($(this).is(':checked')) {
            $('.barang-row').each(function() {
              id = $(this).attr('rel');
              terbeli = parseInt($('#bk_jml_terbeli' + id).val());
              $('#input_jml_kembali' + id).val(terbeli);
              $('#jml_kembali' + id).text(terbeli);
              $('.check-to-refund').prop('checked', true);

              subtotal = parseInt($('#bk_subtotal' + id).val());
              uang_kembali += subtotal;

              total_qty += terbeli;
            });
            $('#is-all-kembali').text('(semua)');
          } else {
            $('.barang-row').each(function() {
              id = $(this).attr('rel');
              $('#input_jml_kembali' + id).val(0);
              $('#jml_kembali' + id).text(0);
              $('.check-to-refund').prop('checked', false);
            });
            $('#is-all-kembali').text('');
          }
          str_uang_kembali = digitSeparation(uang_kembali);
          $('#disp-total-kembali').text(total_qty);
          $('#disp-uang-kembali').text(str_uang_kembali);
        })

        $('#jumlah_kembali').change(function() {
          x = jumlah_kembali.getNumber();
          y = $('#jml-terbeli').val();

          if (x < 0 || x > y) {
            if (x < 0) {
              $('#error_kembali').text('Jumlah yang dikembalikan tidak boleh kurang dari 0!');
            }
            if (x > y) {
              $('#error_kembali').text('Jumlah yang dikembalikan tidak boleh lebih dari jumlah terbeli!');
            }
          } else {
            $('#error_kembali').text('');
          }
        });

        $('#btn-refund-ok').click(function() {
          id = $('#id-barang-modal').val();
          kembali = $('#jumlah_kembali').val();
          $('#input_jml_kembali' + id).val(kembali);
          $('#jml_kembali' + id).text(kembali);
          $('#modal-refund').hide();

          replaceUangKembali();
        });

        $('#btn-refund-proses').click(function() {
          $('#container-wait').show();
          inv_id = $('#invoice-id').val();
          is_refund_all = 1;
          data_refund = [];
          is_atleast_refund = 0;

          $('.barang-row').each(function() {
            id = $(this).attr('rel');
            jml_kembali = parseInt($('#input_jml_kembali' + id).val());
            jml_semula = parseInt($('#bk_jml_terbeli' + id).val());

            data_refund.push({
              'id': id,
              'jml_refund': jml_kembali
            });

            if (jml_kembali > 0) {
              is_atleast_refund = 1;
            }

            if (jml_kembali > 0 && jml_kembali < jml_semula) {
              is_refund_all = 0;
            }
          });

          // tes = JSON.stringify(data_refund);
          // alert(is_atleast_refund)

          if (is_atleast_refund == 1) {
            $.ajax({
              url: base_url + 'LapPenjualan/prosesRefund/' + inv_id + '/' + is_refund_all, // URL tujuan
              type: 'POST', // Tentukan type nya POST atau GET
              data: {
                data: data_refund
              },
              success: function(response) {
                alert(response)
                if (response == 1) {
                  window.location.replace(base_url + 'LapPenjualan/landingRefund/' + inv_id + '/sukses');
                }
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              },
              complete: function() {
                $('#container-wait').hide();
              }
            });
          }
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "LapPenjualan" && $this->uri->segment(2) == "landingRefund") { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#container-wait').hide();
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "LapPenjualan" && $this->uri->segment(2) == "sendUlangInvoice") { ?>
    <script type="text/javascript">
      var mode, modeActive;

      function getContactBkp(mode) {
        contact = [];
        if (mode == 'sms') {
          contact['email'] = '';
          contact['cp'] = $('#cp-temp').val();
          return contact;
        } else {
          contact['email'] = $('#email-temp').val();
          contact['cp'] = '';
          return contact;
        }
      }

      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        mode = $('#contact-mode').val();
        modeActive = mode;

        $('#invoice-via-email').click(function() {
          $(this).addClass('active');
          $('#invoice-via-sms').removeClass('active');
          $('#judul-mode').text('Email :');
          $('#input_mode').val('email');

          modeActive = 'email';
          bkp_val = getContactBkp(mode);
          console.log(bkp_val['email'] + bkp_val['cp']);

          $('#input_contact').attr('placeholder', 'Email Customer');
          $('#input_contact').val(bkp_val['email']);

          $.ajax({
            type: "POST",
            url: base_url + 'LapPenjualan/updateModeViaFlashdata',
            data: 'updatedMode=' + modeActive,
            success: function() {},
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            }
          });
        });
        $('#invoice-via-sms').click(function() {
          $(this).addClass('active');
          $('#invoice-via-email').removeClass('active');
          $('#judul-mode').text('SMS :');
          $('#input_mode').val('sms');

          modeActive = 'sms';
          bkp_val = getContactBkp(mode);
          console.log(bkp_val['email'] + bkp_val['cp']);

          $('#input_contact').attr('placeholder', 'No. HP Customer');
          $('#input_contact').val(bkp_val['cp']);

          $.ajax({
            type: "POST",
            url: base_url + 'LapPenjualan/updateModeViaFlashdata',
            data: 'updatedMode=' + modeActive,
            success: function() {},
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            }
          });
        });

        $('#btn-sbmt-resend').click(function(e) {
          e.preventDefault();

          if (modeActive == 'email') {
            contact = $('#input_contact').val();
            cek_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(contact);

            if (cek_email) {
              $('#input_contact').removeClass('bg-error');
              $('#form-resend-invoice').submit();
            } else {
              $('#input_contact').addClass('bg-error');
              $.confirm({
                title: 'Error!',
                content: 'Email customer tidak valid',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
          } else {
            contact = $('#input_contact').val();
            cek_cp = /[0-9]{10,}/.test(contact);

            if (cek_cp) {
              $('#input_contact').removeClass('bg-error');
              $('#form-resend-invoice').submit();
            } else {
              $('#input_contact').addClass('bg-error');
              $.confirm({
                title: 'Error!',
                content: 'No. HP customer tidak valid',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
          }
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "LapPenjualan" && $this->uri->segment(2) == "landingSuksesResendInvoice") { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#container-wait').hide();
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Toko" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      var id;
      var data_bawaan;

      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        $("#btn-close, #btn-cancel").click(function() {
          $("#modal-toko").hide();
          $(".container-pesan-error").hide();
        });
        $("#btn-tambah-toko").click(function() {
          $("#modal-toko").show();
          $(".judul-modal-header").html("Tambah Toko Cabang Baru");
          $(".modal-form").trigger("reset");
          $("#btn-save-toko").show();
          $("#btn-save-edit-toko").hide();
          $("#btn-delete-toko").hide();
        });
        $('#data-table-toko').on('click', 'a', function(e) {
          e.preventDefault();
          $('#modal-toko').show();
          id = $(this).data('id');
          $('.modal-form').trigger("reset");
          $('#btn-save-toko').hide(); // Sembunyikan tombol simpan
          $('#btn-save-edit-toko').show();
          $('#btn-delete-toko').show();


          // Set judul modal dialog menjadi Form Ubah Data
          $('.judul-modal-header').html('Edit Data Toko Cabang');

          var tr = $(this).closest("tr"); // Cari tag tr paling terdekat
          var nama = tr.find('.value-nama').val(); // Ambil nis dari input type hidden
          var alamat = tr.find('.value-alamat').val(); // Ambil nis dari input type hidden

          $('#input_nama').val(nama);
          $('#input_alamat').val(alamat);

          data_bawaan = $("#modal-toko form").serialize();
        })
        $('#input_nama').change(function() {
          x = $(this).val();
          caps = x.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
          });
          $(this).val(caps);
        });
        $("#btn-save-toko").click(function() {
          $.ajax({
            url: base_url + "Toko/simpan", // URL tujuan
            type: "POST", // Tentukan type nya POST atau GET
            data: $("#modal-toko form").serialize(), // Ambil semua data yang ada didalam tag form
            dataType: "json",
            beforeSend: function(e) {
              if (e && e.overrideMimeType) {
                e.overrideMimeType("application/jsoncharset=UTF-8")
              }
            },
            success: function(response) {
              if (response.status == "sukses") {
                $("#pesan-sukses").html(response.pesan).fadeIn().delay(3000).fadeOut();

                $("#modal-toko").hide(); // Close / Tutup Modal Dialog
                $("#data-table-toko").html(response.html);
              } else {
                $("#modal-toko").scrollTop();
                $(".container-pesan-error").show();
                $(".pesan-error").html(response.pesan).show();
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // Ketika terjadi error
              console.log(xhr.responseText); // munculkan alert
            }
          });
        });
        $('#btn-save-edit-toko').click(function() { // Ketika tombol edit di klik
          if (data_bawaan != $("#modal-toko form").serialize()) {
            $.ajax({
              url: base_url + 'Toko/edit/' + id, // URL tujuan
              type: 'POST', // Tentukan type nya POST atau GET
              data: $("#modal-toko form").serialize(), // Ambil semua data yang ada didalam tag form
              dataType: 'json',
              beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                  e.overrideMimeType('application/jsoncharset=UTF-8')
                }
              },
              success: function(response) {
                if (response.status == 'sukses') {
                  $('#pesan-sukses').html(response.pesan).fadeIn().delay(3000).fadeOut()

                  $('#modal-toko').hide() // Close / Tutup Modal Dialog
                  $('#data-table-toko').html(response.html)
                } else {
                  $('.container-pesan-error').show()
                  $('.pesan-error').html(response.pesan).show()
                }
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              }
            })
          } else {
            $('#pesan-sukses').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">Tidak ada perubahan data!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>').fadeIn().delay(3000).fadeOut()
            $('#modal-toko').hide()
          }
          data_bawaan = null;
        });
        $('#btn-delete-toko').click(function() { // Ketika tombol hapus di klik
          $.confirm({
            title: 'Hapus Data Toko Cabang',
            content: '<p>Anda yakin ingin menghapus data toko cabang ini?</p><p>Pastikan toko cabang ini tidak memiliki list produk pada menu inventory!</p>',
            type: 'red',
            typeAnimated: true,
            buttons: {
              tryAgain: {
                text: 'DELETE',
                btnClass: 'btn-red',
                action: function() {
                  $.ajax({
                    url: base_url + 'Toko/delete/' + id, // URL tujuan
                    type: 'GET', // Tentukan type nya POST atau GET
                    dataType: 'json',
                    beforeSend: function(e) {
                      if (e && e.overrideMimeType) {
                        e.overrideMimeType('application/jsoncharset=UTF-8')
                      }
                    },
                    success: function(response) { // Ketika proses pengiriman berhasil
                      $('#modal-toko').hide() // Close / Tutup Modal Dialog
                      $('#data-table-toko').html(response.html)
                      $('#pesan-sukses').html(response.pesan).fadeIn().delay(3000).fadeOut()
                    },
                    error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                      console.log(xhr.responseText) // munculkan alert
                    }
                  })
                }
              },
              close: {
                text: 'CANCEL',
                action: function() {}
              }
            }
          })
        })
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "KategoriProduk" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        var table = $('#dataTable').DataTable({
          "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
          }],
          "order": [
            [1, 'asc']
          ]
        });

        table.on('order.dt search.dt', function() {
          table.column(0, {
            search: 'applied',
            order: 'applied'
          }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
          });
        }).draw();

        var id = "error"
        var data_bawaan

        $('#input_nama').change(function() {
          x = $(this).val();
          caps = x.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
          });
          $(this).val(caps);
        });

        $("#btn-close, #btn-cancel").click(function() {
          $("#modal-pengguna, #modal-kategori").hide()
          $(".container-pesan-error").hide()
        })

        // ----------------- KATEGORI PRODUK -----------------
        $("#btn-tambah-kategori").click(function() {
          $("#modal-kategori").show()
          $(".judul-modal-header").html("Tambah Kategori Baru")
          $(".modal-form").trigger("reset")
          $("#btn-save-kategori").show()
          $("#btn-save-edit-kategori").hide()
          $("#btn-delete-kategori").hide()
        })

        $('#data-table-kategori').on('click', 'a', function(e) {
          e.preventDefault()
          $('#modal-kategori').show()
          id = $(this).data('id')
          $('.modal-form').trigger("reset")
          $('#btn-save-kategori').hide() // Sembunyikan tombol simpan
          $('#btn-save-edit-kategori').show()
          $('#btn-delete-kategori').show()


          // Set judul modal dialog menjadi Form Ubah Data
          $('.judul-modal-header').html('Edit Data Kategori Produk')

          var tr = $(this).closest("tr"); // Cari tag tr paling terdekat
          var nama = tr.find('.value-nama').val() // Ambil nis dari input type hidden

          $('#input_nama').val(nama) // Set value dari textbox nis yang ada di form

          data_bawaan = $("#modal-kategori form").serialize()
        })

        $("#btn-save-kategori").click(function() {
          $.ajax({
            url: base_url + "KategoriProduk/simpan", // URL tujuan
            type: "POST", // Tentukan type nya POST atau GET
            data: $("#modal-kategori form").serialize(), // Ambil semua data yang ada didalam tag form
            dataType: "json",
            beforeSend: function(e) {
              if (e && e.overrideMimeType) {
                e.overrideMimeType("application/jsoncharset=UTF-8")
              }
            },
            success: function(response) {
              if (response.status == "sukses") {
                $("#pesan-sukses").html(response.pesan).fadeIn().delay(3000).fadeOut()

                $("#modal-kategori").hide() // Close / Tutup Modal Dialog
                $("#data-table-kategori").html(response.html)
              } else {
                // Jika statusnya = gagal
                /*
                 * Ambil pesan errornya dan set ke div pesan-error
                 * Lalu munculkan div pesan-error nya
                 */
                $("#modal-kategori").scrollTop()
                $(".container-pesan-error").show()
                $(".pesan-error").html(response.pesan).show()
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            }
          })
        })

        $('#btn-save-edit-kategori').click(function() { // Ketika tombol edit di klik
          if (data_bawaan != $("#modal-kategori form").serialize()) {
            $.ajax({
              url: base_url + 'KategoriProduk/edit/' + id, // URL tujuan
              type: 'POST', // Tentukan type nya POST atau GET
              data: $("#modal-kategori form").serialize(), // Ambil semua data yang ada didalam tag form
              dataType: 'json',
              beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                  e.overrideMimeType('application/jsoncharset=UTF-8')
                }
              },
              success: function(response) {
                if (response.status == 'sukses') { // Jika Statusnya = sukses
                  /*
                   * Ambil pesan suksesnya dan set ke div pesan-sukses
                   * Lalu munculkan div pesan-sukes nya
                   * Setelah 10 detik, sembunyikan kembali pesan suksesnya
                   */
                  $('#pesan-sukses').html(response.pesan).fadeIn().delay(3000).fadeOut()

                  $('#modal-kategori').hide() // Close / Tutup Modal Dialog
                  // Ganti isi dari div view dengan view yang diambil dari proses_simpan.php
                  $('#data-table-kategori').html(response.html)
                } else { // Jika statusnya = gagal
                  /*
                   * Ambil pesan errornya dan set ke div pesan-error
                   * Lalu munculkan div pesan-error nya
                   */
                  $('.container-pesan-error').show()
                  $('.pesan-error').html(response.pesan).show()
                }
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              }
            })
          } else {
            $('#pesan-sukses').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">Tidak ada perubahan data!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>').fadeIn().delay(3000).fadeOut()
            $('#modal-kategori').hide()
          }
          data_bawaan = null
        })

        $('#btn-delete-kategori').click(function() { // Ketika tombol hapus di klik
          $.confirm({
            title: 'Hapus Data Kategori Produk',
            content: '<p>Anda yakin ingin menghapus data kategori produk ini?</p><p>Pastikan kategori produk ini tidak dipakai di list produk yang ada sebelum dihapus!</p>',
            type: 'red',
            typeAnimated: true,
            buttons: {
              tryAgain: {
                text: 'DELETE',
                btnClass: 'btn-red',
                action: function() {
                  $.ajax({
                    url: base_url + 'KategoriProduk/delete/' + id, // URL tujuan
                    type: 'GET', // Tentukan type nya POST atau GET
                    dataType: 'json',
                    beforeSend: function(e) {
                      if (e && e.overrideMimeType) {
                        e.overrideMimeType('application/jsoncharset=UTF-8')
                      }
                    },
                    success: function(response) { // Ketika proses pengiriman berhasil
                      $('#modal-kategori').hide() // Close / Tutup Modal Dialog
                      // Ganti isi dari div view dengan view yang diambil dari proses_hapus.php
                      $('#data-table-kategori').html(response.html)
                      /*
                       * Ambil pesan suksesnya dan set ke div pesan-sukses
                       * Lalu munculkan div pesan-sukes nya
                       * Setelah 10 detik, sembunyikan kembali pesan suksesnya
                       */
                      $('#pesan-sukses').html(response.pesan).fadeIn().delay(3000).fadeOut()
                    },
                    error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                      console.log(xhr.responseText) // munculkan alert
                    }
                  })
                }
              },
              close: {
                text: 'CANCEL',
                action: function() {}
              }
            }
          })
        })
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Karyawan" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      var datenow = new Date();
      var roleid = 0;

      function goTop() {
        $("html, body").animate({
          scrollTop: 0
        }, "fast");
        return false;
      }
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        $.ajax({
          url: base_url + 'Karyawan/getRoleId', // URL tujuan
          type: 'GET', // Tentukan type nya POST atau GET
          dataType: 'json',
          success: function(response) { // Ketika proses pengiriman berhasil
            role = response.role;
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        })

        var id = "error"
        var mode = "else"
        var data_bawaan

        var input_jml_gaji = new AutoNumeric("#input_jml_gaji", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });

        $("#btn-close, #btn-cancel").click(function() {
          $("#modal-pengguna, #modal-kategori").hide()
          $(".container-pesan-error").hide()
        });

        $('[data-toggle="datepicker"]').datepicker({
          format: 'yyyy-mm-dd',
          startDate: datenow.getFullYear() + '/01/01',
          endDate: datenow.getFullYear() + '/12/31',
          autoHide: true,
          startView: 1
        });

        $('#input_nama').change(function() {
          x = $(this).val();
          caps = x.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
          });
          $(this).val(caps);
        });

        //peran admin
        $('#peran3').click(function() {
          $('#modal-pengguna-shift').hide()
          $('#modal-pengguna-toko').hide()
          $('#input_shift').prop('selectedIndex', 0)
          $('#input_toko').prop('selectedIndex', 0)
        });

        //peran karyawan
        $('#peran4').click(function() {
          $('#modal-pengguna-shift').show()
          $('#modal-pengguna-toko').show()
        });

        // ------------ PENGGUNA -------------------------
        //Ketika tombol tambah di klik
        $('#btn-tambah-pengguna').click(function() {
          $('#form-alamat').show()
          $('#modal-pengguna-toko').show()
          $('#modal-pengguna-peran').show()
          $('#modal-pengguna-gaji').show()
          $('#modal-pengguna-status').show()
          $('#modal-pengguna').show()
          $('.judul-modal-header').html("Tambah Karyawan Baru")
          $('.modal-form').trigger("reset")
          $('#change-password-form').hide()
          $('#password-form').show()
          $('#btn-save-pengguna').show()
          $('#btn-save-edit-pengguna').hide()
          $('#btn-delete-pengguna').hide()
          $('#input_username').attr('disabled', false)
          $('#input_toko').val("")
          $("#peran1").attr('checked', false)
          $("#peran2").attr('checked', false)
          $("#peran3").attr('checked', false)
          $("#peran4").attr('checked', false)
          $('#input_jml_gaji').attr('disabled', false)
          $('#input_tgl_gaji').attr('disabled', false)
          $('[data-toggle="datepicker"]').datepicker('reset');
          input_jml_gaji.set("");
          $('#input_jml_gaji').attr("placeholder", "Jumlah Gaji misal 1700000"); // Set value dari textbox nama yang ada di form
          $('#input_tgl_gaji').attr("placeholder", "Tanggal Gaji format YYYY/MM/DD") // Set value dari textbox nama yang ada di form
          $("#input_is_active").attr('checked', false)

          goTop();
        })

        //Jika tombol link user diklik maka muncul form edit
        $('#data-table-user').on('click', 'a', function(e) {
          e.preventDefault()
          $('#modal-pengguna').show()
          id = $(this).data('id')
          mode = "else"
          $('.modal-form').trigger("reset")
          $('#password-form').hide() // Sembunyikan form input password
          $('#change-password-form').show() // Munculkan form ganti password
          $('#btn-save-pengguna').hide() // Sembunyikan tombol simpan
          $('#btn-save-edit-pengguna').show() // Munculkan tombol ubah
          $('#btn-delete-pengguna').show()
          $('#input_username').attr('disabled', true) // Disable untuk edit username
          $("#peran1").attr('checked', false)
          $("#peran2").attr('checked', false)
          $("#peran3").attr('checked', false)
          $("#peran4").attr('checked', false)


          // Set judul modal dialog menjadi Form Ubah Data
          $('.judul-modal-header').html('Edit Data Karyawan')

          var tr = $(this).closest('tr') // Cari tag tr paling terdekat
          var nama = tr.find('.value-nama').val() // Ambil nis dari input type hidden
          var cp = tr.find('.value-cp').val() // Ambil nis dari input type hidden
          var username = tr.find('.value-username').val() // Ambil nis dari input type hidden
          var alamat = tr.find('.value-alamat').val() // Ambil nis dari input type hidden
          var toko = tr.find('.value-toko').val()
          var shift = tr.find('.value-shift').val()
          var peran = tr.find('.value-peran').val() // Ambil nis dari input type hidden
          var jml_gaji = tr.find('.value-jml-gaji').val()
          var tgl_gaji = tr.find('.value-tgl-gaji').val()
          var is_active = tr.find('.value-is-active').val() // Ambil nis dari input type hidden

          $('#input_nama').val(nama) // Set value dari textbox nis yang ada di form
          $('#input_cp').val(cp) // Set value dari textbox nama yang ada di form
          $('#input_username').val(username) // Set value dari textbox nama yang ada di form
          $('#input_alamat').val(alamat) // Set value dari textbox nama yang ada di form
          $('#input_toko').val(toko)
          $('#input_shift').val(shift)
          if (peran == 1 || peran == 2) {
            $('#form-alamat').hide()
            $('#modal-pengguna-toko').hide()
            $('#modal-pengguna-shift').hide()
            $('#modal-pengguna-peran').hide()
            $('#modal-pengguna-gaji').hide()
            $('#modal-pengguna-status').hide()
            if (peran == 1)
              $("#peran1").attr('checked', true);
            else if (peran == 2)
              $("#peran2").attr('checked', true);
          } else if (peran == 3) {
            $('#form-alamat').show()
            $('#modal-pengguna-toko').hide()
            $('#modal-pengguna-shift').hide()
            $('#modal-pengguna-peran').show()
            $('#modal-pengguna-gaji').show()
            $('#modal-pengguna-status').show()
            $("#peran3").attr('checked', true);
          } else if (peran == 4) {
            $('#form-alamat').show()
            $('#modal-pengguna-toko').show()
            $('#modal-pengguna-shift').show()
            $('#modal-pengguna-peran').show()
            $('#modal-pengguna-gaji').show()
            $('#modal-pengguna-status').show()
            $("#peran4").attr('checked', true);
          }

          input_jml_gaji.set(jml_gaji)
          tgl_spl = tgl_gaji.split("-");
          $('[data-toggle="datepicker"]').datepicker('setDate', new Date(tgl_spl[0], tgl_spl[1] - 1, tgl_spl[2]));

          // Is_active

          if (is_active == 1)
            $("#input_is_active").attr('checked', true)
          else
            $("#input_is_active").removeAttr('checked')

          data_bawaan = $("#modal-pengguna form").serialize()

          goTop();
        })

        // Ganti Password
        $('#change-password-form button').click(function() {
          mode = "withpass"
          $('#password-form').show()
          $('#change-password-form').hide()
          $('#input_password').attr("placeholder", "Masukkan Password Baru")
        })

        $('#tambahPengguna').click(function() { // Ketika tombol tambah diklik
          $('#btn-save-pengguna').show() // Sembunyikan tombol simpan
          $('#btn-save-edit-pengguna').hide() // Munculkan tombol ubah
        })

        $('#btn-save-pengguna').click(function() { // Ketika tombol simpan di klik
          input_jml_gaji.unformat();
          console.log($("#modal-pengguna form").serialize());
          $.ajax({
            url: base_url + 'Karyawan/simpan', // URL tujuan
            type: 'POST', // Tentukan type nya POST atau GET
            data: $("#modal-pengguna form").serialize(), // Ambil semua data yang ada didalam tag form
            dataType: 'json',
            beforeSend: function(e) {
              if (e && e.overrideMimeType) {
                e.overrideMimeType('application/jsoncharset=UTF-8')
              }
            },
            success: function(response) {
              if (response.status == 'sukses') { // Jika Statusnya = sukses
                /*
                 * Ambil pesan suksesnya dan set ke div pesan-sukses
                 * Lalu munculkan div pesan-sukes nya
                 * Setelah 10 detik, sembunyikan kembali pesan suksesnya
                 */
                $('#pesan-sukses').html(response.pesan).fadeIn().delay(3000).fadeOut()

                $('#modal-pengguna').hide() // Close / Tutup Modal Dialog
                // Ganti isi dari div view dengan view yang diambil dari proses_simpan.php
                $('#data-table-user').html(response.html)
                $('.container-pesan-error').hide()
              } else { // Jika statusnya = gagal
                /*
                 * Ambil pesan errornya dan set ke div pesan-error
                 * Lalu munculkan div pesan-error nya
                 */
                $('#modal-pengguna').scrollTop()
                $('.container-pesan-error').show()
                $('.pesan-error').html(response.pesan).show()
              }
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            }
          })
        })

        $('#btn-save-edit-pengguna').click(function() { // Ketika tombol edit di klik
          if (data_bawaan != $("#modal-pengguna form").serialize()) {
            input_jml_gaji.unformat();
            $.ajax({
              url: base_url + 'Karyawan/edit/' + id + '/' + mode, // URL tujuan
              type: 'POST', // Tentukan type nya POST atau GET
              data: $("#modal-pengguna form").serialize(), // Ambil semua data yang ada didalam tag form
              dataType: 'json',
              beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                  e.overrideMimeType('application/jsoncharset=UTF-8')
                }
              },
              success: function(response) {
                if (response.status == 'sukses') { // Jika Statusnya = sukses
                  /*
                   * Ambil pesan suksesnya dan set ke div pesan-sukses
                   * Lalu munculkan div pesan-sukes nya
                   * Setelah 10 detik, sembunyikan kembali pesan suksesnya
                   */
                  $('#pesan-sukses').html(response.pesan).fadeIn().delay(3000).fadeOut()

                  $('#modal-pengguna').hide() // Close / Tutup Modal Dialog
                  // Ganti isi dari div view dengan view yang diambil dari proses_simpan.php
                  $('#data-table-user').html(response.html)
                  $('.container-pesan-error').hide()
                } else { // Jika statusnya = gagal
                  /*
                   * Ambil pesan errornya dan set ke div pesan-error
                   * Lalu munculkan div pesan-error nya
                   */
                  $('.container-pesan-error').show()
                  $('.pesan-error').html(response.pesan).show()
                }
                console.log(response);
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              }
            })
          } else {
            $('#pesan-sukses').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">Tidak ada perubahan data!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>').fadeIn().delay(3000).fadeOut()
            $('#modal-pengguna').hide()
          }
          data_bawaan = null
        })

        $('#btn-delete-pengguna').click(function() { // Ketika tombol hapus di klik
          $.confirm({
            title: 'Hapus Data Karyawan',
            content: 'Anda yakin ingin menghapus data karyawan ini?',
            type: 'red',
            typeAnimated: true,
            buttons: {
              tryAgain: {
                text: 'DELETE',
                btnClass: 'btn-red',
                action: function() {
                  $.ajax({
                    url: base_url + 'Karyawan/delete/' + id, // URL tujuan
                    type: 'GET', // Tentukan type nya POST atau GET
                    dataType: 'json',
                    beforeSend: function(e) {
                      if (e && e.overrideMimeType) {
                        e.overrideMimeType('application/jsoncharset=UTF-8')
                      }
                    },
                    success: function(response) { // Ketika proses pengiriman berhasil
                      $('#modal-pengguna').hide() // Close / Tutup Modal Dialog
                      // Ganti isi dari div view dengan view yang diambil dari proses_hapus.php
                      $('#data-table-user').html(response.html)
                      /*
                       * Ambil pesan suksesnya dan set ke div pesan-sukses
                       * Lalu munculkan div pesan-sukes nya
                       * Setelah 10 detik, sembunyikan kembali pesan suksesnya
                       */
                      $('#pesan-sukses').html(response.pesan).fadeIn().delay(3000).fadeOut()
                    },
                    error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                      console.log(xhr.responseText) // munculkan alert
                    }
                  })
                }
              },
              close: {
                text: 'CANCEL',
                action: function() {}
              }
            }
          })
        })
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Inventory" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "index2" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        var table = $('#dataTable').DataTable({
          dom: 'Blfrtip',
          buttons: [
            'excel', 'pdf', 'print'
          ],
          "destroy": true,
          "processing": true,
          "serverSide": true,
          "ordering": true, // Set true agar bisa di sorting
          "order": [
            [1, 'asc']
          ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
          "ajax": {
            "url": base_url + 'Inventory/dataTables/1', // URL file untuk proses select datanya
            "type": "POST"
          },
          "deferRender": true,
          "aLengthMenu": [
            [25, 50, 100],
            [25, 50, 100]
          ], // Combobox Limit
          "columns": [{
              "data": null,
              "sortable": false,
              render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            {
              "data": "sku",
              render: function(data, type, row) {
                html = "<a href='";
                html += row.url;
                html += "'>";
                html += row.sku;
                html += '</a>';
                return html;
              }
            },
            {
              "data": "p_nama"
            },
            {
              "data": "tersedia"
            },
            {
              "data": "minimal"
            },
            {
              "data": "t_nama"
            }
          ],
        });

        $(".alert").fadeTo(2000, 500).slideUp(500, function() {
          $(".alert").slideUp(500);
        });
        $('#list-toko').change(function() {
          toko_id = $(this).val();
          judul = $(this).children("option:selected").attr('rel');
          $('#judul-toko-inventory').text(judul);
          $('#judul-list-inventory').text('List Inventory ' + judul);
          $('#btn-tambah-inventory').attr('href', base_url + 'Inventory/tambahInventory/' + toko_id)

          table.destroy();
          table = $('#dataTable').DataTable({
            dom: 'Blfrtip',
            buttons: [
              'excel', 'pdf', 'print'
            ],
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
              [1, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
              "url": base_url + 'Inventory/dataTables/' + toko_id, // URL file untuk proses select datanya
              "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [
              [25, 50, 100],
              [25, 50, 100]
            ], // Combobox Limit
            "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
                }
              },
              {
                "data": "sku",
                render: function(data, type, row) {
                  html = "<a href='";
                  html += row.url;
                  html += "'>";
                  html += row.sku;
                  html += '</a>';
                  return html;
                }
              },
              {
                "data": "p_nama"
              },
              {
                "data": "tersedia"
              },
              {
                "data": "minimal"
              },
              {
                "data": "t_nama"
              }
            ],
          });
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Inventory" && $this->uri->segment(2) == "tambahInventory") { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        var nama_toko = $('#judul-nama-toko').attr('rel');

        var input_tersedia = new AutoNumeric("#input_tersedia", {
          allowDecimalPadding: false
        });
        var input_minimal = new AutoNumeric("#input_minimal", {
          allowDecimalPadding: false
        });

        $('#input_tersedia').click(function() {
          is_gudang = $('#tersedia-gudang').attr('rel');
          if (is_gudang != 1) {
            if ($('#input_tersedia_gudang').val() == "") {
              $('#input_tersedia').blur();
              $.confirm({
                title: 'Error',
                content: 'Pilih produk yang ingin ditambahkan terlebih!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            } else {
              $('#input_tersedia').focus();
            }
          }
        });

        $('#input_tersedia').change(function() {
          is_gudang = $('#tersedia-gudang').attr('rel');
          if (is_gudang == 0) {
            if (input_tersedia.getNumber() > $('#input_tersedia_gudang').val()) {
              input_tersedia.set("");
              $.confirm({
                title: 'Error',
                content: 'Jumlah yang dimasukkan lebih besar dari jumlah ketersediaan di gudang!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            } else if (input_tersedia.getNumber() < 0) {
              input_tersedia.set("");
              $.confirm({
                title: 'Error',
                content: 'Jumlah yang dimasukkan tidak boleh kurang dari 0!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
          } else {
            if (input_tersedia.getNumber() < 0) {
              input_tersedia.set("");
              $.confirm({
                title: 'Error',
                content: 'Jumlah yang dimasukkan tidak boleh kurang dari 0!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
          }
        });

        $('#input_minimal').click(function() {
          if (input_tersedia.getNumber() == "") {
            $('#input_minimal').blur();
            $.confirm({
              title: 'Error',
              content: 'Masukkan field Jumlah Tersedia terlebih dahulu!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          } else {
            $('#input_minimal').focus();
          }
        });

        $('#input_minimal').change(function() {
          if (input_minimal.getNumber() > input_tersedia.getNumber()) {
            input_minimal.set("");
            $.confirm({
              title: 'Error',
              content: 'Limit minimal yang dimasukkan lebih besar dari Input Jumlah!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          }
        });

        $('#cari-barang').keyup(function() {
          if ($('#cari-barang').val() == "") {
            $("#cari-barang-table").hide();
          } else {
            $("#cari-barang-table").show();
          }

          var cari = $(this).val();
          var table = $('#dataTable').DataTable();
          table.search(cari).draw();
        });

        $('#pencarian-produk').on('click', 'a', function(e) {
          e.preventDefault();
          sku = $(this).attr('rel');
          tersedia = $(this).find('.jumlah-produk-tersedia').val();
          is_gudang = $('#tersedia-gudang').attr('rel');
          if (is_gudang == 0) {
            $('#input_tersedia_gudang').val(tersedia);
            $('#tersedia-gudang').html('<div class="mb-2">Jumlah Produk Ini Yang Tersedia Di Gudang :</div><div class="text-primary"><strong>' + tersedia + '</strong></div>');
          }
          $('#input_sku').val(sku);
          $("#cari-barang-table").hide();
          $('#cari-barang').val("");
        });

        $('#clear-search-bar').click(function() {
          $('#cari-barang').val("");
          $("#cari-barang-table").hide();
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Inventory" && $this->uri->segment(2) == "editInventory") { ?>
    <script type="text/javascript">
      var input_tersedia_bfr;
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);

        var input_tersedia = new AutoNumeric("#input_tersedia", {
          allowDecimalPadding: false
        });
        var input_minimal = new AutoNumeric("#input_minimal", {
          allowDecimalPadding: false
        });
        $('#input_tersedia').click(function() {
          input_tersedia_bfr = input_tersedia.getNumber();
        });
        $('#input_tersedia').change(function() {
          is_gudang = $('#tersedia-gudang').attr('rel');
          if (is_gudang == 0) {
            if (input_tersedia.getNumber() - input_tersedia_bfr > $('#input_tersedia_gudang').val()) {
              input_tersedia.set("");
              $.confirm({
                title: 'Error',
                content: 'Jumlah yang dimasukkan lebih besar dari jumlah ketersediaan di gudang!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            } else if (input_tersedia.getNumber() < 0) {
              input_tersedia.set("");
              $.confirm({
                title: 'Error',
                content: 'Jumlah yang dimasukkan tidak boleh kurang dari 0!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            } else {
              if (input_tersedia.getNumber() < 0) {
                input_tersedia.set("");
                $.confirm({
                  title: 'Error',
                  content: 'Jumlah yang dimasukkan tidak boleh kurang dari 0!',
                  type: 'red',
                  typeAnimated: true,
                  buttons: {
                    CLOSE: function() {}
                  }
                });
              }
            }
          }
        });
        $('#btn-delete-inventory').on('click', 'a', function(e) {
          e.preventDefault();
          url_ori = $(this).attr('href');
          param = $(this).attr('rel');
          $.ajax({
            type: "GET",
            url: base_url + 'Inventory/cekDelete/' + param,
            dataType: 'JSON',
            success: function(response) {
              if (response.status == 'danger') {
                $.confirm({
                  title: 'Error',
                  content: 'Produk dengan SKU ini masih terdaftar dengan toko lainnya! Pastikan untuk menghapus produk dengan SKU ini di semua inventory toko! List toko yang menggunakan SKU ini : <br><br>' + response.html,
                  type: 'red',
                  typeAnimated: true,
                  buttons: {
                    CLOSE: function() {}
                  }
                });
              } else {
                window.location.replace(url_ori);
              }
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            }
          });
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Customer" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
        var table = $('#dataTable').DataTable({
          dom: 'Blfrtip',
          buttons: [{
            extend: 'excel',
            exportOptions: {
              columns: ':visible'
            }
          }, {
            extend: 'pdf',
            exportOptions: {
              columns: ':visible'
            }
          }, {
            extend: 'print',
            exportOptions: {
              columns: ':visible'
            }
          }],
          "destroy": true,
          "processing": true,
          "serverSide": true,
          "ordering": true, // Set true agar bisa di sorting
          "order": [
            [1, 'desc']
          ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
          "ajax": {
            "url": base_url + 'Customer/dataTables/all/all', // URL file untuk proses select datanya
            "type": "POST",
            "data": {
              "tgl_start": 'all',
              "tgl_end": 'all'
            }
          },
          "deferRender": true,
          "aLengthMenu": [
            [5, 50, 100],
            [5, 50, 100]
          ], // Combobox Limit
          "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
          }],
          "columns": [{
              "data": null,
              "sortable": false,
              render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            {
              "data": "time"
            },
            {
              "data": "t_nama"
            },
            {
              "data": "nama"
            },
            {
              "data": "email"
            },
            {
              "data": "cp"
            }
          ],
        });

        $('.select-to-view').click(function() {
          toko_id = $(this).val()
          $('#toko-active').val(toko_id)
          $.ajax({
            type: "GET",
            url: base_url + 'Customer/getViewTable/' + toko_id + '/all',
            success: function(response) {
              $('#view-table-customer').html(response)
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
          });
        });
        $('#list-toko').change(function() {
          toko_id = $(this).val();
          nama_toko = $(this).attr('rel');

          table.destroy();
          table = $('#dataTable').DataTable({
            dom: 'Blfrtip',
            buttons: [{
              extend: 'excel',
              exportOptions: {
                columns: ':visible'
              }
            }, {
              extend: 'pdf',
              exportOptions: {
                columns: ':visible'
              }
            }, {
              extend: 'print',
              exportOptions: {
                columns: ':visible'
              }
            }],
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
              [1, 'desc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
              "url": base_url + 'Customer/dataTables/' + toko_id + '/all', // URL file untuk proses select datanya
              "type": "POST",
              "data": {
                "tgl_start": 'all',
                "tgl_end": 'all'
              }
            },
            "deferRender": true,
            "aLengthMenu": [
              [25, 50, 100],
              [25, 50, 100]
            ], // Combobox Limit
            "columnDefs": [{
              "searchable": false,
              "orderable": false,
              "targets": 0
            }],
            "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
                }
              },
              {
                "data": "time"
              },
              {
                "data": "t_nama"
              },
              {
                "data": "nama"
              },
              {
                "data": "email"
              },
              {
                "data": "cp"
              }
            ],
          });
        });
        $('#list-view').change(function() {
          toko_id = $('#list-toko').val();
          view_mode = $(this).val();

          table.destroy();
          table = $('#dataTable').DataTable({
            dom: 'Blfrtip',
            buttons: [{
              extend: 'excel',
              exportOptions: {
                columns: ':visible'
              }
            }, {
              extend: 'pdf',
              exportOptions: {
                columns: ':visible'
              }
            }, {
              extend: 'print',
              exportOptions: {
                columns: ':visible'
              }
            }],
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
              [1, 'desc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
              "url": base_url + 'Customer/dataTables/' + toko_id + '/' + view_mode, // URL file untuk proses select datanya
              "type": "POST",
              "data": {
                "tgl_start": 'all',
                "tgl_end": 'all'
              }
            },
            "deferRender": true,
            "aLengthMenu": [
              [25, 50, 100],
              [25, 50, 100]
            ], // Combobox Limit
            "columnDefs": [{
              "searchable": false,
              "orderable": false,
              "targets": 0
            }],
            "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
                }
              },
              {
                "data": "time"
              },
              {
                "data": "t_nama"
              },
              {
                "data": "nama"
              },
              {
                "data": "email"
              },
              {
                "data": "cp"
              }
            ],
          });
          table.column(4).visible(false);
          table.column(5).visible(false);

          if (view_mode == 'all') {
            table.column(4).visible(true);
            table.column(5).visible(true);
          } else if (view_mode == 'email') {
            table.column(4).visible(true);
            table.column(5).visible(false);
          } else {
            table.column(4).visible(false);
            table.column(5).visible(true);
          }
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Operasional" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Operasional" && $this->uri->segment(2) == "view") { ?>
    <script type="text/javascript">
      function goTop() {
        $("html, body").animate({
          scrollTop: 0
        }, "slow");
        return false;
      }
      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
        var input_biaya = new AutoNumeric("#input_biaya", {
          currencySymbol: "Rp ",
          decimalCharacter: ",",
          digitGroupSeparator: ".",
          allowDecimalPadding: false
        });

        $('#dataTable').DataTable();
        $('#btn-cancel, #btn-close').click(function() {
          $('.judul-modal-header').text('Tambah Biaya Operasional');
          $('#btn-delete-operasional').hide();
          $('#btn-save-edit-operasional').hide();
          $('#btn-save-operasional').hide();
          $('#btn-cancel').hide();

          $('#modal-operasional').hide()
        })
        $('#btn-tambah-operasional').click(function() {
          $('#container-wait').show();
          $('#id-operasional').val('');
          $('#input_keperluan').val('');
          input_biaya.set('');
          $('#pilih_uang').val('Pribadi');

          $('.judul-modal-header').text('Tambah Biaya Operasional');
          $('#btn-delete-operasional').hide();
          $('#btn-save-edit-operasional').hide();
          $('#btn-save-operasional').show();
          $('#btn-cancel').show();

          $('#modal-operasional').show()
          goTop();
          $('#container-wait').hide();
        })
        $("#btn-save-operasional").click(function() {
          toko_id = $('#toko-active').val();
          keperluan = $('#input_keperluan').val();
          biaya = input_biaya.getNumber();
          jenis_uang = $('#pilih_uang').val();

          cek_keperluan = /\S/.test(keperluan)
          cek_biaya = /[0-9]/.test(biaya)
          cek_jenis_uang = /\S/.test(jenis_uang)

          if (cek_keperluan && cek_jenis_uang && cek_biaya && biaya > 0) {
            $.ajax({
              url: base_url + "Operasional/save", // URL tujuan
              type: "POST", // Tentukan type nya POST atau GET
              data: 'toko_id=' + toko_id + '&keperluan=' + keperluan + '&biaya=' + biaya + '&jenis_uang=' + jenis_uang,
              dataType: 'JSON',
              success: function(response) {
                if (response.status == "sukses") {
                  $("#pesan-sukses").html(response.pesan)
                  $('.isi-pesan-sukses').fadeIn().delay(3000).fadeOut()
                  $("#modal-operasional").hide() // Close / Tutup Modal Dialog
                } else {
                  // Jika statusnya = gagal
                  $("#modal-operasional").hide()
                  $(".pesan-error").html(response.pesan).show()
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              },
              complete: function() {
                $.ajax({
                  type: "GET",
                  url: base_url + 'Operasional/getViewTable/' + toko_id,
                  success: function(response) {
                    $('#view-table-operasional').html(response);
                  },
                  error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                    console.log(xhr.responseText) // munculkan alert
                  },
                });
              }
            })
          } else {
            if (!cek_keperluan) {
              $('#error_keperluan').show()
            } else {
              $('#error_keperluan').hide()
            }

            if (biaya <= 0) {
              $('#error_input_biaya').show()
            } else {
              $('#error_input_biaya').hide()
            }

            if (!cek_jenis_uang) {
              $('#error_jenis_uang').show()
            } else {
              $('#error_jenis_uang').hide()
            }
          }
        })
        $('#view-table-operasional').on('click', 'a', function(e) {
          e.preventDefault();
          id = $(this).attr('rel');
          $('#container-wait').show();
          $.ajax({
            type: "GET",
            url: base_url + 'Operasional/getDataOperasional/' + id,
            dataType: 'JSON',
            success: function(response) {
              $('#id-operasional').val(response.id);
              $('#input_keperluan').val(response.keperluan);
              input_biaya.set(response.biaya)
              if (response.jenis_uang == 'Pribadi') {
                $('#uang_pribadi').prop('checked', true);
                $('#uang_toko').prop('checked', false);
                $('#pilih_uang').val('Pribadi');
              } else {
                $('#uang_toko').prop('checked', true);
                $('#uang_pribadi').prop('checked', false);
                $('#pilih_uang').val('Toko');
              }

              $('.judul-modal-header').text('Tambah Biaya Operasional');
              $('#btn-delete-operasional').show();
              $('#btn-save-edit-operasional').show();
              $('#btn-save-operasional').hide();
              $('#btn-cancel').show();

              $('#modal-operasional').show();
              goTop();
            },
            error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $('#container-wait').hide();
            }
          });
        })
        $("#btn-save-edit-operasional").click(function() {
          toko_id = $('#toko-active').val();
          id = $('#id-operasional').val();
          keperluan = $('#input_keperluan').val();
          biaya = input_biaya.getNumber();
          jenis_uang = $('#pilih_uang').val();

          cek_keperluan = /\S/.test(keperluan)
          cek_biaya = /[0-9]/.test(biaya)
          cek_jenis_uang = /\S/.test(jenis_uang)

          if (cek_keperluan && cek_jenis_uang && cek_biaya && biaya > 0) {
            $.ajax({
              url: base_url + "Operasional/update", // URL tujuan
              type: "POST", // Tentukan type nya POST atau GET
              data: 'id=' + id + '&keperluan=' + keperluan + '&biaya=' + biaya + '&jenis_uang=' + jenis_uang,
              dataType: 'JSON',
              success: function(response) {
                if (response.status == "sukses") {
                  $("#pesan-sukses").html(response.pesan)
                  $('.isi-pesan-sukses').fadeIn().delay(3000).fadeOut()
                  $("#modal-operasional").hide() // Close / Tutup Modal Dialog
                } else {
                  // Jika statusnya = gagal
                  $("#modal-operasional").hide()
                  $(".pesan-error").html(response.pesan).show()
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              },
              complete: function() {
                $.ajax({
                  type: "GET",
                  url: base_url + 'Operasional/getViewTable/' + toko_id,
                  success: function(response) {
                    $('#view-table-operasional').html(response);
                  },
                  error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                    console.log(xhr.responseText) // munculkan alert
                  },
                });
              }
            })
          } else {
            if (!cek_keperluan) {
              $('#error_keperluan').show()
            } else {
              $('#error_keperluan').hide()
            }

            if (biaya <= 0) {
              $('#error_input_biaya').show()
            } else {
              $('#error_input_biaya').hide()
            }

            if (!cek_jenis_uang) {
              $('#error_jenis_uang').show()
            } else {
              $('#error_jenis_uang').hide()
            }
          }
        })
        $("#btn-delete-operasional").click(function() {
          toko_id = $('#toko-active').val();
          id = $('#id-operasional').val();

          $.ajax({
            url: base_url + "Operasional/delete/" + id, // URL tujuan
            type: "GET", // Tentukan type nya POST atau GET
            dataType: 'JSON',
            success: function(response) {
              $("#pesan-sukses").html(response.pesan)
              $('.isi-pesan-sukses').fadeIn().delay(3000).fadeOut()
              $("#modal-operasional").hide()
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // Ketika terjadi error
              console.log(xhr.responseText) // munculkan alert
            },
            complete: function() {
              $.ajax({
                type: "GET",
                url: base_url + 'Operasional/getViewTable/' + toko_id,
                success: function(response) {
                  $('#view-table-operasional').html(response);
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                  console.log(xhr.responseText) // munculkan alert
                },
              });
            }
          });
        });
        $('#pilih_uang').change(function(e) {
          if ($(this).val() == 'Toko') {
            $(this).val('Pribadi');
            $.confirm({
              title: 'Belum Selesai',
              content: 'Fitur ini masih dalam proses pengerjaan',
              type: 'red',
              typeAnimated: true,
              buttons: {
                CLOSE: function() {}
              }
            });
          }
        });
      });
    </script>
  <?php } ?>

  <?php if ($this->uri->segment(1) == "Absen" && ($this->uri->segment(2) == "index" || $this->uri->segment(2) == "")) { ?>
    <script type="text/javascript">
      var table;

      function changeDisplayJudul(range) {
        $('#show-range').html(range);
      }

      $(document).ready(function() {
        $(document).on('click', '.load-link', function() {
          $('#container-wait').show();
        });
        $('#container-wait').hide();
        setTimeout(function() {
          $("body").toggleClass("sidebar-toggled");
          $(".sidebar").toggleClass("toggled");
        }, 2000);
        $.ajax({
          type: 'GET',
          url: base_url + 'Absen/getFirstAndLastRecordDate',
          dataType: 'JSON',
          success: function(response) {
            $('[data-toggle="datepicker"]').datepicker({
              format: 'yyyy-mm-dd',
              startDate: response.start,
              endDate: response.end,
              autoHide: true,
              startView: 1
            });
          },
          error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
            console.log(xhr.responseText) // munculkan alert
          }
        });
        $('#btn-custom-reset').click(function() {
          $('[data-toggle="datepicker"]').datepicker('reset');
          changeDisplayJudul(' ');
          if ($.fn.dataTable.isDataTable("#dataTable")) {
            table.destroy();
            $('#table-absensi').html(' ');
          }
        });
        $('#btn-custom-range').click(function() {
          start = $('#input_start_date').val();
          end = $('#input_end_date').val();

          if (!start || !end) {
            if (!end) {
              $.confirm({
                title: 'Error!',
                content: 'Tanggal akhir belum diisi!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
            if (!start) {
              $.confirm({
                title: 'Error!',
                content: 'Tanggal mulai belum diisi!',
                type: 'red',
                typeAnimated: true,
                buttons: {
                  CLOSE: function() {}
                }
              });
            }
          } else {
            $.ajax({
              type: 'POST',
              url: base_url + 'Absen/getViewtableAbsen',
              data: {
                'start': start,
                'end': end
              },
              dataType: 'JSON',
              success: function(response) {
                $('#table-absensi').html(response.html);
                if ($.fn.dataTable.isDataTable("#dataTable")) {
                  table.destroy();
                }
                changeDisplayJudul(response.range);
                table = $('#dataTable').DataTable({
                  "order": [
                    [0, "asc"]
                  ]
                });
              },
              error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
                console.log(xhr.responseText) // munculkan alert
              },
              complete: function() {
                $('#container-wait').hide();
              }
            });
          }
        });
      });
    </script>
  <?php } ?>

  </body>

  </html>