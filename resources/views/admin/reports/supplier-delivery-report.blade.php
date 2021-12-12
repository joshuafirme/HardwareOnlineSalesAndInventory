@extends('admin.reports.layout')

@section('content')

@php
    $page_title = "VCS | Supplier Delivery Report";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Supplier Delivery Report</h3>
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
        
        <div class="row mt-4 ml-2">
          <div class="col-12">

            <div class="float-left mt-2">
              Supplier
          </div>
          <select class="form-control w-auto m-1 float-left" id="supplier">
            @foreach ($supplier as $item)
            <option value="{{ $item->id }}">{{ $item->supplier_name }}</option>
         @endforeach
          </select>

            <div class="float-left mt-2 ml-3">
              Date
          </div>
          <input type="date" class="form-control w-auto float-left m-1" name="date_from" id="date_from" value="{{ date('Y-m-d') }}">
          <div class="float-left mt-2">
              -
          </div>
          <input data-column="9" type="date" class="form-control w-auto float-left m-1" name="date_to" id="date_to" value="{{ date('Y-m-d') }}">  
              <a class="btn btn-sm btn-outline-dark float-right m-1 btn-preview-supplier-delivery-report">Print Preview</a>
              <a class="btn btn-sm btn-outline-success float-right m-1 btn-download-supplier-delivery-report"><i class="fas fa-download"></i> Download PDF</a>
        </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-supplier-delivery-report">
                        <thead>
                            <tr>
                                <th>Delivery #</th>
                                <th>PO #</th>
                                <th>Product Code</th>     
                                <th>Name</th>   
                                <th>Supplier</th> 
                                <th>Unit</th>      
                                <th>Qty Ordered</th>                              
                                <th>Qty Delivered</th>   
                                <th>Date Recieved</th>
                                <th>Remarks</th>
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