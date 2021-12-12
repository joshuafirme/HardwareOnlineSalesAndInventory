@extends('admin.reports.layout')

@section('content')

@php
    $page_title = "VCS | Stock Adjustment Report";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Stock Adjustment Report</h3>
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

      
    <div class="col-12">
        <div class="float-left mt-2">
            Date
        </div>
        <input type="date" class="form-control w-auto float-left m-1" name="date_from" id="date_from" value="{{ date('Y-m-d') }}">
        <div class="float-left mt-2">
            -
        </div>
        <input data-column="9" type="date" class="form-control w-auto float-left m-1" name="date_to" id="date_to" value="{{ date('Y-m-d') }}">  
        <a class="btn btn-sm btn-outline-dark btn-preview-pdf float-right m-1">Print Preview</a>
        <a class="btn btn-sm btn-outline-success btn-download-pdf float-right m-1"><i class="fas fa-download"></i> Download PDF</a>
    </div>
        
    <div class="col-md-12 col-lg-12 mt-3">
      <div class="card">
          <div class="card-body">
              <table class="table table-hover tbl-stock-adjustment" >
                  <thead>
                      <tr>
                          <th>Product Code</th>
                          <th>Name</th>
                          <th>Unit</th>
                          <th>Category</th>
                          <th>Supplier</th>
                          <th>Qty adjusted</th>
                          <th>Action</th>
                          <th>Remarks</th>
                          <th>Date adjusted</th>
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