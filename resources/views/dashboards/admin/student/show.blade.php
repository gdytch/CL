@section('dashboard-content')
<section class="section">
    <div class="row ">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h1>Student  <button data-toggle="modal" data-target="#editmodal" class="btn btn-secondary" style="float:right">Edit</button></h1>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class=" col-md-2" style="">
                            <img src="{{asset('storage/avatar/'.$student->avatar)}}" alt="" class="student_avatar">
                        </div>
                        <div class="col" style="margin-left: 20px">
                            <h6 class="text-primary"><small><strong>Firstname</strong></small></h6>
                            <h4>{{$student->fname}}</h4>
                            <h6 class="text-primary"><small><strong>Lastname</strong></small></h6>
                            <h4>{{$student->lname}}</h4>
                            <h6 class="text-primary"><small><strong>Section</strong></small></h6>
                            <h4>{{$student->sectionTo->name}}</h4>
                            <a href="{{route('student.folder',$student->id)}}" class="btn btn-primary">OPEN FOLDER</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col col-md-12 col-12">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h4>Activities</h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-12">
                            @if($table_item != null)
                                <table class="table table-striped table-responsive">
                                    <thead>
                                        <th>Activity</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Submitted</th>
                                        <th>Date Submitted</th>
                                        <th>Files</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($table_item as $activity)
                                            <tr>
                                                <td>{{$activity->name}}</td>
                                                <td>{{$activity->description}}</td>
                                                <td>{{$activity->date}}</td>
                                                <td>

                                                    @if($activity->submitted)
                                                        <span class="green"><i class="fa fa-check"></i> <b>Yes</b></span>
                                                    @else
                                                        <span class="red"><i class="fa fa-close"></i> <b>No</b></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($activity->submitted)
                                                        @foreach ($activity->files as $result)
                                                            {{$result->date_submitted}}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($activity->submitted)
                                                        @foreach ($activity->files as $result)
                                                            {{$result->filename}}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    No Record
                                @endif

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('student.update',$student->id)}}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class=" col-md-4" style="text-align: right">
                        <img src="{{asset('storage/avatar/'.$student->avatar)}}" alt="" id="avatar" class="student_avatar">
                        <input type="file" name="avatar_file" value="" onchange="readURL(this);" class="form-control">
                    </div>
                    <div class="col-md-8">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <label class="control-label col-md-4">First Name</label>
                            <input name="fname" type="text" class="form-control underlined" required="" value="{{$student->fname}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Last Name</label>
                            <input name="lname" type="text" class="form-control underlined" required="" value="{{$student->lname}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Section</label>

                            <select class="form-control" name="section" required="">
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}" @if($section->id == $student->section) selected @endif>{{$section->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-dismiss="modal" data-target="#passwordModal">
                                    Change password
                                </button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-dismiss="modal" data-target="#deleteModal">
                                    Delete
                                </button>
                            </div>
                            <input type="hidden" name="_method" value="PUT">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
             </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" action="{{route('student.update.password', $student->id)}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label col-md-4">New Password</label>
                        <input name="password" type="password" class="form-control underlined" required="">
                    </div>
                    <div class="form-group">
                    <label class="control-label col-md-4">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="form-control underlined" required="" Validate>
                    </div>
                    <input type="hidden" name="_method" value="PUT">
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this account?
            </div>
            <div class="modal-footer">
                <form class="" action="{{route('student.destroy', $student->id)}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
