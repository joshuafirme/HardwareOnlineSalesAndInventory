
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
                        <div class="summary-item"><span class="text">Subtotal</span><span class="price">₱{{$subtotal}}</span></div>
                        <div class="summary-item"><span class="text">Delivery fee</span><span class="price">₱{{$charge}}</span></div>
                        @php
                            $total = $subtotal+$charge;
                        @endphp
                        <div class="summary-item"><span class="text">Total</span><span class="price">₱{{ number_format($total,2,".",",")}}</span></div>
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


