
@php
$page_title =  "Val Construction Supply | Sign up";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->


  <style>
    /*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/

.registration-container {
  background-color: #FFF;
  padding: 25px;
}

.border-md {
    border-width: 2px;
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
          <!-- Navbar
<header class="header">
  <nav class="navbar navbar-expand-lg navbar-light py-3">
      <div class="container">
          <a href="#" class="navbar-brand">
              <img src="https://bootstrapious.com/i/snippets/sn-registeration/logo.svg" alt="logo" width="150">
          </a>
      </div>
  </nav>
</header>-->


<div class="container registration-container">
  <div class="row py-5 align-items-center">
      <!-- For Demo Purpose -->
      <div class="col-md-5 pr-lg-5 mb-5 mb-md-0 ml-sm-0 ml-lg-5">
          <img src="{{asset('images/undraw_under_construction_-46-pa.svg')}}" alt="" class="img-fluid mb-3 d-none d-md-block">
      </div>

      <!-- Registeration Form -->
      <div class="col-md-7 col-lg-6 ml-auto">
          
        @include('includes.alerts')
        <p class="login-card-description">Create your account</p>
          <form action="{{ route('createAccount') }}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="row">

                  <!-- First Name -->
                  <div class="input-group col-lg-6 mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                              <i class="fa fa-user text-muted"></i>
                          </span>
                      </div>
                      <input id="firstName" type="text" name="firstname" placeholder="First Name" class="form-control bg-white border-left-0 border-md" required>
                  </div>

                  <!-- Last Name -->
                  <div class="input-group col-lg-6 mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                              <i class="fa fa-user text-muted"></i>
                          </span>
                      </div>
                      <input id="lastName" type="text" name="lastname" placeholder="Last Name" class="form-control bg-white border-left-0 border-md" required>
                  </div>

                    <!-- User Name -->
                    <div class="input-group col-lg-12 mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                              <i class="fa fa-user text-muted"></i>
                          </span>
                      </div>
                      <input id="username" type="text" name="username" placeholder="Username" class="form-control bg-white border-left-0 border-md" required>
                  </div>

                  <!-- Email Address -->
                  <div class="input-group col-lg-12 mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                              <i class="fa fa-envelope text-muted"></i>
                          </span>
                      </div>
                      <input id="email" type="email" name="email" placeholder="Email Address" class="form-control bg-white border-left-0 border-md" required>
                  </div>

                  <!-- Phone Number -->
                  <div class="input-group col-lg-12 mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                              <i class="fa fa-phone-square text-muted"></i>
                          </span>
                      </div>
                      <input id="phoneNumber" type="tel" name="phone" placeholder="Phone Number" class="form-control bg-white border-md border-left-0 pl-3" required>
                  </div>


                  <!-- Job 
                  <div class="input-group col-lg-12 mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                              <i class="fa fa-black-tie text-muted"></i>
                          </span>
                      </div>
                      <select id="job" name="jobtitle" class="form-control custom-select bg-white border-left-0 border-md">
                          <option value="">Choose your job</option>
                          <option value="">Designer</option>
                          <option value="">Developer</option>
                          <option value="">Manager</option>
                          <option value="">Accountant</option>
                      </select>
                  </div>-->

                  <!-- Password -->
                  <div class="input-group col-lg-6 mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                              <i class="fa fa-lock text-muted"></i>
                          </span>
                      </div>
                      <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md" autocomplete="new-password">
                  </div>

                  <!-- Password Confirmation -->
                  <div class="input-group col-lg-6 mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                              <i class="fa fa-lock text-muted"></i>
                          </span>
                      </div>
                      <input id="passwordConfirmation" type="password" name="passwordConfirmation" placeholder="Confirm Password" class="form-control bg-white border-left-0 border-md">
                  </div>

                     <!-- Password Confirmation -->
                  <div class="input-group col-lg-12 mb-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white px-4 border-md border-right-0">
                          <i class="fa fa-image text-muted"></i>
                        </span>
                      </div>
                        <div class="custom-file"> 
                          <input type="file" class="custom-file-input" name="identification_photo" id="identification_photo" required
                            aria-describedby="inputGroupFileAddon01">
                          <label class="custom-file-label" for="user-identification-photo">Upload your 1 valid ID for verification</label>
                        </div>
                      </div>
                

                    <!-- Submit Button -->
                    <div class="form-group col-lg-12 mx-auto mb-0">
                      <button type="submit" class="btn btn-primary btn-block py-2">
                          <span class="font-weight-bold">Create your account</span>
                      </button>
                    </div>
                  </div>

                  <!-- Divider Text 
                  <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                      <div class="border-bottom w-100 ml-5"></div>
                      <span class="px-2 small text-muted font-weight-bold text-muted">OR</span>
                      <div class="border-bottom w-100 mr-5"></div>
                  </div>

                   Social Login
                  <div class="form-group col-lg-12 mx-auto">
                      <a href="#" class="btn btn-primary btn-block py-2 btn-facebook">
                          <i class="fa fa-facebook-f mr-2"></i>
                          <span class="font-weight-bold">Continue with Facebook</span>
                      </a>
                      <a href="#" class="btn btn-primary btn-block py-2 btn-twitter">
                          <i class="fa fa-twitter mr-2"></i>
                          <span class="font-weight-bold">Continue with Twitter</span>
                      </a>
                  </div>-->

                  <!-- Already Registered -->
                  <div class="text-center w-100 mt-3">
                      <p class="text-muted font-weight-bold">Already Registered? <a href="{{ url('/login') }}" class="text-primary ml-2">Login</a></p>
                  </div>

              </div>
          </form>
      </div>
  </div>
</div>

        </div>
      </main>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@include('footer')


<script>
  // For Demo Purpose [Changing input group text on focus]
$(function () {
  $('input, select').on('focus', function () {
      $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
  });
  $('input, select').on('blur', function () {
      $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
  });

  

$('#passwordConfirmation').on('blur', function () { console.log('test')
  var password = $('#password').val();
  var confirm_password = $(this).val();
  if(confirm_password.replace(/ /g,'').length >= 6){
            if(password == confirm_password){
                return true;
            }
            else{
                alert('Password do not match!');
            }
        }
        else{
            alert('Minimum of 6 characters!')
        }
    
  });
});

</script>