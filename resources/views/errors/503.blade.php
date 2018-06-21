<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('inc.header') @include('inc.scripts')
</head>

<body>
    <div class="main-wrapper">

        <div class="app blank ">

            <article class="content">
                <div class="error-card global">
                            
                            <div class="error-title-block">
                                <h2 class="error-title"><img src="{{asset('img/server.png')}}" alt="" width="200px" height="auto">503</h2>
                                <h2 class="error-sub-title"> <b>Service Unavailable.</b></h2>
                                <p style="text-align:center; color: white"> The server is currently unable to handle the request due to maintenance of the server.</p>
                            </div>
                            <div class="error-container">
                                <br>
                                <a class="btn btn-primary" href="{{URL::previous()}}">
                                    <i class="fa fa-angle-left"></i> Go Home </a>
                            </div>
                </div>
            </article>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
    </div>
</body>

</html>
