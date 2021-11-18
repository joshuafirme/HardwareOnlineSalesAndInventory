
@php
$page_title =  "Val Construction Supply | Cart";
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
                    <h3>Cart (<span class="cart-count"></span> items)</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="items" id="cart-items">
                            </div>
                            <div class="loader-container">
                              <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                          </div>
                        </div>
                        <div class="col-md-12">
                        
                        <div class="summary">
                            <div class="summary-item"><span style="font-size: 20px" class="text">Total amount </span><span style="font-size: 20px" id="total"></span></div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg btn-block mt-2">Checkout</a>
                        </div>
                      </div>
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

<script src="{{asset('js/cart.js')}}"></script>


