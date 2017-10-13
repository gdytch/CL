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
                        <h4>Register Admin</h4>
                        <form class="form-horizontal" method="POST" action="{{ route('admin.store_first') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-12 control-label">Username</label>

                                <div class="col-md-12">
                                    <input id="username" type="text" class="form-control underlined" name="username" value="{{ old('username') }}" required autofocus>
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-12 control-label">Password</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control underlined" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control underlined" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-12 control-label">Firstname</label>

                                <div class="col-md-12">
                                    <input id="username" type="text" class="form-control underlined" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-12 control-label">Lastname</label>

                                <div class="col-md-12">
                                    <input id="username" type="text" class="form-control underlined" name="lname" value="{{ old('lname') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

@endsection
