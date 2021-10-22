@extends('admin.maintenance.category.layout')

@section('content')

@php
    $page_title = "VCS | Category Maintenance";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Category Maintenance</h3>
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

        

        <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create category</a>

        <div class="row">

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-category" id="category-table">
                        <tr>
                            <th class="py-2 text-left">Category Name</th>
                            <th class="py-2 text-left">Status</th>
                            <th class="py-2 text-left">Action</th>
                        </tr>
                        @foreach ($category as $data)
                        <tr>
                            <td>{{ $data->name }}</td>
                            <td>
                                @if($data->status == 1)
                                    <span class='badge badge-success'>Active</span> 
                                @else
                                    <span class='badge badge-danger'>Inactive</span> 
                                @endif
                            </td>
                            <td>
                                <a class="btn" href="{{ route('category.edit',$data->id) }}"><i class="fas fa-edit"></i></a>  
                            </td>    
                        </tr>
                        @endforeach
                    </table>
                    {!! $category->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection