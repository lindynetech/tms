@if (Auth::check())
<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="header"><center><b>Main Menu</b></center></li>
      <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> <span><b>DASHBOARD</b></span></a></li>
      <li class="treeview active">
        <a href="#">
          <i class="fa fa-tasks"></i>
          <span><b>GOALS</b></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('/')}}/dailygoals"><i class="fa fa-caret-right"></i> <b>Daily Goals</b></a></li>
          <li><a href="{{url('/')}}/goals/eatfrog"><i class="fa fa-caret-right"></i> <b>Eat That Frog</b></a></li>
          <li><a href="{{url('/')}}/goals"><i class="fa fa-caret-right"></i> <b>All Goals</b></a></li>
        </ul>
      </li>
      <li class="treeview active">
        <a href="#">
          <i class="fa fa-book"></i>
          <span><b>SELF-DEVELOPMENT</b></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="/habits"><i class="fa fa-caret-right"></i> <b>Habits</b></a></li>
          <li><a href="/mindstorm"><i class="fa fa-caret-right"></i> <b>Mindstorming</b></a></li>
          <li><a href="/readinglist"><i class="fa fa-caret-right"></i> <b>Reading List</b></a></li>
        </ul>
      </li>
      <li><a href="{{url('/help')}}"><i class="fa fa-question"></i> <span><b>HELP</b></span></a></li>
      <li class="treeview active">
        <a href="#">
          <i class="fa fa-cog"></i> <span><b>MANAGE</b></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="/vendors"><i class="fa fa-caret-right"></i> <b>Vendors</b></a></li>
          <li><a href="/profile" ><i class="fa fa-caret-right"></i> <b>My Account</b></a></li>
          <li><a href="/logout" ><i class="fa fa-caret-right"></i> <b>Logout</b></a></li>
        </ul>
      </li>
    </ul>
  </section>
</aside>

@endif
