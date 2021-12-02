
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
                            <div class="float-right"><span class="badge badge-success">Pending</span></div>
                        </div> 

                        @php
                            $total = DB::table('orders')->where('order_no', $item->order_no)->sum('amount')
                        @endphp

                        <div>Total: ₱{{ number_format($total,2,".",",")}} </div> 
                        <div>Payment Method: {{$item->payment_method}} 
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

@include('footer')


