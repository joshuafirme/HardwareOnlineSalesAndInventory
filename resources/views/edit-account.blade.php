
@php
$page_title =  "Val Construction Supply | Cart";
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

<style>
    .fa {
        color: #06513D;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <main class="d-flex align-items-center py-3 py-md-0">
      <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                    <a href="{{ route('account.index') }}"><i class="fa fa-arrow-left"></i></a>
                    <h3 class="mt-2">Edit Account</h3>
                    <form action="{{ route('account.update',$user->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Name</label><br>
                                <input name="name" class="form-control" value="{{ $user->name }}">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Username</label><br>
                                <input name="username" class="form-control" value="{{ $user->username }}">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Email</label><br>
                                <input name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Contact Number</label><br>
                                <input name="phone" class="form-control" value="{{ $user->phone }}">
                            </div>
                            <div class="col-sm-12 col-md-6 new-password-container d-none">
                                <label class="col-form-label">New password</label>
                                <input type="password" class="form-control" name="password" id="password">
                              </div>
    
                              <div class="col-sm-12 mt-2 new-password-container d-none">
                                <a class="btn btn-sm btn-default" id="cancel">Cancel</a>
                              </div>
                              
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-success mr-2" id="btn-add-user">Save changes</button>
                                <a class="btn btn-sm btn-primary" id="btn-change-password">Change password</a>
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
<script src="{{asset('js/user.js')}}"></script>

