<!doctype html>
<html class="no-js" lang="en">
    <head>
        @include('inc.header')
        <script type="text/javascript" src="{{asset('js/viewer.min.js')}}"></script>

        <!-- Reference block for JS -->
        <div class="ref" id="ref">
           <div class="color-primary"></div>
           <div class="chart">
               <div class="color-primary"></div>
               <div class="color-secondary"></div>
           </div>
        </div>
        {{-- <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script> --}}
        {{-- <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script> --}}
        {{-- <script type="text/javascript" src="{{asset('js/bootstrap-confirmation.min.js')}}"></script> --}}
        {{-- <script type="text/javascript" src="{{asset('js/quill.min.js')}}"></script> --}}
        <script type="text/javascript" src="{{asset('js/vendor.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>

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
