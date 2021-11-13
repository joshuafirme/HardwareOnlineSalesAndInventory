
@php
  $page_title =  "Val Construction Supply | Login";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <style>
.border-md {
    border-width: 2px !important;
}

.btn-facebook {
    background: #405D9D;
    border: none;
}

.btn-facebook:hover, .btn-facebook:focus {
    background: #314879;
}

.btn-twitter {
    background: #42AEEC;
    border: none;
}

.btn-twitter:hover, .btn-twitter:focus {
    background: #1799e4;
}

body {
    min-height: 100vh;
}

.form-control:not(select) {
    padding: 1.5rem 0.5rem;
}

select.form-control {
    height: 52px;
    padding-left: 0.5rem;
}

.form-control::placeholder {
    color: #ccc;
    font-weight: bold;
    font-size: 0.9rem;
}
.form-control:focus {
    box-shadow: none;
}
  </style>

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
          <div class="login-card">
            <div class="row no-gutters">
              <div class="col-md-5 mt-4">
                <img src="{{asset('images/undraw_under_construction_-46-pa.svg')}}" class="img-fluid" alt="login">
              </div>
              <div class="col-md-7">
                <div class="card-body">
                 <!-- <div class="brand-wrapper">
                     <img src="" alt="logo" class="logo">
                  </div> -->

                  @include('includes.alerts')

                  <p class="login-card-description">Sign into your account</p>
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row">
      
                        <!-- First Name -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="username" type="text" name="username" placeholder="Username" class="form-control bg-white border-left-0 border-md" required>
                        </div>
      
                        <!-- Password -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md" required  autocomplete="off">
                        </div>
      
                        <!-- Submit Button -->
                        <div class="form-group col-lg-12 mx-auto mb-0">
                            <button type="submit" class="btn btn-primary btn-block py-2">
                                <span class="font-weight-bold">Login</span>
                            </button>
                        </div>
                    </div>
                </form>
                
                    <a href="#!" class="forgot-password-link">Forgot password?</a>
                    <p class="text-muted font-weight-bold">Don't have an account? <a href="{{ url('/signup') }}" class="text-primary ml-2">Register here</a></p>
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

