
@php
$page_title =  "Val Construction Supply | Orders";
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

<style>
.border-md {
  border-width: 2px !important;
}

.btn-facebook {
  background: #405D9D;
  border: none;
}

.btn-facebook:hover, .btn-facebook:focus {
  background: #314879;
}

.btn-twitter {
  background: #42AEEC;
  border: none;
}

.btn-twitter:hover, .btn-twitter:focus {
  background: #1799e4;
}

body {
  min-height: 100vh;
}

.form-control:not(select) {
  padding: 1.5rem 0.5rem;
}

select.form-control {
  height: 52px;
  padding-left: 0.5rem;
}

.form-control::placeholder {
  color: #ccc;
  font-weight: bold;
  font-size: 0.9rem;
}
.form-control:focus {
  box-shadow: none;
}

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

                        @php
                            $total = DB::table('orders')->where('order_no', $item->order_no)->sum('amount');
                        @endphp
                        <div>Shipping fee: ₱{{ number_format($item->shipping_fee,2,".",",")}} </div> 
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

@include('footer')

<script src="{{asset('js/myorder.js')}}"></script>

