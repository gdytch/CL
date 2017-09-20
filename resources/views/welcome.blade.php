@extends('layouts.app')
@section('content')
    <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title">
                            <div class="logo">
                                <span class="l l1"></span>
                                <span class="l l2"></span>
                                <span class="l l3"></span>
                                <span class="l l4"></span>
                                <span class="l l5"></span>
                            </div> Computer Class </h1>
                    </header>
                    <div class="auth-content">
                        <p class="text-center">ENTER YOUR LASTNAME TO CONTINUE</p>
                        <form id="login-form" action="{{route('checkUser')}}" method="GET" novalidate="">
                            <div class="form-group">
                                <label for="lname">Lastname</label>
                                <input type="text" class="form-control underlined" name="lname" id="lname" placeholder="Your Lastname" required> </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">Continue</button>
                            </div>

                        </form>
                    </div>
                </div>
                @include('inc.messages')

            </div>
        </div>

@endsection
