@if(isset($errors) && count($errors) > 0)
    @foreach ($errors->all() as $error)
        <script type="text/javascript">
            $.notify({
            message: "{{$error}}"
        },{
            type: 'danger',
            allow_dismiss: true,
            placement: {
                from: "top",
                align: "center"
            },
            delay: 15000,
            offset: 45,

        });
        </script>
    @endforeach
@endif

@if(session('success'))
    <script type="text/javascript">
        $.notify({
        message: "{{session('success')}}"
    },{
        type: 'success',
        allow_dismiss: true,
        placement: {
    		from: "top",
    		align: "center"
        },
        delay: 15000,
        offset: 45,
    });
    </script>
@endif
@if(session('error'))
    <script type="text/javascript">
        $.notify({
        message: "{{session('error')}}"
    },{
        type: 'danger',
        allow_dismiss: true,
        placement: {
            from: "top",
            align: "center"
        },
        delay: 15000,
        offset: 45,

    });
    </script>
@endif

@if(isset($message) && count($message) > 0)
    <script type="text/javascript">
        $.notify({
        message: "{{$message}}"
    },{
        type: 'success',
        allow_dismiss: true,
        placement: {
    		from: "top",
    		align: "center"
        },
        delay: 15000,
        offset: 45,
    });
    </script>
@endif

@if(isset($messages) && count($messages) > 0)
    @foreach ($messages as $message)
        <script type="text/javascript">
            $.notify({
            message: "{!!$message!!}"
        },{
            type: 'success',
            allow_dismiss: true,
            placement: {
        		from: "top",
        		align: "center"
            },
            delay: 15000,
            offset: 45,
        });
        </script>
    @endforeach
@endif

@if(isset($message_info) && count($message_info) > 0)
        <script type="text/javascript">
        $.notify({
            message: "{!!$message_info!!}"
        },{
            type: 'info',
            allow_dismiss: true,
            placement: {
                from: "top",
                align: "center"
            },
            delay: 15000,
            offset: 45,
        });
        </script>
@endif

@if(isset($message_infos) && count($message_infos) != 0)
    @foreach ($message_infos as $message)
        <script type="text/javascript">
        $.notify({
            message: "{!!$message!!}"
        },{
            type: 'info',
            allow_dismiss: true,
            placement: {
                from: "top",
                align: "center"
            },
            delay: 15000,
            offset: 45,
        });
        </script>
    @endforeach
@endif

@if(isset($message_info_per) && count($message_info_per) > 0)
        <script type="text/javascript">
        $.notify({
            message: "{!!$message_info_per!!}"
        },{
            type: 'info',
            allow_dismiss: false,
            placement: {
                from: "top",
                align: "center"
            },
            offset: 45,
            delay: 60000,
        });
        </script>
@endif
