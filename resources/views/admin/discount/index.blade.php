@extends('admin.discount.layout')

@section('content')

@php
    $page_title = "VCS | Discount Maintenance";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Discount Maintenance</h3>
        <hr>
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
                    <form action="{{ route('discount.update',$discount->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Discount percentage</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                          <span class="fas fa-percent"></span>
                                        </div>
                                      </div>
                                    <input name="discount_percentage" type="number" step="0.01" class="form-control" value="{{ $discount->discount_percentage }}">
                                  </div>
                                  <small>0.20 means 20%</small>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-2">
                                <label class="col-form-label">Minimun purchase amount</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                          <span class="fas fa-money-bill"></span>
                                        </div>
                                      </div>
                                    <input name="minimum_purchase" type="text" class="form-control" value="{{ $discount->minimum_purchase }}">

                                  </div>
                            </div>

                            <div class="col-sm-12"><hr></div>

                            <div class="col-sm-12 col-md-6 mt-2">
                              <label class="col-form-label">Senior citizen discount percentage</label>
                              <div class="input-group">
                                  <div class="input-group-append">
                                      <div class="input-group-text">
                                        <span class="fas fa-percent"></span>
                                      </div>
                                    </div>
                                  <input name="senior_discount" type="number" step="0.01" class="form-control" value="{{ $discount->senior_discount }}">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 mt-2">
                              <label class="col-form-label">PWD discount percentage</label>
                              <div class="input-group">
                                  <div class="input-group-append">
                                      <div class="input-group-text">
                                        <span class="fas fa-percent"></span>
                                      </div>
                                    </div>
                                  <input name="pwd_discount" type="number" step="0.01" class="form-control" value="{{ $discount->pwd_discount }}">
                                </div>
                            </div>
    
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save changes</button>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection