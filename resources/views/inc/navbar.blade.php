<header class="header">
    <div class="header-block header-block-collapse d-lg-none d-xl-none">
        <button class="collapse-btn" id="sidebar-collapse-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <div class="header-block header-block-search">

    </div>
    <div class="header-block header-block-buttons">
        <p class="btn btn-sm header-btn" id="datetime">
            {{-- <i class="fa fa-calendar-o"></i> @php echo date("M d Y", time()) @endphp &nbsp;
            <i class="fa fa-clock-o"></i> @php echo date("H:i:A", time()) @endphp &nbsp; --}}
        </p>
    </div>
    <div class="header-block header-block-nav">
        <ul class="nav-profile">

            <li class="profile">
                <a class="nav-link" @if(Auth::guard('web')->check()) href="{{route('student.profile')}}" @else href="#" @endif alt="Profile">
                     <img src="{{asset('storage/avatar/'.Auth::user()->avatar)}}" alt="" class="img">
                    <span class="name">  {{Auth::user()->fname}} {{  Auth::user()->lname}}  </span>
                </a>

            </li>
            <li class="profile">
                @if(Auth::guard('web')->check())<h6 style="margin: 20px" class="name">{{Auth::user()->sectionTo->name}}</h6>@endif

            </li>
            <li class="profile">
                <a class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off icon"></i> Logout </a>
                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
            </li>
        </ul>
    </div>

</header>
