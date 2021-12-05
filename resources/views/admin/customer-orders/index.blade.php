@extends('admin.customer-orders.layout')

@section('content')

@php
    $page_title = "VCS | Customer Orders";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Customer Orders</h3>
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

        <div class="row">

            <div class="col-md-12 col-lg-12 mt-2">
                <div class="card">
                  <div class="card-body">

                    <ul class="nav nav-pills" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">Pending</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="prepared-tab" data-toggle="tab" href="#prepared" role="tab" aria-controls="prepared" aria-selected="false">Prepared</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="shipped-tab" data-toggle="tab" href="#shipped" role="tab" aria-controls="shipped" aria-selected="false">Shipped</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Completed</a>
                      </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="mt-4">
                          <table class="table table-hover" id="tbl-pending-order">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Phone number</th>
                                    <th>Date Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="prepared" role="tabpanel" aria-labelledby="prepared-tab">
                        <div class="mt-4">
                          <table class="table table-hover" id="tbl-prepared-order">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Phone number</th>
                                    <th>Date Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="shipped" role="tabpanel" aria-labelledby="shipped-tab">
                        <div class="mt-4">
                          <table class="table table-hover" id="tbl-shipped-order">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Phone number</th>
                                    <th>Date Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                        <div class="mt-4">
                          <table class="table table-hover" id="tbl-completed-order">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Phone number</th>
                                    <th>Date Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                      </div>
                    </div>
        
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



<div class="modal fade bd-example-modal-lg" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Verify Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" readonly>
                    </div>
                    
                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                      <label class="col-form-label">Email</label>
                      <input type="email" class="form-control" name="email" id="email" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                      <label class="col-form-label">Phone number</label>
                      <input type="text" class="form-control" name="phone" id="phone" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                      <label class="col-form-label">Date created</label>
                      <input type="text" class="form-control" name="date_created" id="date_created" readonly>
                    </div>

                    <div class="col-sm-12 mt-2">
                      <label class="col-form-label">Customer's ID</label>
                      <img type="text" class="img-thumbnail" width="100%" name="identification_photo" id="identification_photo">
                    </div>

                    <div class="col-sm-12 mt-2">
                      <label class="col-form-label">Customer's Photo with ID</label>
                      <img type="text" class="img-thumbnail" width="100%" name="selfie_with_identification_photo" id="selfie_with_identification_photo">
                    </div>
                    

                </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-success" id="btn-verify" type="button">Verify</button>
            <button class="btn btn-sm" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>

@endsection