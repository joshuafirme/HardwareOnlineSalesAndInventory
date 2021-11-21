
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
                        <div class="summary-item"><span class="text">Subtotal</span><span class="price" id="subtotal"></span></div>
                        <div class="summary-item"><span class="text">Shipping</span><span class="price" id="shipping-fee">₱0</span></div>
                        <div class="summary-item"><span class="text">Total</span><span class="price" id="total"></span></div>
                        <label class=" mt-3">Payment method</label>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="optradio">Cash on Delivery
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="optradio">Gcash
                          </label>
                        </div>
                    </div>
                    <a id="btn-place-order" class="btn btn-primary btn-sm mt-3">Place order</a>
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

