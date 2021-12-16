@extends('admin.utilities.feedback.layout')

@section('content')

@php
    $page_title = "VCS | Feedback";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Feedback</h3>
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
            <div class="col-12">
                <div class="float-left mt-2">
                    Date
                </div>
                <input type="date" class="form-control w-auto float-left m-1" name="date_from" id="date_from" value="{{ date('Y-m-d') }}">
                <div class="float-left mt-2">
                    -
                </div>
                <input data-column="9" type="date" class="form-control w-auto float-left m-1" name="date_to" id="date_to" value="{{ date('Y-m-d') }}">  
            </div>
          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="feedback-table">
                       <thead>
                        <tr>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Suggestion</th>
                            <th>Date time</th>
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

    <div class="modal fade bd-example-modal-lg" id="show-orders-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Order Information</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body" id="printable-order-info">
                  <div class="row" id="user-info">
                  </div>
                  <div class="mt-3 mb-3" id="shipping-info-container"></div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="orders-container"></tbody>
                </table>
                <div>Contact: <span id="phone-number-text"></span></div>
                <div>Email: <span id="email-text"></span></div>
              </div>
              <div class="modal-footer">
              </div>
              <meta id="shipping-fee-value">
          </div>
        </div>
      </div>

@endsection