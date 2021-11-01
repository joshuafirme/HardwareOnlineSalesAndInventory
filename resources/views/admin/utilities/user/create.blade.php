@extends('admin.utilities.user.layout')

@section('content')

@php
    $page_title = "VCS | Create User";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Create User</h3>
        <hr>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
    </div>

        @if(count($errors)>0)
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
            
                        <li>{{$error}}</li>
                            
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    
        @if(\Session::has('success'))
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> </h5>
                {{ \Session::get('success') }}
            </div>
        </div>
        </div>

       
        @endif


        <div class="row">

          <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name"  id="name" required>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Email</label>
                                <input type="email" class="form-control" name="email"  id="email" required>
                            </div>
                
                              <div class="col-sm-12 col-md-6 mb-2">    
                                <label class="col-form-label">Access Level</label>
                                <select class="form-control" name="access_level" id="access_level">
                                    <option value="1">Sales Clerk</option>
                                    <option value="2">Inventory Clerk</option>
                                    <option value="3">Owner</option>
                                    <option value="4">Administrator</option>
                                    <option value="5">Customer</option>
                                </select>
                              </div>
                
                
                              <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                              </div>
                
                              <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                              </div>
    
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save</button>
                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</a>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection