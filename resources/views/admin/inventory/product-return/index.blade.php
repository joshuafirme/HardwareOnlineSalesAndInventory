@extends('admin.inventory.product-return.layout')

@section('content')

@php
    $page_title = "VCS | Product Return";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Product Return</h3>
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
                        <th>Selling price</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Payment method</th>
                        <th>Order from</th>
                        <th>Date time</th>
                        <th>Action</th>
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

<div class="modal fade bd-example-modal-lg" id="productReturnModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Product Return</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Invoice #</label>
                      <input type="text" class="form-control" id="invoice_no" readonly>
                    </div>
                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Product Code</label>
                        <input type="text" class="form-control" id="product_code" readonly>
                    </div>
                    
                    <div class="col-sm-12 col-md-12 mt-2">
                        <label class="col-form-label">Description</label>
                        <input type="text" class="form-control" id="description" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Selling price</label>
                      <input type="number" step=".01" class="form-control" id="selling_price" readonly>
                  </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Qty Purchased</label>
                        <input type="number" class="form-control" id="qty_purchased" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Amount Purchased</label>
                        <input type="number" step=".01" class="form-control" id="amount_purchased" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Qty to return</label>
                      <input type="number" min="1" class="form-control" id="qty_return">
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Amount</label>
                      <input type="number" step=".01" class="form-control" id="amount" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Reason</label>
                      <select  class="form-control" id="reason">
                        <option value="Wrong item">Wrong item</option>
                        <option value="Damaged">Damaged</option>
                      </select>
                    </div>

                </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-success btn-confirm-return" type="button">Return</button>
            <button class="btn btn-sm" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>

@endsection