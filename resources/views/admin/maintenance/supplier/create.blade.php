@extends('admin.maintenance.supplier.layout')

@section('content')

@php
    $page_title = "VCS | Create Supplier";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Create Supplier</h3>
        <hr>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
    </div>

        @if(count($errors)>0)
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
            
                        <li>{{$error}}</li>
                            
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    
        @if(\Session::has('success'))
        <div class="col-sm-12 col-md-8">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-check"></i> </h5>
              {{ \Session::get('success') }}
          </div>
        </div>
       
        @endif


        <div class="row">

          <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('supplier.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Supplier Name</label>
                                <input type="text" class="form-control" name="supplier_name"  id="supplier_name" required>
                            </div>

                            <div class="col-sm-12 col-md-6">
                              <label class="col-form-label">Address</label>
                              <input type="text" class="form-control" name="address"  id="address" required>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-2">
                              <label class="col-form-label">Person</label>
                              <input type="text" class="form-control" name="person"  id="person" required>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-2">
                              <label class="col-form-label">Contact</label>
                              <input type="text" class="form-control" name="contact"  id="contact" required>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Email</label>
                                <input type="email" class="form-control" name="email"  id="email" required>
                            </div>

                            <div class="col-sm-12 col-md-6 mb-2">    
                              <label class="col-form-label">Status</label>
                              <select class="form-control" name="status" id="status" required>
                                 <option selected disabled>--Select status--</option>
                                  <option selected value="1">Active</option>
                                  <option value="0">Inactive</option>
                              </select>
                            </div>
    
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save</button>
                                <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</a>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection