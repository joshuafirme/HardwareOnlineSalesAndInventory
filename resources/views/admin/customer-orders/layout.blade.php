
@include('admin.header')

@include('admin.nav')

<style>
  @media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden; page-break-after: avoid !important;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position: absolute;
    left: 0;
    top: 0;
    right: 0; 
    margin-left: auto; 
    margin-right: auto; 
  }
}


/* style sheet for "A4" printing */
@media print and (width: 21cm) and (height: 29.7cm) {
     @page {
        margin: 3cm;
     }
}

/* style sheet for "letter" printing */
@media print and (width: 8.5in) and (height: 11in) {
    @page {
        margin: 1in;
    }
}

/* A4 Landscape*/
@page {
    size: A4 landscape;
    margin: 0;
}
@page {  }
</style>

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
@include('admin.customer-orders.modals')
@include('admin.scripts')
@include('admin.datatables-scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8wVIr_ne8CDZ_NM_9RPkL5nBUa7TlVms&callback=initMap&v=weekly&channel=2" async></script>
<script src="{{asset('js/customer_orders.js')}}"></script>

</body>
</html>
