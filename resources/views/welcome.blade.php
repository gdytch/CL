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
                            <p class="text-center" id="formTitle">ENTER YOUR LASTNAME TO CONTINUE</p>
                            <form id="login-form-checkusers"  action="#" method="post" >
                                <div class="form-group">
                                    <label for="lname">Last name</label>
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" class="form-control underlined" name="lname" id="lname" placeholder="Your Lastname" required autofocus autocomplete="off">
                                            <div class="invalid-feedback" id="lnameFeedback">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" id="checkUsersButton" class="btn btn-block btn-primary"><i class="fa fa-search"></i></button>

                                        </div>
                                    </div>

                                </div>

                            </form>

                            <form class="form-horizontal hidden" id="login-form-users" method="POST" action="#">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label">Accounts</label>
                                    <div id="userList">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control underlined" name="password" id="password" placeholder="Your password" required >
                                </div>

                                <div class="form-group">
                                    <button type="button" id="loginButton" class="btn btn-block btn-primary">Login</button>
                                </div>

                            </form>
                            <div style="height:64px">
                                <div class="col hidden" id="progressBar">
                                    <center><div class="lds-ring"><div></div><div></div><div></div><div></div></div></center>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

<script src="{{asset('js/pagejs/welcome.js')}}" charset="utf-8"></script>

@endsection
