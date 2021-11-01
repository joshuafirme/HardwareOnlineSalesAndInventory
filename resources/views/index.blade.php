@php
  $page_title =  "Val Construction Supply";
@endphp

@include('header')

  <!-- Navbar -->
 @include('nav')
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div ></div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content" style="margin-top: -38px">
      <div class="container">
        <div class="row" style="background-color: #C47A4A">

            <div class="col-md-12 col-lg-3 mt-5 p-3">
                <h4 class="text-light">Exclusive Sales</h4>
                <h3 class="text-light">POWER TOOL AND
                    ACCESORIES
                    UP TO 50% OFF</h3>
            </div>
            <div class="col-md-12 col-lg-9">
                <img class="cover"  src="{{asset('images/tool-g98333b673_1280.jpg')}}">
            </div>
        </div>
        
        <h2 class="text-center mt-4 text-dark">Best Selling Products</h2>

        <div class="row" id="product-container"></div>
        
        <div class="loader-container">
            <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>

        <div class="row mt-5">
            <div class="col-sm-12 col-md-6 mb-5"><img class="img-rounded"  src="{{asset('images/bigsale.jpg')}}"></div>
            <div class="col-sm-12 col-md-6"><img class="img-rounded"  src="{{asset('images/fast.jpg')}}"></div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@include('footer')