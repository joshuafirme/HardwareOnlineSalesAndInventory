@extends('admin.utilities.archive.layout')

@section('content')

@php
    $page_title = "VCS | Audit Trail";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Archive</h3>
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
    

        <div class="row">
            <div class="col-12">
                <div class="float-left mt-2">
                    Date
                </div>
                <input type="date" class="form-control w-auto float-left m-1" name="date_from" id="date_from" value="{{ date('Y-m-d') }}">
                <div class="float-left mt-2">
                    -
                </div>
                <input data-column="9" type="date" class="form-control w-auto float-left m-1" name="date_to" id="date_to" value="{{ date('Y-m-d') }}">  
            </div>
          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">

                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">Products</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="prepared-tab" data-toggle="tab" href="#prepared" role="tab" aria-controls="prepared" aria-selected="false">Users</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Sales</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                          <div class="mt-4">
                            <table class="table table-hover" id="product-archive-table">
                                <thead>
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Reorder point</th>
                                        <th>Unit</th>
                                        <th>Category</th>
                                        <th>Supplier</th>
                                        <th>Original Price</th>
                                        <th>Selling Price</th>
                                        <th>Date time archived</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="prepared" role="tabpanel" aria-labelledby="prepared-tab">
                          <div class="mt-4">
                            <table class="table table-hover" id="user-archive-table">
                                <thead>
                                 <tr>
                                     <th>Name</th>
                                     <th>Email</th>
                                     <th>Access Level</th>
                                     <th>Date archive</th>
                                     <th>Action</th>
                                 </tr>
                                </thead>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                          <div class="mt-4">
                            <table class="table table-hover" id="sales-archive-table">
                                <thead>
                                 <tr>
                                  <th>Invoice #</th>
                                  <th>Product Code</th>
                                  <th>Name</th>
                                  <th>Unit</th>
                                  <th>Price</th>
                                  <th>Qty</th>
                                  <th>Amount</th>
                                  <th>Payment method</th>
                                  <th>Order from</th>
                                  <th>Date time archived</th>
                                 </tr>
                                </thead>
                             </table>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    

  <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="delete-message"></p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-sm btn-outline-dark btn-confirm-restore" type="button">Yes</button>
          <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endsection