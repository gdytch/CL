
<script type="text/javascript" src="{{asset('js/vendor.js')}}"></script>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
{{-- <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script> --}}
{{-- <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script> --}}
<script type="text/javascript" src="{{asset('js/datatables.min.js')}}"></script>
{{-- <script type="text/javascript" src="{{asset('js/bootstrap-confirmation.min.js')}}"></script> --}}

<script type="text/javascript">

    $(document).ready(function(){
        $('#StudentTable').dataTable(
            {
            "order": [],
            "columnDefs": [
             { "orderable": false, "targets": "nosort" }
             ]

        }
        );
       $('#DataTable').DataTable(
           {
           "columnDefs": [
            { "orderable": false, "targets": "nosort" }

            ]
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
