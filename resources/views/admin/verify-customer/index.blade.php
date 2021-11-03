@extends('admin.verify-customer.layout')

@section('content')

@php
    $page_title = "VCS | Verify Customer";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Verify Customer</h3>
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


                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item">
                          <a class="nav-link  active" id="reorder-tab" data-toggle="tab" href="#reordertab" role="tab" aria-controls="contact" aria-selected="true">Reorder Products   
        
                          </a>
                        </li>
        
                        <li class="nav-item">
                          <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orderstab" role="tab" aria-controls="contact" aria-selected="true">Purchased Orders   
        
                          </a>
                        </li>
         
                      </ul>
        
                      <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade active show" id="reordertab" role="tabpanel" aria-labelledby="reorder-tab">
                          
                          <table class="table table-hover tbl-unverified-users">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone number</th>
                                    <th>Status</th>
                                    <th>Date created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                            
                          </div>
        
                          <div class="tab-pane fade" id="orderstab" role="tabpanel" aria-labelledby="orders-tab">
        
        
                              <div class="row mt-4 ml-1">
        
                                  <div class="col-12">        
                                    <table class="table responsive  table-hover" id="purchased-order-table" width="100%">       
                                      <thead>
                                        <tr>
                                            <th>PO #</th>
                                            <th>Product Code</th>     
                                            <th>Description</th>   
                                            <th>Supplier</th> 
                                            <th>Category</th> 
                                            <th>Unit</th>                                 
                                            <th>Qty Order</th>        
                                            <th>Amount</th>
                                            <th>Date Order</th>
                                            <th>Status</th>
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

            </div>


        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->



<div class="modal fade bd-example-modal-lg" id="ajustQtyModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                        <label class="col-form-label">Product Code</label>
                        <input type="text" class="form-control" name="product_code" id="product_code" readonly>
                    </div>
                    
                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Description</label>
                        <input type="text" class="form-control" name="description" id="description" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                      <label class="col-form-label">Original Price</label>
                      <input type="number" step=".01" class="form-control" name="orig_price" id="orig_price" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                      <label class="col-form-label">Markup</label>
                      <input type="number" step=".01" class="form-control" name="markup" id="markup" min="0">
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                        <label class="col-form-label">Selling Price</label>
                        <input type="number" step=".01" class="form-control" name="selling_price" id="selling_price" readonly>
                    </div>


                </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-success btn-confirm-markup" type="button">Save changes</button>
            <button class="btn btn-sm" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>

@endsection