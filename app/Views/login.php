<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>App Gudang | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <link rel="stylesheet" href="<?=base_url('plugins/fontawesome-free/css/all.min.css')?>" />
    <link rel="stylesheet" href="<?=base_url('dist/css/adminlte.min.css')?>" />
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="javascript:void(0);" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          <div id="error"></div>
          <form onsubmit="doLogin(); return false;">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="username" placeholder="Username" />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                id="password"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember" />
                  <label for="remember"> Remember Me </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">
                  Sign In
                </button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <!-- <div class="social-auth-links text-center mt-3 mb-3">
            <a href="#" class="btn btn-block btn-success">
                <i class="fas fa-door-open mr-2"></i> Portal Barang
            </a>
          </div> -->

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?=base_url('plugins/jquery/jquery.min.js')?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?=base_url('plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <!-- AdminLTE App -->
    <script src="<?=base_url('dist/js/adminlte.min.js')?>"></script>

    <script>
      const base_url = "<?= base_url() ?>";
      const doLogin = (e) => {
        let username = $('#username').val();
        let password = $('#password').val();
        $.ajax({
          method: "POST",
          url: `${base_url}/auth/login`,
          data: {username, password},
          success: () => {
            window.location.href = base_url;
          },
          error: (res) => {
            $('#error').html(`<div class="alert alert-warning" role="alert">${res.responseText || "Kesalahan pada server"}</div>`);
            setTimeout(() => $('#error').fadeOut(),  5000);
          }
        });
        return false;

      }
    </script>
  </body>
</html>