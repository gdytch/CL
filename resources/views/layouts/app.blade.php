<!doctype html>
<html class="no-js" lang="en">
    <head>
        @include('inc.header')
        @include('inc.scripts')
    </head>
    <body>
        <div class="main-wrapper">
            <div class="app fixed-sidebar" id="app">
                @yield('content')
            </div>
        </div>



       @include('inc.messages')
    </body>
</html>
