@extends('admin.reports.layout')

@section('content')

@php
    $page_title = "VCS | Inventory Report";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Inventory Report</h3>
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

  <div class="row mt-4">

      
    <div class="col-12"> <div class="float-left mt-2 ml-3">
        Category
    </div>
    <select class="form-control w-auto m-1 float-left" id="inv_category">
        <option value="0">All category</option>
        @foreach ($category as $item)
        <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
    </select>
        <a class="btn btn-sm btn-outline-dark float-right m-1 btn-preview-inventory-report">Print Preview</a>
        <a class="btn btn-sm btn-outline-success float-right m-1 btn-download-inventory-report"><i class="fas fa-download"></i> Download PDF</a>
    </div>
        
    <div class="col-md-12 col-lg-12 mt-3">
      <div class="card">
          <div class="card-body">
              <table class="table table-hover tbl-inventory" >
                  <thead>
                      <tr>
                        <th>Product Code</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Original Price</th>
                        <th>Selling Price</th>
                      </tr>
                  </thead>
              </table>
          </div>
      </div>
  </div>

  <!-- /.row (main row) -->
  
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->


@endsection