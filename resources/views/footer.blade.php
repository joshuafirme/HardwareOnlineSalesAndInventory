

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <main class="d-flex align-items-center py-3 py-md-0">
      <div class="container">
        <!-- Default to the left -->
        <strong>Copyright &copy; 2021 Val Construction Supply</strong> All rights reserved.
      </div>
    </main>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

<script src="{{asset('js/homepage.js')}}"></script>

@if(strpos($page_title,"Login") != "")
  <script src="{{asset('js/login.js')}}"></script>
@endif


</body>
</html>