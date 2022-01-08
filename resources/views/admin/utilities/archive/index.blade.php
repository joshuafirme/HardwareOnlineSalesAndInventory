@extends('admin.utilities.archive.layout')

@section('content')

@php
    $page_title = "VCS | Audit Trail";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Archive</h3>
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
    

        <div class="row">
          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">

                  <div class="mt-4">
                    <table class="table table-hover" id="sales-archive-table">
                        <thead>
                         <tr>
                          <th>Invoice #</th>
                          <th>Product Code</th>
                          <th>Name</th>
                          <th>Unit</th>
                          <th>Price</th>
                          <th>Qty</th>
                          <th>Amount</th>
                          <th>Payment method</th>
                          <th>Order from</th>
                          <th>Date time archived</th>
                         </tr>
                        </thead>
                     </table>
                  </div>
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    

  <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="delete-message"></p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-sm btn-outline-dark btn-confirm-restore" type="button">Yes</button>
          <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endsection