@extends('admin.maintenance.product.layout')

@section('content')

@php
    $page_title = "VCS | Update product";
@endphp

<div class="content-header"></div>

    <div class="page-header mb-3">
        <h3 class="mt-2" id="page-title">Update Product</h3>
        <hr>
        <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm"><span class='fas fa-arrow-left'></span></a>
    </div>

        @if(count($errors)>0)
        <div class="row">
            <div class="col-sm-12 col-md-12">
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
        <div class="col-sm-12 col-md-12">
            <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> </h5>
            {{ \Session::get('success') }}
          </div>
        </div>
       
        @endif


        <div class="row">

          <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                                <label class="col-form-label">Description</label>
                                <input type="text" class="form-control" name="description" value="{{ $product->description }}" required>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                              <label class="col-form-label">Quantity</label>
                              <input type="text" class="form-control" name="qty" value="{{ $product->qty }}" required>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                              <label class="col-form-label">Reorder point</label>
                              <input type="text" class="form-control" name="reorder" value="{{ $product->reorder }}" required>
                            </div>
                            
                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">    
                              <label class="col-form-label">Unit</label>
                              <select class="form-control" name="unit_id">
                                  @foreach ($unit as $item)
                                  <option {{ $selected = $product->unit_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                                  <option value="0">Not applicable</option>
                              </select>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">    
                              <label class="col-form-label">Category</label>
                              <select class="form-control" name="category_id">
                                  @foreach ($category as $item)
                                  <option {{ $selected = $product->category_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                              </select>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">    
                              <label class="col-form-label">Supplier</label>
                              <select class="form-control" name="supplier_id" id="supplier_id">
                                  @foreach ($supplier as $item)
                                  <option {{ $selected = $product->supplier_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->supplier_name }}</option>
                                  @endforeach
                              </select>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                              <label class="col-form-label">Original Price</label>
                              <input type="number" step=".01" class="form-control" name="orig_price" id="orig_price" value="{{ $product->orig_price }}">
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                                <div class="form-group">
                                    <label class="col-form-label">Update Image</label>
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                      </div>
                                    </div>
                                  </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-4">
                              @if ($product->image)
                                <img src="{{asset('images/'.$product->image)}}" width="350" height="350" class="img-thumbnail" alt="">
                              @else
                                <img src="{{asset('images/no-image.png')}}" width="350" height="350" class="img-thumbnail" alt="">
                              @endif
                            </div>
    
                              <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary mr-2" id="btn-add-user">Save changes</button>
                                <a href="{{ route('product.index') }}" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</a>
                              </div>
                              
                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
      </div>
    </section>

@endsection