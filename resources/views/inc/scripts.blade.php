

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
<script type="text/javascript" src="{{asset('js/bootstrap-notify.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/datatables.min.js')}}"></script>

</script>

<script type="text/javascript">

    $(document).ready(function(){
        $('#StudentTable').dataTable(
            {
                "order": [1, 'asc'],
                "columnDefs": [
                 { "orderable": false, "targets": "nosort" }
                 ],
                 "paging": false,
                 "bInfo": false,
                 "autowidth": false,
            }
        );

       $('#DataTable').DataTable(
           {
           "columnDefs": [
            { "orderable": false, "targets": "nosort" }

            ],
            "paging": false,
       });


    });

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
    $(function () {
      $('[data-toggle="popover"]').popover()
    })
    $('.dropdown-toggle').dropdown()

	$(document).ready(function() {
	    $(".files").bind('contextmenu', function(event) {
            if (event.which === 3)
            {
               // prevent right click from being interpreted by the browser:
               event.preventDefault();
            }
	    });

	});

    var viewer = new Viewer(document.getElementById('post'));
    $("img").bind("contextmenu",function(e){return false;});

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }




</script>


@if(Route::is('admin'))
<script type="text/javascript">
  $(function() {

    var $dashboardSalesBreakdownChart = $('#dashboard-storage-breakdown-chart');

    if (!$dashboardSalesBreakdownChart.length) {
      return false;
    }

    function drawSalesChart() {

      $dashboardSalesBreakdownChart.empty();

      Morris.Donut({
        element: 'dashboard-storage-breakdown-chart',
        data: [
          @foreach($stats->section_storage as $value)
            { label: "{!!$value->path!!}", value: {!!$value->percent!!} },
          @endforeach
        ],
        resize: true,
        colors: [
          tinycolor(config.chart.colorPrimary.toString()).lighten(10).toString(),
          tinycolor(config.chart.colorPrimary.toString()).darken(8).toString(),
          config.chart.colorPrimary.toString()
        ],
      });

      var $sameheightContainer = $dashboardSalesBreakdownChart.closest(".sameheight-container");

      setSameHeights($sameheightContainer);
    }

    drawSalesChart();


});

$(document).ready(function(){
    $("#fullscreenButton").on("click", function(){
        $("body").fullScreen(true);
    });
});
</script>
@endif


@if(Route::is('exam_paper.show'))
    <script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#lfm').filemanager('image');
        var viewer = new Viewer(document.getElementById('exam'));

    </script>

@endif

@if(Route::is('section.show'))

    <script type="text/javascript">
    Morris.Bar({
      element: 'morris-bar-chart',
      data: [
        @foreach ($activityStats as $key => $value)
            { y: '{!!$value->activity_name!!}', a: {!!$value->submitted!!}, b: {!!$value->notsubmitted!!} },
        @endforeach

      ],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Submitted', 'Not Submitted'],
      barColors: ['#4bcf99', '#FF4444']
    });
    </script>
@endif



@if(Route::is('activity.show'))
<script type="text/javascript">
  $(function() {

    var $activityStats = $('#activityStats-chart');

    if (!$activityStats.length) {
      return false;
    }

    function drawSalesChart() {

      $activityStats.empty();

      Morris.Donut({
        element: 'activityStats-chart',
        data: [
            { label: "Submitted", value: {!!$activityStats->submitted!!} },
            { label: "Not Submitted", value: {!!$activityStats->notsubmitted!!} },
        ],
        resize: true,
        colors: [
         '#4bcf99', '#FF4444'
        ],
      });

      var $sameheightContainer = $activityStats.closest(".sameheight-container");

      setSameHeights($sameheightContainer);
    }

    drawSalesChart();


});

</script>
@endif
