@section('dashboard-content')
<section class="section">
    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" style="height: 708px;">
                <div class="title-block">
                    <h1 class="title">Add Student </h1>
                </div>
                <form role="form" action="{{route('student.store')}}" method="POST">
                    <div class="form-group" >
                        {{csrf_field()}}
                        <label class="control-label col-md-4">First Name</label>
                        <input name="fname" type="text" class="form-control underlined" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Last Name</label>
                        <input name="lname" type="text" class="form-control underlined" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Password</label>
                        <input name="password" type="password" class="form-control underlined" required="">
                    </div>
                    <div class="form-group">
                        <select class="form-control col-sm-2" name="section" required="">
                            @foreach ($sections as $section)
                                <option value="{{$section->id}}">{{$section->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
