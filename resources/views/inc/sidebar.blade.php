<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                <div class="logo">
                    <i class="fa fa-desktop text-primary"></i>
                </div> ComputerClass </div>
        </div>
        <nav class="menu">
            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                <li {{ (Route::is('admin') ? 'class=active' : '') }}>
                    <a href="{{route('admin')}}">
                        <i class="fa fa-home"></i> Dashboard </a>
                </li>
                <li {{ (Route::is('student.index','student.show','student.edit','student.create') ? 'class=active' : '') }}>
                    <a href="{{route('student.index')}}">
                        <i class="fa fa-user"></i> Student Manager </a>
                </li>
                 <li {{ (Route::is('section.index','section.create','section.edit','section.show') ? 'class=active' : '') }}>
                    <a href="{{route('section.index')}}">
                        <i class="fa fa-group"></i> Section Manager </a>
                </li>
                <li {{ (Route::is('activity.index','activity.create','activity.edit','activity.show') ? 'class=active' : '') }}>
                   <a href="{{route('activity.index')}}">
                       <i class="fa fa-book"></i> Activity Manager </a>
               </li>
               <li {{ (Route::is('post.index','post.create','post.edit','post.show') ? 'class=active' : '') }}>
                  <a href="{{route('post.index')}}">
                      <i class="fa fa-edit"></i> Posts Manager </a>
              </li>
              <li {{ (Route::is('exam.index', 'exam_paper.show', 'exam.show', 'exam.show.student') ? 'class=active' : '') }}>
                 <a href="{{route('exam.index')}}">
                     <i class="fa fa-file-text-o"></i> Exam manager </a>
             </li>
               <li {{ (Route::is('admin.settings') ? 'class=active' : '') }}>
                  <a href="{{route('admin.settings')}}">
                      <i class="fa fa-gear"></i> Settings </a>
              </li>
            </ul>
        </nav>
    </div>
    {{-- <footer class="sidebar-footer">
        <ul class="sidebar-menu metismenu" id="customize-menu">
            <li>
                <ul>
                    <li class="customize">
                        <div class="customize-item">
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
                                        <input class="radio" type="radio" name="sidebarPosition" value="sidebar-fixed">
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
                                        <input class="radio" type="radio" name="headerPosition" value="">
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
                                        <input class="radio" type="radio" name="footerPosition" value="footer-fixed">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="footerPosition" value="">
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
