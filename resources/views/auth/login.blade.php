@extends('layouts.app')

@section('content')
    <style>
        .accounts{
            width: 100%;
            padding-top: 5px;
            margin-bottom: -8px;
            display: block;
        }
        label{
            width: 100%;
        }
        img.login-img{
            width: auto;
            height: 100%;
            margin-right: 20px;
        }
        .radio + span{
            /*border-bottom: 1px solid;*/
        }
        .radio:checked  + div.account-block{
            color: #fff;
            background: #545454;
            border-bottom: 1px solid #999999;
        }

        .radio + span:before {
          content: none;
        }

        .radio:checked + span:before {
          content: none;
        }
        .user-section{
                color: #a7a7a7;
                font-style: italic;
                font-size: 10pt;
                margin: 0px;
        }
        .account-block{
            background: #e6e6e6;
            height: 50px;
            border-bottom: 1px solid;

        }
        .account-block img{
            float: left;
        }
    </style>

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
                            @if(count($users)>1) <p class="text-center">SELECT YOUR ACCOUNT TO CONTINUE</p> @endif
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}


                        <div class="form-group">
                            <label class="control-label">Account</label>
                            @foreach ($users as $user)
                                <div >
                                    <label>
                                        <input class="radio" name="id" type="radio" value="{{$user->id}}" @if(count($users)<2) checked @elseif(old('id') == $user->id) checked @endif @if(!$user->sectionTo->status)disabled @endif>
                                        <div class="account-block">
                                            <img src="{{asset('storage/avatar/'.$user->avatar)}}" class="login-img">
                                            <span class="accounts"> {{$user->lname}}, {{$user->fname}}</span>
                                            <span class="user-section">{{$user->sectionTo->name}} @if(!$user->sectionTo->status)<span style="color:#ff7a7a;"><em>(Closed)</em></span>@endif</p>
                                        </div>
                                    </label>
                                </div>
                            @endforeach

                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                            <input type="password" class="form-control underlined" name="password" id="password" placeholder="Your password" required @if(count($users)<2) autofocus @endif @if(count($users)==1)@if(!$user->sectionTo->status)disabled @endif @endif>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary" @if(count($users)==1)@if(!$user->sectionTo->status)disabled @endif @endif>Login</button>
                        </div>

                    </form>
                    <a href="#" onclick="document.location.reload(true)" class="btn btn-md btn-secondary">Refresh</a> <a href="{{route('welcome')}}" class="btn btn-secondary">Back</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
