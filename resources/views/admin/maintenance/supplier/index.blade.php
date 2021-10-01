@extends('admin.maintenance.supplier.layout')

@section('content')

@php
    $page_title = "VCS | Supplier Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Supplier Maintenance</h3>
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

        

        <a href="{{ route('supplier.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create Supplier</a>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-supplier" id="unit-table">
                        <tr>
                            <th class="py-2 text-left">Supplier Name</th>
                            <th class="py-2 text-left">Address</th>
                            <th class="py-2 text-left">Person</th>
                            <th class="py-2 text-left">Contact</th>
                            <th class="py-2 text-left">Email</th>
                            <th class="py-2 text-left">Markup</th>
                            <th class="py-2 text-left">Status</th>
                            <th class="py-2 text-left">Action</th>
                        </tr>
                        @foreach ($supplier as $data)
                        <tr>
                            <td>{{ $data->supplier_name }}</td>
                            <td>{{ $data->address }}</td>
                            <td>{{ $data->person }}</td>
                            <td>{{ $data->contact }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->markup }}</td>
                            <td>
                                @if($data->status == 1)
                                    <span class='badge badge-success'>Active</span> 
                                @else
                                    <span class='badge badge-danger'>Inactive</span> 
                                @endif
                            </td>
                            <td>
                                <a class="btn" href="{{ route('supplier.edit',$data->id) }}"><i class="fas fa-edit"></i></a>  
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


@endsection