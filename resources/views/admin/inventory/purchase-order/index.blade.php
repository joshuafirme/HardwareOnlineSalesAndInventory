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

                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#order-request-modal" id="btn-show-request-orders"> View Request Order</button> 
                    </div>
                  </div>  
                  
                    <table class="table responsive  table-hover tbl-reorder" width="100%">                                     
                      <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Name</th> 
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


                      <div class="row mt-4 ml-1">

                        <div class="mt-2">
                          Supplier
                         </div>  
                        
                        <div class="col-sm-2 mb-3">
                          
                          <select class=" form-control col-sm-12 ml-2" name="ord_supplier" id="ord_supplier">
                            @foreach ($supplier as $item)
                              <option value="{{ $item->id }}">{{ $item->supplier_name }}</option>
                            @endforeach
                          </select>
                          </div> 

                        <div class="mt-2 ml-3">
                           Date
                          </div>              
                        
                        <div class="col-sm-2 mb-3">
                          <input data-column="9" type="date" class="form-control" name="date_from" id="date_from" value="{{ date('Y-m-d') }}">
                          </div>
        
                          <div class="mt-2">
                            -
                            </div>
              
                          <div class="col-sm-2 mb-3">
                            <input data-column="9" type="date" class="form-control" name="date_to" id="date_to" value="{{ date('Y-m-d') }}">
                            </div>  

                          <div class="col-12">        
                            <table class="table responsive  table-hover" id="purchased-order-table" width="100%">       
                              <thead>
                                <tr>
                                    <th>PO #</th>
                                    <th>Product Code</th>     
                                    <th>Name</th>   
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
       
    </section>
    <!-- /.content -->


@include('admin.inventory.purchase-order.modal')

@endsection