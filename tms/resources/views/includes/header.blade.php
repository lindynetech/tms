<header class="main-header">
  <!-- Logo -->
  <a href="{{url('/')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>TMS</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>TMS</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <i class="fa fa-arrow-left"></i><i class="fa fa-arrow-right"></i>
      
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
         <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-calendar"></i>
            <span class="hidden-xs"><b>Today: </b><?php echo date("Y-m-d"); ?></span>
          </a>
          <ul class="dropdown-menu" style="width: 220px !important;">
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
              <div id="calendar"></div>
              </div>
            </li>
          </ul>
        </li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-user"></i>
            @if (Auth::check())
            <span class="hidden-xs">{{auth()->user()->name}}</span>
            @endif
          </a>
          <ul class="dropdown-menu" style="width: 180px !important;">
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
              <a href="{{url('/profile')}}" class="btn btn-default btn-flat">Profile</a>
                <a href="{{url('/logout')}}" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog"></i></a> -->
        </li>
      </ul>
    </div>
  </nav>
</header>
