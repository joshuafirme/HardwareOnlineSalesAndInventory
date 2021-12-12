@extends('admin.pricing.layout')

@section('content')

@php
    $page_title = "VCS | Pricing";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Pricing</h3>
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

          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover tbl-pricing">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Category</th>
                                <th>Supplier</th>
                                <th>Original price</th>
                                <th>Markup</th>
                                <th>Selling price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
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
            <h5 class="modal-title">Pricing</h5>
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
                        <label class="col-form-label">Name</label>
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