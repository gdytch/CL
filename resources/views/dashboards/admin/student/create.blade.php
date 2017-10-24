@section('dashboard-content')
<section class="section">

    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" style="height: 708px;">
                <div class="title-block">
                    <h1>Add Student </h1>
                </div>
                <form role="form" action="{{route('student.store')}}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class=" col-md-2" style="text-align: right">
                        <img src="{{asset('storage/avatar/default-avatar.png')}}" alt="" id="avatar" class="student_avatar">
                        <input type="file" name="avatar_file" value="" onchange="readURL(this);" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <label class="control-label col-md-4">First Name</label>
                            <input name="fname" type="text" class="form-control underlined" required="" value="{{ old('fname') }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Last Name</label>
                            <input name="lname" type="text" class="form-control underlined" required=""value="{{ old('lname') }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Password</label>
                            <input name="password" type="password" class="form-control underlined" required="" value="{{ old('password') }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Section</label>

                            <select class="form-control " name="section" required="">
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}" @if(old('section') == $section->id) selected @endif>{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                </div>
                <div class="form-group">
                    <a href="{{route('student.index')}}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
function readURL(input) {
   if (input.files && input.files[0]) {
       var reader = new FileReader();

       reader.onload = function (e) {
           $('#avatar')
               .attr('src', e.target.result)
       };

       reader.readAsDataURL(input.files[0]);
   }
}
</script>
@endsection
