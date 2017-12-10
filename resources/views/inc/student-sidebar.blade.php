<style>

@media (max-width: 1920px){
    .sidebar{
        width: 85px;
        text-align: center;
    }
    .sidebar .sidebar-menu>li>a {
        padding: 15px 15px 15px 15px;
        font-size: 8pt;
    }
    .sidebar .sidebar-menu>li>a i {
        margin-right: 0px;
        display: block;
    }
    .logo{
        margin-right: 0px;
    }
    .sidebar-header .brand {
        padding-left: 0px;
        text-align: center;
    }
    .app{
        padding-left: 85px;
        padding-bottom: 75px;
    }
    .header{
        left: 85px;
    }

}
@media (max-width: 1367px){
    body{
        zoom: 90%;
    }
}

@media (max-width: 991px){
    .app{
        padding-left: 0px;
    }
    .header{
        left: 0px;
    }
}
</style>
<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand ">
                <a href="{{route('home')}}" style="text-decoration:none;color: #fff;">
                    <div class="logo">
                        <i class="fa fa-desktop text-primary"></i>
                    </div>
                </a>
            </div>
        </div>
        <nav class="menu">
            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                <li {{ (Route::is('home') ? 'class=active' : '') }}>
                    <a href="{{route('home')}}">
                        <i class="fa fa-home"></i>
                        Home</a>
                </li>
                <li {{ (Route::is('student.activity','student.activity.show') ? 'class=active' : '') }}>
                    <a href="{{route('student.activity')}}">
                        <i class="fa fa-book"></i> Activities </a>
                </li>
                <li {{ (Route::is('student.profile','exam.student.show') ? 'class=active' : '') }}>
                    <a href="{{route('student.profile')}}">
                        <i class="fa fa-user"></i> Profile
                    </a>
                </li>
                <li {{ (Route::is('student.settings') ? 'class=active' : '') }}>
                    <a href="{{route('student.settings')}}">
                        <i class="fa fa-gear"></i> Settings
                    </a>
                </li>
                <li {{ (Route::is('trash') ? 'class=active' : '') }}>
                    <a href="{{route('trash')}}">
                        <i class="fa fa-trash"></i> Trash
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    {{-- <footer class="sidebar-footer">
        <ul class="sidebar-menu metismenu" id="customize-menu">
            <li>
                <ul>
                    <li class="customize">
                        <div class="customize-item" >
                            <div class="row customize-header">
                                <div class="col-4"> </div>
                                <div class="col-4">
                                    <label class="title">fixed</label>
                                </div>
                                <div class="col-4">
                                    <label class="title">static</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="title">Sidebar:</label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="sidebarPosition" value="sidebar-fixed" selected>
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="sidebarPosition" value="">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="title">Header:</label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="headerPosition" value="header-fixed">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="headerPosition" value="" selected>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="title">Footer:</label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="footerPosition" value="footer-fixed" >
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="footerPosition" value="" selected>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="customize-item">
                            <ul class="customize-colors">
                                <li>
                                    <span class="color-item color-red" data-theme="red"></span>
                                </li>
                                <li>
                                    <span class="color-item color-orange" data-theme="orange"></span>
                                </li>
                                <li>
                                    <span class="color-item color-green active" data-theme=""></span>
                                </li>
                                <li>
                                    <span class="color-item color-seagreen" data-theme="seagreen"></span>
                                </li>
                                <li>
                                    <span class="color-item color-blue" data-theme="blue"></span>
                                </li>
                                <li>
                                    <span class="color-item color-purple" data-theme="purple"></span>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <a href="">
                    <i class="fa fa-cog"></i> Customize </a>
            </li>
        </ul>
    </footer> --}}
</aside>
<div class="sidebar-overlay" id="sidebar-overlay"></div>
<div class="sidebar-mobile-menu-handle" id="sidebar-mobile-menu-handle"></div>
<div class="mobile-menu-handle"></div>
