
@php
$page_title =  "Val Construction Supply | Order Info";
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <main class="d-flex align-items-center py-3 py-md-0">
      <div class="container shopping-cart">
        <div class="row mt-5">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                    <div class="row">
                      @php
                      if (isset($_GET['success'])) {
                          \Session::put('success', $_GET['success']);
                      }
                      @endphp
                        <div class="col-md-12">
                            @include('includes.alerts')
                        </div>
                      <div class="col-md-12" style="padding:0;">
                        <div class="card card-timeline shadow-none">
                          <ul class="bs4-order-tracking">
                              <li class="step active">
                                  <div><i class="fas fa-cog"></i></div> Proccessing
                              </li>
                              <li class="step">
                                  <div><i class="fas fa-cube"></i></div> Pack
                              </li>
                              <li class="step">
                                  <div><i class="fas fa-truck-moving"></i></div> On the way
                              </li>
                              <li class="step">
                                <div><i class="fas fa-check-circle"></i></div> Delivered
                            </li>
                            
                          </ul>
                        </div>
                    </div>
                    <a href="{{url('/')}}" class="mx-auto">Continue shopping</a>
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

