@section('dashboard-content')
<section class="section">
<style>

    .student_avatar{
        width: 100%;
        border-radius: 12px;
        margin-bottom: 10px;
    }

</style>
    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" style="height: 708px;">
                <div class="title-block">
                    <h1>Add Student </h1>
                </div>
                <form role="form" action="{{route('student.store')}}" method="POST">
                <div class="row">
                    <div class=" col-md-2" style="text-align: right">
                        <img src="{{asset('img/default-avatar.png')}}" alt="" class="student_avatar">
                        <a href="#" class="btn btn-info" style="width: 100%; ">Select Avatar</a>
                    </div>
                    <div class="col-md-6">
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
                            <label class="control-label col-md-4">Section</label>

                            <select class="form-control " name="section" required="">
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    <a href="{{URL::previous()}}" class="btn btn-warning">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
