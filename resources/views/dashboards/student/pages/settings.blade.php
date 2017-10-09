@section('dashboard-content')
    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                <div class="card sameheight-item">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="title">Password</h4>
                            <hr>
                        </div>
                        <div class="col col-md-6 col-6 col-sm-6">
                                <form class="form" action="{{route('update.password', $student->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Current Password</label>
                                        <input name="old_password" type="password" class="form-control underlined" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">New Password</label>
                                        <input name="password" type="password" class="form-control underlined" required="">
                                        <label class="control-label col-md-4">Confirm Password</label>
                                        <input name="password_confirmation" type="password" class="form-control underlined" required="" Validate>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary" >Change Password</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </section>

@endsection
