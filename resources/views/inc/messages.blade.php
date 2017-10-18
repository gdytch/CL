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
        offset: 45,

    });
    </script>
@endif
