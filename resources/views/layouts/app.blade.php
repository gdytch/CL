<!doctype html>
<html class="no-js" lang="en">
    @include('inc.header')
    <body>
        <div class="main-wrapper">
            <div class="app" id="app">
                @yield('content')
            </div>
        </div>


        <!-- Reference block for JS -->
       <div class="ref" id="ref">
           <div class="color-primary"></div>
           <div class="chart">
               <div class="color-primary"></div>
               <div class="color-secondary"></div>
           </div>
       </div>
       @include('inc.scripts')
       @include('inc.messages')
    </body>
</html>
