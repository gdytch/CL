
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


</script>
