@extends('admin.reports.layout')

@section('content')

@php
    $page_title = "VCS | Sales Report";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Sales Report</h3>
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

        <div class="float-left mt-2 ml-3">
            Payment method
        </div>
        <select class="form-control w-auto m-1 float-left" id="payment_method">
            <option value="Cash">Cash</option>
            <option value="GCash">GCash</option>
        </select>

        <div class="float-left mt-2 ml-3">
            Order type
        </div>
        <select class="form-control w-auto m-1 float-left" id="order_from">
            <option value="walk-in">Walk-in</option>
            <option value="online">Online</option>
        </select>

        <div class="float-left mt-1 ml-3">
            <p>Total sales: <span style="font-size: 21px;">&#8369; <b id="txt-total-sales"></b></span></p>
        </div>


        <a class="btn btn-sm btn-outline-dark btn-preview-sales float-right m-1">Print Preview</a>
        <a class="btn btn-sm btn-outline-success btn-download-sales float-right m-1"><i class="fas fa-download"></i> Download PDF</a>
    </div>
        
    <div class="col-md-12 col-lg-12 mt-3">
      <div class="card">
          <div class="card-body">
              <table class="table table-hover tbl-sales" >
                  <thead>
                      <tr>
                        <th>Invoice #</th>
                        <th>Product Code</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Payment method</th>
                        <th>Order from</th>
                        <th>Date time</th>
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