@extends('admin.inventory.purchase-order.layout')

@section('content')

@php
    $page_title = "VCS | Purchase Order";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Purchase Order</h3>
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
        
          <div class="col-sm-6  col-lg-12 mb-2">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ordersModal" id="btn-show-orders"><span class='fas fa-cart-arrow-down' ></span> Orders</button>
           
            </div>
          <!--  <form method="POST" action="//action('PurchaseOrderCtr@pay')">
               #CSRF
              <button type="submit" class="btn btn-primary btn-sm" id="btn-pay-"><span class='fas fa-money-bill' ></span> GCash</button>
               </form>-->

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

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="reordertab" role="tabpanel" aria-labelledby="reorder-tab">

                <div class="form-group row mt-4 mb-2">
            
                    <label class="ml-2 mt-1">Supplier</label>
                    <select data-column="4" class=" form-control col-sm-2 ml-2 mb-3" name="ro_supplier" id="ro_supplier">
                        @foreach ($supplier as $item)
                            <option value="{{ $item->id }}">{{ $item->supplier_name }}</option>
                        @endforeach
                    </select>
                  </div>   
                    <table class="table responsive  table-hover tbl-reorder" width="100%">                                     
                      <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Description</th> 
                            <th>Unit</th>      
                            <th>Category</th>      
                            <th>Supplier</th>   
                            <th>Price</th>               
                            <th>Stock</th>                                
                            <th>Reorder Point</th>        
                            <th>Action</th>
                         
                        </tr>
                      </thead>
                    
                    </table>
                    
                  </div>

                  <div class="tab-pane fade" id="orderstab" role="tabpanel" aria-labelledby="orders-tab">


                      <div class="row">

                        <div class="mt-2">
                          Supplier
                         </div>  
                        
                        <div class="col-sm-2 mb-3">
                          <select class=" form-control col-sm-12 ml-2" name="ord_supplier" id="ord_supplier">
                       
                          <option ></option>
                          </select>
                          </div> 

                        <div class="mt-2 ml-3">
                           Date
                          </div>              
                        
                        <div class="col-sm-2 mb-3">
                          <input data-column="9" type="date" class="form-control" name="date_from" id="date_from" value="">
                          </div>
        
                          <div class="mt-2">
                            -
                            </div>
              
                          <div class="col-sm-2 mb-3">
                            <input data-column="9" type="date" class="form-control" name="date_to" id="date_to" value="">
                            </div>  

                       </div>

                        <table class="table responsive  table-hover" id="ord-table" width="100%">       
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
                        <tbody>                    
                      </tbody>
                        
                        </table> 
                      </div>

                </div>

                  </div>
                </div>
                
            </div>
        </div>
       
    </section>
    <!-- /.content -->



<div class="modal fade bd-example-modal-lg" id="purchase-order-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Order</h5>
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

                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Price</label>
                      <input type="number" step=".01" class="form-control" name="price" id="price" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Qty</label>
                        <input type="number" class="form-control" name="qty" id="qty" readonly>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Qty order</label>
                        <input type="number" class="form-control" name="qty_order" id="qty_order">
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Total Amount</label>
                      <div class="form-control" name="total" id="total">
                    </div>

                </div>
        </div>
        <div class="modal-footer mt-4">
            <button class="btn btn-sm btn-success btn-confirm-order" type="button">Add order</button>
            <button class="btn btn-sm" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>

@endsection