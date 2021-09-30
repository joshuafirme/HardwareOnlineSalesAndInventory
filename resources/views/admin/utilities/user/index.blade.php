@extends('admin.utilities.user.layout')

@section('content')

@php
    $page_title = "VCS | User Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">User Maintenance</h3>
          <hr>
      </div>

        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif
    
        @if(\Session::has('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> </h5>
          {{ \Session::get('success') }}
        </div>

       
        @endif

        

        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create User</a>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-user" id="unit-table">
                        <tr>
                            <th class="py-2 text-left">Name</th>
                            <th class="py-2 text-left">Email</th>
                            <th class="py-2 text-left">Access Level</th>
                            <th class="py-2 text-left">Action</th>
                        </tr>
                        @foreach ($user as $users)
                        <tr>
                            <td>{{ $users->name }}</td>
                            <td>{{ $users->email }}</td>
                            
                            @php
                            $access_level = "";
                                switch($users->access_level) {
                                    case 1:
                                        $access_level = "Sales Clerk";
                                        break;
                                    case 2:
                                        $access_level = "Inventory Clerk";
                                        break;
                                    case 3:
                                        $access_level = "Owner";
                                        break;
                                    case 4:
                                        $access_level = "Administrator";
                                        break;
                                }
                            @endphp
                                <td>{{ $access_level }}</td>
                                <td>
                                    <a class="btn" href="{{ route('users.edit',$users->id) }}"><i class="fas fa-edit"></i></a>
                                    <button class="btn btn-archive-user" data-id="{{ $users->id }}"><i class="fas fa-archive"></i></button>   
                                </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('admin.utilities.user.modals')

@endsection