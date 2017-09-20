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
                        <p class="text-center">ADMIN</p>
                    <form class="form-horizontal" method="POST" action="{{ route('admin.login') }}">
                        {{ csrf_field() }}


                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username">Username</label>
                            <input type="username" class="form-control underlined" name="username" id="username" placeholder="Your username" required value="{{old('username')}}">
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                            <input type="password" class="form-control underlined" name="password" id="password" placeholder="Your password" required >
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Login</button>
                        </div>

                    </form>
                </div>
            </div>
            @include('inc.messages')
        </div>
    </div>
</div>
@endsection
