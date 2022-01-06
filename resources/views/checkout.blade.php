
@php
$page_title =  "Val Construction Supply | Cart";
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
                    <h3>Checkout (<span class="cart-count"></span> items)</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="items" id="cart-items">
                                <div class="loader-container">
                                    <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="summary p-2">
                        <h3>Checkout</h3>
                        <label>Delivery Address</label>
                        <meta content="{{ $address }}" id="meta-delivery">
                        <meta id="subtotal-hidden" content="{{$subtotal}}">
                        @if (isset($address))
                        <p>{{ $address->municipality . " " . $address->brgy . " " . $address->street }}</p>
                        @else
                        <p>-</p>
                        @endif
                        @php
                            $discount_amount = 0;
                            $wholesale_discount = 0;
                            $user = \Auth::user();
                            $discount = \DB::table('discount')->first();
                        @endphp
                          <div class="summary-item"><span class="text">Subtotal</span><span class="price">₱{{$subtotal}}</span></div>
                          @if ($subtotal >= $discount->minimum_purchase) 
                            @php
                                $discount_percentage = $discount->discount_percentage * 100;
                                $wholesale_discount = $discount->discount_percentage * $subtotal;
                            @endphp
                            <div class="summary-item"><span class="text">Wholesale Discount</span><span class="price">₱{{$wholesale_discount}}</span><small> - {{ $discount_percentage }}%</small></div>
                          @endif
                        @if($user->id_type == "Senior Citizen ID/Booklet")
                          @php
                            $discount_percentage = $discount->senior_discount * 100;
                            $discount_amount = $discount->senior_discount * $subtotal;
                          @endphp
                        <div class="summary-item"><span class="text">Senior Discount</span><span class="price">₱{{ number_format($discount_amount,2,".",",")}}</span><small> - {{ $discount_percentage }}%</small></div>
                        @elseif($user->id_type == "PWD ID")
                          @php
                            $discount_percentage = $discount->pwd_discount * 100;
                            $discount_amount = $discount->pwd_discount * $subtotal;
                          @endphp
                        <div class="summary-item"><span class="text">PWD Discount</span><span class="price">₱{{$discount_amount}}</span><small> - {{ $discount_percentage }}%</small></div>
                        @endif
                        <div class="summary-item"><span class="text">Delivery fee</span><span class="price">₱{{$charge}}</span></div>
                        @php
                        
                            $subtotal = ($subtotal - $discount_amount) - $wholesale_discount;
                            $total = $subtotal+$charge;
                        @endphp
                        <div class="summary-item"><span class="text">Total</span><span class="price">₱{{ number_format($total,2,".",",") }}</span></div>
                        <label class=" mt-3">Payment method</label>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="cod" id="opt-cod" name="optpayment-method" checked>Cash on Delivery 
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="gcash" id="opt-gcash" name="optpayment-method">Gcash
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="paymaya" id="opt-paymaya" name="optpayment-method">Paymaya
                          </label>
                        </div>
                    </div>
                    <small class="text-danger d-none" id="invalid-amount-message"></small><br>
                    <a id="btn-place-order" class="btn btn-primary btn-sm mt-3">Place order</a>
                    <input type="hidden" id="total-amount" value="{{ $total }}">
                    <input type="hidden" id="payment-method">
                  </div>
                </div>
              </div>
          </div>
      </div>
    </main>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer')

<script src="{{asset('js/checkout.js')}}"></script>


