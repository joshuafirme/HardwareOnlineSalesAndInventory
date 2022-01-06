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
                          <a class="nav-link  active" id="unverified-tab" data-toggle="tab" href="#reordertab" role="tab" aria-controls="contact" aria-selected="true">Unverified   
        
                          </a>
                        </li>
        
                        <li class="nav-item">
                          <a class="nav-link" id="verified-tab" data-toggle="tab" href="#orderstab" role="tab" aria-controls="contact" aria-selected="true">Verified   
        
                          </a>
                        </li>
         
                      </ul>
        
                      <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade active show" id="reordertab" role="tabpanel" aria-labelledby="unverified-tab">
                          
                          <table class="table table-hover tbl-unverified-users">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone number</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Customer's ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                            
                          </div>
        
                          <div class="tab-pane fade" id="orderstab" role="tabpanel" aria-labelledby="verified-tab">
        
        
                              <div class="row mt-4 ml-1">
        
                                  <div class="col-12">        
                                    <table class="table responsive  table-hover tbl-verified-users" width="100%">       
                                      <thead>
                                        <tr>
                                          <th>Name</th>
                                          <th>Username</th>
                                          <th>Email</th>
                                          <th>Phone number</th>
                                          <th>Status</th>
                                          <th>Verified since</th>
                                          <th>Customer's ID</th>
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

                    <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                      <label class="col-form-label">ID type</label>
                      <input type="text" class="form-control" name="id_type" id="id_type" readonly>
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