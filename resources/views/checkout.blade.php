
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
                    <div class="summary">
                        <h3>Summary</h3>
                        <div class="summary-item"><span class="text">Subtotal</span><span class="price" id="subtotal"></span></div>
                        <div class="summary-item"><span class="text">Shipping</span><span class="price" id="shipping-fee">₱0</span></div>
                        <div class="summary-item"><span class="text">Total</span><span class="price" id="total"></span></div>
                        <button id="btn-place-order" class="btn btn-primary btn-lg btn-block">Place order</button>
                    </div>
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


