<header class="main-header">
  <div class="container-fluid">
    <nav class="navbar p-0">
      <a class="navbar-brand" href=""><img src="{{asset('assets/images/Chela One 1-5.png')}}" class="site-main-logo" alt=""></a>
      <div class="nav-right ml-auto">
        <div class="logout-drp dropdown">
          <a class="dropdown-toggle logout-drp-link" href="#" id="logoutDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <strong><i class="fas fa-user mr-2"></i>{{loginName()}}</strong>
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="logoutDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
              Logout
            </a>
            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <ul class="nav side-menu">
      <li><a href="{{route('admin.edit', ['admin' => loginId()])}}">
          <span class="header-avtar">
            <img src="{{asset('assets/images/profile-pic.png')}}" alt="">
          </span>
          Account</a>
      </li>

    <li><a href="{{url('freelance-specialists')}}">
        Partners</a>
    </li>

    <li><a href="{{url('bookings')}}">
        Bookings</a>
    </li>

    <li><a href="{{url('admin-schedule')}}">
        Schedule</a>
    </li>

    <li><a href="{{url('database')}}">
        Database</a>
    </li>
        <li><a href="{{url('client-earnings')}}">
            Earnings</a>
        </li>
    <li><a href="{{url('endusers')}}">
        End users</a>
    </li>

    <li><a href="{{url('reviews')}}">
        Reviews</a>
    </li>

    </ul>
  </div>

</div>
<!-- /sidebar menu -->
