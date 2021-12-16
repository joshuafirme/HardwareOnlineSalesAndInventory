
@php
$page_title =  "Val Construction Supply | Orders";
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

<style>

</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <main class="d-flex align-items-center py-3 py-md-0">
      <div class="container shopping-cart">
        <div class="row mt-5">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                    <h3>My Orders ({{ isset($orders) ? count($orders) : "" }} items)</h3>
                    @php
                        $order_number_temp = "";
                        $total = 0;
                    @endphp
                    @foreach ($orders as $key => $item)
                        @if ($item->order_no != $order_number_temp)
                        <hr>
                        <div class="text-bold mt-5">Order #: {{ $item->order_no }}
                          @php
                              $badge_class = "success";
                              $pending_active_class = 'active';
                              $prepared_active_class = '';
                              $shipped_active_class = '';
                              $delivered_active_class = '';

                              if ($item->status == 1) {
                                $status = "Pending";
                              }
                              if ($item->status == 2) {
                                $prepared_active_class = 'active';
                                $status = "Prepared";
                              }
                              else if ($item->status == 3) {
                                $prepared_active_class = 'active';
                                $shipped_active_class = 'active';
                                $status = "Shipped";
                              }
                              else if ($item->status == 4) {
                                $prepared_active_class = 'active';
                                $shipped_active_class = 'active';
                                $delivered_active_class = 'active';
                                $status = "Completed";
                              }
                              else if ($item->status == 0) {
                              $status = "Cancelled";
                              $badge_class = "light";
                              }
                          @endphp
                            <div class="float-right"><span class="badge badge-{{ $badge_class }}">{{ $status}}</span></div>
                            @if ($item->status == 1)
                              <a style="cursor: pointer; color:#DC3545;" data-order-no="{{ $item->order_no }}" data-date-time="{{ $item->created_at }}"
                              class="float-right mr-2 cancel-order">
                                Cancel
                              </a>
                            @endif
                        </div> 
                        @if ($item->status == 2 || $item->status == 3)
                          <div class="float-right mt-3">Estimated delivery date <br> <span>{{date('F d, Y', strtotime($item->delivery_date))}}</span></div>
                        @endif

                        @if ($item->status == 4)
                          <a  class="float-right mt-3 btn-write-feedback" style="cursor: pointer;" data-order-no="{{ $item->order_no }}">Write a feedback</a>
                        @endif

                        @php
                            $total = DB::table('orders')->where('order_no', $item->order_no)->sum('amount');
                        @endphp
                        <div>Delivery fee: ₱{{ number_format($item->shipping_fee,2,".",",")}} </div> 
                        <div>Subtotal: ₱{{ number_format($total,2,".",",")}} </div> 
                        <div>Total: ₱{{ number_format($total+$item->shipping_fee,2,".",",")}} </div> 
                        <div>Payment Method: {{$item->payment_method}} </div>
                        <div>Date order: {{date('F d, Y h:i A', strtotime($item->created_at))}} </div><br>
                          @if ($item->status != 0) 
                            <div class="card card-timeline shadow-none">
                              <ul class="bs4-order-tracking">
                                  <li class="step {{$pending_active_class}}">
                                      <div><i class="fas fa-cog"></i></div> Pending
                                  </li>
                                  <li class="step {{$prepared_active_class}}">
                                      <div><i class="fas fa-cube"></i></div> Prepared
                                  </li>
                                  <li class="step {{$shipped_active_class}}">
                                      <div><i class="fas fa-truck-moving"></i></div> Shipped
                                  </li>
                                  <li class="step {{$delivered_active_class}}">
                                    <div><i class="fas fa-check-circle"></i></div> Delivered
                                </li>
                                
                              </ul>
                            </div>
                            @endif
                        @endif

                        <div class="row mt-3">
                        <div class="col-md-3">
                            <img class="img-fluid mx-auto d-block image" src="{{asset('images/'.$item->image)}}">
                            </div>
                            <div class="col-md-8">
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-5 product-name">
                                            <div class="product-name">
                                                <a>{{$item->description}}</a>
                                                <div class="product-info">
                                                    <div>Price: <span class="value">₱{{$item->selling_price}}</span></div>
                                                    <div>Unit: <span class="value">{{$item->unit}}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 quantity">
                                            <label for="quantity">Qty</label>
                                            <div>{{$item->qty}}</div>
                                        </div>
                                        <div class="col-md-4 price">
                                            <span>Amount: ₱<span>{{$item->amount}}</span></span><br>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                    
                    @php
                        $order_number_temp = $item->order_no;
                    @endphp
                    @endforeach
                    
               
                </div>
              </div>
            </div>
          </div>
      </div>
    </main>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--Confirm Modal-->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancel Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure do you want to cancel this order?</p>
        <small class="validation-text text-danger"></small>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-dark" id="btn-confirm-cancel" type="button">Yes</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="feedback-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
              <label class="col-form-label">Comment</label>
              <textarea rows="3" type="text" class="form-control" name="comment"  id="comment" required></textarea>
          </div>  
          <div class="col-sm-12">
            <label class="col-form-label">Suggestion</label>
            <textarea rows="3" type="text" class="form-control" name="suggestion"  id="suggestion" required></textarea>
          </div>  

      </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-dark" id="btn-send-feedback" type="button">Send</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

@include('footer')

<script src="{{asset('js/myorder.js')}}"></script>

