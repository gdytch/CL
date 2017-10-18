<!doctype html>
<html class="no-js" lang="en">
    <head>
        @include('inc.header')
        @include('inc.scripts')
    </head>
    <body>
        <div class="main-wrapper">
            <div class="app blank ">
                  <article class="content">
                      <div class="error-card global">
                          <div class="error-title-block">
                              <h1 class="error-title">404</h1>
                              <h2 class="error-sub-title"> Sorry, page not found </h2>
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
