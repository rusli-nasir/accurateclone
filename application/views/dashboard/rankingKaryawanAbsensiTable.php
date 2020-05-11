<div class="container-table100">
  <div class="wrap-table100">
    <div class="table100">
      <table class="custom-table table-ranking" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th style="white-space: nowrap">#Rank</th>
            <th>Username</th>
            <th>Total Menit Kerja</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($data !== null) {
            $i = 1;
            foreach ($data as $x) {
          ?>
              <tr>
                <td><?= $i; ?></td>
                <td><?= $x['uname']; ?></td>
                <td><?= $x['total']; ?></td>
              </tr>
          <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>