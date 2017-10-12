<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Computer Class </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    {{-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> --}}
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="{{asset('css/vendor.min.css')}}">
    <!-- Theme initialization -->

    @if(!isset(Auth::user()->theme) || Auth::user()->theme == null)
        <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    @else
        <link rel="stylesheet" href='{{asset('css/_themes/'.$student->theme.'-theme.min.css')}}'>
    @endif

    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/mycss.css')}}">

</head>
