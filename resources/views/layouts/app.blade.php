<!doctype html>
<html class="no-js" lang="en">
    <head>
        @include('inc.header')
        <script type="text/javascript" src="{{asset('js/viewer.min.js')}}"></script>

    </head>
    <body onload="startTime()">
        <div class="main-wrapper">
            <div class="app fixed-sidebar" id="app">
                @yield('content')
            </div>
        </div>
        @include('inc.scripts')
       @include('inc.messages')
    </body>
</html>
