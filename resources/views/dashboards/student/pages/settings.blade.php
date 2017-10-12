@section('dashboard-content')
    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-6 col-sm-6 col-md-6 col-xl-6">
                <div class="card sameheight-item">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary"> Password</h4>
                            <hr>
                        </div>
                        <div class="col col-md-6 col-6 col-sm-6">
                                <form class="form" action="{{route('update.password', $student->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="control-label col">Current Password</label>
                                        <input name="old_password" type="password" class="form-control underlined" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col">New Password</label>
                                        <input name="password" type="password" class="form-control underlined" required="">
                                        <label class="control-label col">Confirm Password</label>
                                        <input name="password_confirmation" type="password" class="form-control underlined" required="" Validate>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary" >Change Password</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-6 col-6">
                <div class="card">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary">Theme</h4>
                            <hr>
                        </div>
                        <div class="col col-md-12 col-12">
                            <div class="customize-item">
                                        <a class="btn btn-primary" href="{{url('home/theme?id='.$student->id.'&theme=red')}}" style="background: #FB494D; border-color: #FB494D; color: #fff;"> Red </a>
                                        <a class="btn btn-primary" href="{{url('home/theme?id='.$student->id.'&theme=orange')}}" style="background-color: #FE7A0E;border-color: #FE7A0E; color: #fff;">Orange</a>
                                        <a class="btn btn-primary" href="{{url('home/theme?id='.$student->id.'&theme=green')}}" style="background-color: #8CDE33;border-color: #8CDE33; color: #555;">Green</a>
                                        <a class="btn btn-primary" href="{{url('home/theme?id='.$student->id.'&theme=seagreen')}}" style="background-color: #4bcf99;border-color: #4bcf99; color: #fff;">Seagreen</a>
                                        <a class="btn btn-primary" href="{{url('home/theme?id='.$student->id.'&theme=blue')}}" style="background-color: #52BCD3;border-color: #52BCD3; color: #fff;">Blue</a>
                                        <a class="btn btn-primary" href="{{url('home/theme?id='.$student->id.'&theme=purple')}}" style="background-color: #7867A7;border-color: #7867A7; color: #fff;">Purple</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </section>

@endsection
