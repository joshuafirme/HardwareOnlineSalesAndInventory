@extends('admin.maintenance.delivery_area.layout')


@section('content')

@php
    $page_title = "VCS | Create Delivery Area";
    $public_path = public_path();
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Update Delivery Area</h3>
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
                    <form action="{{ route('delivery_area.update',$delivery_area->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Municipality</label>
                                <select class="form-control" name="municipality">
                                    @foreach($municipalities as $key => $data)
                                    <option {{ $selected = $delivery_area->municipality == $key ? 'selected' : '' }} value="{{ $key }}">{{ $key }}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="col-form-label">Barangay</label>
                                <select class="form-control" name="brgy">
                                    <option selected value="{{$delivery_area->brgy}}">{{$delivery_area->brgy}}</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-3">
                                <label class="col-form-label">Shipping Fee</label>
                                <input type="number" step=".01" class="form-control" name="shipping_fee" value="{{$delivery_area->shipping_fee}}" required>
                              </div>

                            <div class="col-sm-12 col-md-6 mt-3">    
                              <label class="col-form-label">Status</label>
                              <select class="form-control" name="status" id="status">
                                  <option {{$delivery_area->status == 1 ? 'selected' : ''}} value="1">Active</option>
                                  <option {{$delivery_area->status == 0 ? 'selected' : ''}} value="0">Inactive</option>
                              </select>
                            </div>
    
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save changes</button>
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