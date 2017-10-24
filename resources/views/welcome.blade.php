@extends('layouts.app')
@section('content')
    <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title">
                            <div class="logo">
                            <i class="fa fa-desktop"></i>
                            </div> Computer Class </h1>
                    </header>
                    <div class="auth-content">
                        <p class="text-center">ENTER YOUR LASTNAME TO CONTINUE</p>
                        <form id="login-form" action="{{url('checkUser')}}" method="GET" novalidate="">
                            <div class="form-group">
                                <label for="lname">Last name</label>
                                <input type="text" class="form-control underlined" name="lname" id="lname" placeholder="Your Lastname" required autofocus autocomplete="off">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">Continue</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

@endsection
