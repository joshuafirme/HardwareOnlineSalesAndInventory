

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <main class="d-flex align-items-center py-3 py-md-0">
      <div class="container">
        <div class="row">
          
          <div class="col-sm-12 col-md-6">
            <small><a style="color: #FFF;" target="_blank" href="{{ url('/terms-and-condition') }}">Terms and condition</a></small>
          </div>
          <div class="col-sm-12 col-md-6">
            <small><a style="color: #FFF;" target="_blank" href="{{ url('/privacy-policy') }}">Privacy Policy</a></small>
          </div>
          <div class="col-sm-12 col-md-6">
            <small><a style="color: #FFF;" target="_blank" href="{{ url('/return-and-cancellation-policy') }}">Return and Cancellation Policy</a></small>
          </div>
          <div class="col-sm-12 col-md-6">
            <small><a style="color: #FFF;" target="_blank" href="{{ url('/terms-and-condition') }}">About us</a></small>
          </div>
          <div class="col-sm-12 col-md-6">
            <small><a style="color: #FFF;" target="_blank" href="{{ url('/we-deliver') }}">We deliver in your Area!</a></small>
          </div>
          
          <div class="col-sm-12 col-md-6">
            <small><a style="color: #FFF;" target="_blank" href="{{ url('/terms-and-condition') }}">Contact us</a></small>
          </div>
          <div class="col-sm-12 col-md-6">
            <small><strong>Copyright &copy; 2021 Val Construction Supply</strong></small>
          </div>
        </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{asset('js/homepage.js')}}"></script>

@if(strpos($page_title,"Login") != "")
  <script src="{{asset('js/login.js')}}"></script>
@endif

@include('scripts._global')

</body>
</html>