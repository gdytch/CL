<header class="header">
    <div class="header-block header-block-collapse d-lg-none d-xl-none">
        <button class="collapse-btn" id="sidebar-collapse-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>

    <div class="header-block header-block-nav">
        <ul class="nav-profile">

            <li class="profile">
                <a class="nav-link" @if(Auth::guard('web')->check()) href="{{route('student.profile')}}" @else href="#" @endif alt="Profile">
                     <img src="{{asset('storage/avatar/'.Auth::user()->avatar)}}" alt="" class="img">
                    <span class=""> <strong> {{Auth::user()->fname}} {{  Auth::user()->lname}} </strong> </span>
                </a>

            </li>
            <li>
                @if(Auth::guard('web')->check())<h6 style="margin: 20px"><strong>{{Auth::user()->sectionTo->name}}</strong></h6>@endif

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
