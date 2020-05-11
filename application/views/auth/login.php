<!DOCTYPE html>
<html lang="en">

<head>
  <title>Pantjasoerja POS</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?= base_url('assets/css/'); ?>custom.css">

  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="<?= base_url('vendor/login/'); ?>images/icons/favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>vendor/animsition/css/animsition.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>vendor/daterangepicker/daterangepicker.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>css/util.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/login/'); ?>css/main.css">
  <!--===============================================================================================-->
</head>

<body>
  <div id="container-wait">
    <div class="wait">
      <div><img src="<?= base_url('assets/img/'); ?>loading.svg"></div>
      <div class="mt-3">Loading</div>
    </div>
  </div>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
        <form class="login100-form validate-form" method="post" action="<?= base_url('index.php/auth'); ?>">
          <span class="login100-form-title p-b-33">
            Login
          </span>

          <?= $this->session->flashdata('message'); ?>

          <div class="wrap-input100 validate-input" data-validate="Username is required">
            <input class="input100" type="text" name="username" placeholder="Username">
            <span class="focus-input100-1"></span>
            <span class="focus-input100-2"></span>
          </div>

          <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100-1"></span>
            <span class="focus-input100-2"></span>
          </div>

          <div class="container-login100-form-btn m-t-20">
            <button type="submit" class="load-link login100-form-btn">
              Sign in
            </button>
          </div>

          <div class="text-center p-t-45 p-b-4">
            <span class="txt1">
              Forgot
            </span>

            <a href="#" class="txt2 hov1">
              Username / Password?
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!--===============================================================================================-->
  <script src="<?= base_url('vendor/login/'); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?= base_url('vendor/login/'); ?>vendor/animsition/js/animsition.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?= base_url('vendor/login/'); ?>vendor/bootstrap/js/popper.js"></script>
  <script src="<?= base_url('vendor/login/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?= base_url('vendor/login/'); ?>vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?= base_url('vendor/login/'); ?>vendor/daterangepicker/moment.min.js"></script>
  <script src="<?= base_url('vendor/login/'); ?>vendor/daterangepicker/daterangepicker.js"></script>
  <!--===============================================================================================-->
  <script src="<?= base_url('vendor/login/'); ?>vendor/countdowntime/countdowntime.js"></script>
  <!--===============================================================================================-->
  <script src="<?= base_url('vendor/login/'); ?>js/main.js"></script>

  <script>
    $(document).ready(function() {
      $('#container-wait').hide();
      $(document).on('click', '.load-link', function() {
        $('#container-wait').show();
      });
    });
  </script>

</body>

</html>