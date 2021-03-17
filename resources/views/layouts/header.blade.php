<header class="main-header">
  <div class="container-fluid">
    <nav class="navbar p-0">
      <a class="navbar-brand" href="javascript: void(0)"><img src="{{asset('assets/images/Chela One 1-5.png')}}" class="site-main-logo" alt=""></a>
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
      <li><a href="{{route('freelance-profile-account')}}">
      {{--<li><a href="{{route('account.edit', ['account' => loginId()])}}">--}}
          <span class="header-avtar">
             @if(!empty(\Auth::user()->profile_pic_upload))
              <img class="rounded-circle" src="{{asset(getLoginUserImage())}}" alt="">
            @else
              <img src="{{asset('assets/images/profile-pic.png')}}" alt="profile-pic.png">
            @endif
          </span>
          Account</a>

      </li>
      <li><a href="{{url('home')}}">
          Home</a>
      </li>
      <li><a href="{{url('schedule')}}">
          Schedule</a>
      </li>
      <li><a href="{{url('clients')}}">
          Bookings</a>
      </li>
      <li>
          @if(isLightVersion())
              <a href="{{route('plans.index', ['type' => 'onedayplan'])}}">Programs</a>
          @else
              <a href="{{url('plans')}}">Programs</a>
          @endif
      </li>
        @if(!isLightVersion())
          <li><a href="{{url('earnings')}}"> Earnings </a></li>
          <li><a  href="{{url('settings')}}"> Settings</a></li>
        @endif
    </ul>
  </div>

</div>
<script>
  $(document).ready(function() {
    $('#program_database').click(function() {
      if ($('.child_menu').hasClass('open')) {
        setTimeout(function() {
          $('body .child_menu').removeClass('open');
        }, 1);
      }
    });
  });
</script>
<!-- /sidebar menu -->
