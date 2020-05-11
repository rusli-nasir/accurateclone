<div class="row mb-5 d-flex justify-content-center">

  <div class="col-12 col-lg-7">
    <div class="card">
      <div class="card-header">
        Range Tanggal
      </div>
      <div class="card-body">
        <div class="mb-4 text-center">
          Data absensi yang ter-rekam berada pada rentang waktu : <br><strong><?= date('j F Y', $first_date_of_record); ?> s/d <?= date('j F Y', $last_date_of_record); ?></strong>
        </div>
        <div class="form-group">
          <label for="input_date">Input Range Tanggal</label>
          <div id="input_date">
            <div class="row">
              <div class="col-12 col-lg-6 mb-3">
                <div class="input-group">
                  <input type="text" id="input_start_date" class="form-control" placeholder="Tanggal Mulai" aria-describedby="basic-addon1" data-toggle="datepicker" readonly="readonly" style="background-color:white">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-6 mb-3">
                <div class="input-group">
                  <input type="text" id="input_end_date" class="form-control" placeholder="Tanggal Akhir" aria-describedby="basic-addon2" data-toggle="datepicker" readonly="readonly" style="background-color:white">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-calendar-alt"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <button type="button" class="btn btn-primary mr-4" id="btn-custom-reset">
              <span class="text">Reset</span>
            </button>
            <button type="button" class="btn btn-primary" id="btn-custom-range">
              <span class="text">Tampilkan</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="ml-md-3 text-gray-800 text-center">
  <h1 id="show-range" class="h5"></h1>
</div>

<div id="table-absensi">

</div>