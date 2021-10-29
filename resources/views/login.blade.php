@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div ></div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <main class="d-flex align-items-center py-3 py-md-0">
        <div class="container">
          <div class="card login-card">
            <div class="row no-gutters">
              <div class="col-md-5 mt-4">
                <img src="{{asset('images/undraw_access_account_re_8spm.svg')}}" class="img-fluid" alt="login">
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <div class="brand-wrapper">
                  <!--   <img src="" alt="logo" class="logo"> -->
                  </div>
                  <p class="login-card-description">Sign into your account</p>
                  <form action="#!">
                      <div class="form-group">
                        <label for="username" class="sr-only">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                      </div>
                      <div class="form-group mb-4">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                      </div>
                      <input name="login" id="login" class="btn btn-block login-btn mb-4" type="button" value="Login">
                    </form>
                    <a href="#!" class="forgot-password-link">Forgot password?</a>
                    <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
                    <nav class="login-card-footer-nav">
                      <a href="#!">Terms of use.</a>
                      <a href="#!">Privacy policy</a>
                    </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@include('footer')