  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links 
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
-->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
   
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ Auth::user()->name }}</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
          <li><a href="{{url('/admin/logout')}}" class="dropdown-item">Logout </a></li>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4"  style="background-color: #06513D;">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="font-size: 16px;">Val Construction Supply</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) 
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>-->

      <!-- 
      **ACCESS LEVELS**
        Sales Clerk = 1
        Inventory Clerk = 2
        Owner = 3
        Administrator = 4
      -->
      @php
          $access_level = Auth::user()->access_level;
      @endphp
      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          @if(in_array($access_level, array( 3, 4)))
          <li class="nav-item">
            <a href="{{ url('/dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
          </li>
          @endif

          @if(in_array($access_level, array( 1, 3, 4 )))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Sales
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/cashiering')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cashiering</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/boxed.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Search</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(in_array($access_level, array( 3, 4 )))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Online Transaction
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/customer-orders') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/verify-customer')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Verify Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notification</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
        
          @if(in_array($access_level, array( 2, 3, 4 )))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cube"></i>
              <p>
                Inventory
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/stock-adjustment') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stock Adjustment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/purchase-order') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/supplier-delivery') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier Delivery</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/product-return') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Return</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Reports
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              @if(in_array($access_level, array( 1, 3, 4 )))
              <li class="nav-item">
                <a href="{{url('/reports/sales')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Report</p>
                </a>
              </li>
              @endif

              @if(in_array($access_level, array( 2, 3, 4 )))
              <li class="nav-item">
                <a href="{{url('/reports/inventory')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inventory Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/reports/stock-adjustment')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stock Adjustment Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/reports/purchased-order')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchased Order Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/reports/supplier-delivery')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier Delivery Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/reports/reorder')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reorder List Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/reports/product-return')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Return Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/reports/stock-adjustment')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fast and Slow Moving Report</p>
                </a>
              </li>
              @endif

            </ul>
          </li>

          @if(in_array($access_level, array( 2, 3, 4 )))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                File Maintenance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/product') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/supplier') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/category') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/unit') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Unit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/delivery_area') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivery Area</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          
          @if(in_array($access_level, array( 3, 4 )))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Utilities
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('users') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Maintenance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Audit Trail</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Feedback Maintenance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Archive</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>