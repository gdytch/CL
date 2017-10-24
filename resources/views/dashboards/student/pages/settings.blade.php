@section('dashboard-content')
    <section class="section">
        <div class="row sameheight-container">
            <div class="col-sm-12 col-xs-12 col-md-6 col-xl-6">
                <div class="card sameheight-item">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary"> Password</h4>
                            <hr>
                        </div>
                        <div class="col">
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
                                        <input type="hidden" name="_method" value="put">
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary" >Change Password</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary">Theme</h4>
                            <hr>
                        </div>
                        <div class="col col-md-12 col-12">
                            <div class="customize-item">
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=red')}}" style="background: #FB494D; border-color: #FB494D; color: #fff;">  </a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=orange')}}" style="background-color: #FE7A0E;border-color: #FE7A0E; color: #fff;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=green')}}" style="background-color: #8CDE33;border-color: #8CDE33; color: #555;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=seagreen')}}" style="background-color: #4bcf99;border-color: #4bcf99; color: #fff;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=blue')}}" style="background-color: #52BCD3;border-color: #52BCD3; color: #fff;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=purple')}}" style="background-color: #7867A7;border-color: #7867A7; color: #fff;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=turquoise')}}" style="background-color: #1abc9c;border-color: #1abc9c;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=red2')}}" style="background-color: #F44336;border-color: #F44336;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=sunflower')}}" style="background-color: #f1c40f;border-color: #f1c40f;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=pink')}}" style="background-color: #E91E63;border-color: #E91E63;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=bright-purple')}}" style="background-color: #9C27B0;border-color: #9C27B0;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=blue2')}}" style="background-color: #2196F3;border-color: #2196F3;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=cyan')}}" style="background-color: #00BCD4;border-color: #00BCD4;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=teal')}}" style="background-color: #009688;border-color: #009688;"></a>
                                <a class="btn btn-primary theme-item" href="{{url('home/theme?theme=blue-grey')}}" style="background-color: #607D8B;border-color: #607D8B;"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </section>

@endsection
