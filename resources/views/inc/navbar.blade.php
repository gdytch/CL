<header class="header">
    <div class="header-block header-block-collapse d-lg-none d-xl-none">
        <button class="collapse-btn" id="sidebar-collapse-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <div class="header-block">
            @if(Auth::guard('web')->check())<h5 style="margin: 20px">{{Auth::user()->sectionTo->name}}</h5>@endif
    </div>
    <div class="header-block header-block-nav">
        <ul class="nav-profile">

            <li class="profile dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                     <img src="{{asset('storage/avatar/'.Auth::user()->avatar)}}" alt="" class="img">
                    <span class="name"> {{Auth::user()->fname}} {{  Auth::user()->lname}} </span>
                </a>
                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-user icon"></i> Profile </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-gear icon"></i> Settings </a>
                </div>
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
