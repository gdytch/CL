@extends('layouts.app')
@section('content')
    @include('inc.navbar')
    @include('inc.sidebar')
    <article class="content dashboard-page">
        @include($dashboard_content)
        @yield('dashboard-content')
    </article>
    {{-- @include('inc.footer') --}}


@endsection
