
<script type="text/javascript" src="{{asset('js/vendor.js')}}"></script>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
{{-- <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script> --}}

<script type="text/javascript" src="{{asset('js/datatables.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function(){
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

</script>
