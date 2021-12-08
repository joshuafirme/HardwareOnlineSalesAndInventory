@extends('admin.maintenance.delivery_area.layout')


@section('content')

@php
    $page_title = "VCS | Create Delivery Area";
    $public_path = public_path();
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Create Delivery Area</h3>
        <hr>
        <a href="{{ route('delivery_area.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
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
                    <form action="{{ route('delivery_area.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Municipality</label>
                                <select class="form-control" name="municipality">
                                    @foreach($municipalities as $key => $data)
                                    <option value="{{ $key }}">{{ $key }}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Barangay</label>
                                <select class="form-control" name="brgy">
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-3">
                                <label class="col-form-label">Delivery fee</label>
                                <input type="number" step=".01" class="form-control" name="shipping_fee" required>
                              </div>

                            <div class="col-sm-12 col-md-6 mt-3">    
                              <label class="col-form-label">Status</label>
                              <select class="form-control" name="status" id="status">
                                  <option selected value="1">Active</option>
                                  <option value="0">Inactive</option>
                              </select>
                            </div>
    
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save</button>
                                <a href="{{ route('delivery_area.index') }}" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</a>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection