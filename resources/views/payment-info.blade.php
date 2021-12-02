
@php
$page_title =  "Val Construction Supply | Order Info";
@endphp

@include('header')

<!-- Navbar -->
@include('nav')
<!-- /.navbar -->

<style>
    

.bs4-order-tracking {
    margin-bottom: 30px;
    overflow: hidden;
    color: #878788;
    padding-left: 0px;
    margin-top: 30px
  }
  
  .bs4-order-tracking li {
    list-style-type: none;
    font-size: 13px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400;
    color: #878788;
    text-align: center
  }
  
  .bs4-order-tracking li:first-child:before {
    margin-left: 15px !important;
    padding-left: 11px !important;
    text-align: left !important
  }
  
  .bs4-order-tracking li:last-child:before {
    margin-right: 5px !important;
    padding-right: 11px !important;
    text-align: right !important
  }
  
  .bs4-order-tracking li>div {
    color: #fff;
    width: 29px;
    text-align: center;
    line-height: 29px;
    display: block;
    font-size: 12px;
    background: #878788;
    border-radius: 50%;
    margin: auto
  }
  
  .bs4-order-tracking li:after {
    content: '';
    width: 150%;
    height: 2px;
    background: #878788;
    position: absolute;
    left: 0%;
    right: 0%;
    top: 15px;
    z-index: -1
  }
  
  .bs4-order-tracking li:first-child:after {
    left: 50%
  }
  
  .bs4-order-tracking li:last-child:after {
    left: 0% !important;
    width: 0% !important
  }
  
  .bs4-order-tracking li.active {
    font-weight: bold;
  }
  
  .bs4-order-tracking li.active>div {
    background: #3BC265;
  }
  
  .bs4-order-tracking li.active:after {
    background: #3BC265;
  }
  
  .card-timeline {
    background-color: #fff;
    z-index: 0;
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
                        <div class="card card-timeline">
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

