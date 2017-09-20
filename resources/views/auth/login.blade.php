@extends('layouts.app')

@section('content')
    <style>
        .accounts{
            width: 100%;
            height: 80px;
            margin-top: 10px;
            background: #e6e6e6;;
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
            border-bottom: 1px solid;
        }
        .radio:checked + span{
            color: #85CE36; 
            border-bottom: 1px solid;
        }
       
        .radio + span:before {
          content: none; 
        }

        .radio:checked + span:before {
          content: none; 
        }
        .user-section{
                color: #a7a7a7;
                position: relative;
                top: -30px;
                left: 102px;
                font-style: italic;
                font-size: 10pt;
                margin: 0px;
        }
    </style>

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
                            @if(count($users)>1) <p class="text-center">SELECT YOUR ACCOUNT TO CONTINUE</p> @endif
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}


                        <div class="form-group">
                            <label class="control-label">Account</label>
                            @foreach ($users as $user)
                                <div >
                                    <label>
                                        <input class="radio" name="id" type="radio" value="{{$user->id}}" @if(count($users)<2) checked @elseif(old('id') == $user->id) checked @endif>
                                        
                                        <span class="accounts"><img src="{{asset('img/'.$user->avatar)}}" class="login-img"> {{$user->lname}}, {{$user->fname}}</span>
                                        <p class="user-section">{{$user->sectionTo->name}}</p>
                                    </label>
                                </div>
                            @endforeach

                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                            <input type="password" class="form-control underlined" name="password" id="password" placeholder="Your password" required @if(count($users)<2) autofocus @endif>
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
