
@include('admin.header')

@include('admin.nav')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @yield('content')
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2021 Val Construction Supply.</strong>
    All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

@include('admin.scripts')
@include('admin.datatables-scripts')

@if(strpos($page_title,"Sales") != "")

  <script src="{{asset('js/sales_report.js')}}"></script>

@elseif(strpos($page_title,"Adjustment") != "")

  <script src="{{asset('js/stock_adjustment_report.js')}}"></script>

@elseif(strpos($page_title,"Inventory") != "")

  <script src="{{asset('js/inventory_report.js')}}"></script>

@elseif(strpos($page_title,"Purchased") != "")

  <script src="{{asset('js/purchased_order_report.js')}}"></script>
  
@endif

</body>
</html>
