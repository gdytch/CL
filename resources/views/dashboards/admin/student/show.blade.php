@section('dashboard-content')
{{ Breadcrumbs::render('student.show', $student)}}
<section class="section">
    <div class="row ">
        <div class="col-3">
            <div class="col col-12 ">
            <div class="sameheight-item">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h4 class="card-title text-primary">Student</h4>
                        <button data-toggle="modal" data-target="#editmodal" class="btn btn-secondary pull-right" >Edit</button>
                    </div>
                    <div class="header-block pull-right">

                    </div>
                </div>
                <section class="section card-block">
                    <div class="row">
                        <div class=" col" style="">
                            <img src="{{asset('storage/avatar/'.$student->avatar)}}" alt="" id="avatarImg" class="student_avatar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" style="margin-left: 20px">
                            <p class="hidden" id="studentId">{{$student->id}}</p>
                            <h6  class="text-primary"><small><strong>Firstname</strong></small></h6>
                            <h4 id="fname">{{$student->fname}}</h4>
                            <h6 class="text-primary"><small><strong>Lastname</strong></small></h6>
                            <h4 id="lname">{{$student->lname}}</h4>
                            <h6 class="text-primary"><small><strong>Section</strong></small></h6>
                            <h4 id="sectionName">{{$student->sectionTo->name}}</h4>
                            <h6 class="text-primary"><small><strong>Gender</strong></small></h6>
                            <h4 id="gender" style="text-transform: capitalize">{{$student->gender}}</h4>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        </div>
        <div class="col-9">
            <div class="col col-md-12 col-12">
                <div class="card sameheight-item" >
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h4 class="card-title text-primary">Activities</h4>
                        </div>
                    </div>
                    <section class="section card-block">
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

            <div class="col col-12">
                @if($exam_results != null && count($exam_results) > 0)
                    <div class="card">
                        <div class="card-header bordered">
                            <div class="header-block">
                                <h3 class="card-title text-primary">  Exam  </h3>
                                <p class="title-description"> </p>
                            </div>
                        </div>
                        <div class="card-block">
                            <table class="table table-striped table-responsive">
                                <tbody>
                                    @foreach ($exam_results as $key => $exam)
                                        <tr>
                                            <td> <small class="text-primary"><b>Exam: </b></small> {{$exam->description}}</td>
                                            <td> <small class="text-primary"><b>Date: </b></small> {{$exam->date}}</td>
                                            <td> <small class="text-primary"><b>Score: </b></small> {{$exam->score}}/{{$exam->perfect_score}}</td>
                                            <td> <a href="{{route('exam.show.student',[$exam->exam_id, $student->id])}}" class="btn btn-sm btn-primary">open</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col col-12">
                <div class="card">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="card-title text-primary"> Activity Files  </h3>
                            <p class="title-description"> </p>
                        </div>
                        <div class="header-block pull-right">
                            <a href="#" id="openFolderButton" class="btn btn-primary">OPEN FOLDER</a>

                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col">
                            <div class="row files">
                                @if($files != null)
                                    @foreach ($files as $key => $file)
                                        <div class="file-container">
                                            <div class="dropdown ">
                                                  <div class="file">
                                                      @if($file->type == 'jpg' || $file->type == 'jpeg' || $file->type == 'png' || $file->type == 'JPG' || $file->type == 'JPEG' )
                                                          <img id="file{{$key}}" src="{{asset('storage/'.$file->path.'/'.$file->basename)}}" alt="" class="file-icon">
                                                          <img  src="@if(file_exists(public_path('img/icons/'.$file->type.'.png'))){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-sub-icon">
                                                          <p class="file-name">{{$file->name}}.{{$file->type}}</p>
                                                          <script>
                                                              var viewer = new Viewer(document.getElementById('file{{$key}}'));
                                                          </script>
                                                      @else
                                                          <img src="@if(file_exists(public_path('img/icons/'.$file->type.'.png'))){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon">
                                                          <p class="file-name">{{$file->name}}.{{$file->type}}</p>
                                                      @endif
                                                  </div>
                                            </div>
                                        </div>


                                    @endforeach
                                @else
                                    <p>No Files</p>
                                @endif


                            </div>


                        </div>
                    </div>
                </div>
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
                <form role="form" action="#" id="studentForm" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class=" col-md-4" style="text-align: right">
                        <img src="{{asset('storage/avatar/'.$student->avatar)}}" alt="" id="formAvatar" class="student_avatar">
                        <input type="file" id="formAvatar_file" name="avatar_file" value="" onchange="readURL(this);" class="form-control">
                    </div>
                    <div class="col-md-8">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <label class="control-label col-md-4">First Name</label>
                            <input name="fname" id="formFname" type="text" class="form-control underlined" required="" value="{{$student->fname}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Last Name</label>
                            <input name="lname" id="formLname"type="text" class="form-control underlined" required="" value="{{$student->lname}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Section</label>

                            <select class="form-control" id="formSection" name="section" required="">
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}" @if($section->id == $student->section) selected @endif>{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Gender</label>
                            <select class="form-control" id="formGender" name="gender" required="">
                                <option value="male" @if($student->gender == 'male') selected @endif>Male</option>
                                <option value="female" @if($student->gender == 'female') selected @endif>Female</option>
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
                </form>
            </div>
            <div class="modal-footer">
                <div class="progress col hidden" id="studentFormProgress">
                  <div class="bg-primary progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Saving...</div>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="studentFormConfirmUpdate" name="submit" class="btn btn-primary">Update</button>
             </div>
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
                <form class="" action="" id="updatePasswordForm" method="post">
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
                </form>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" name="submit" id="studentConfirmUpdatePassword" class="btn btn-primary">Update</button>
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
           $('#formAvatar')
               .attr('src', e.target.result)
       };

       reader.readAsDataURL(input.files[0]);
   }
}


$('#openFolderButton').click(function(event){
    $.ajax({
              type: 'GET',
              url: '{{route('student.folder', $student->id)}}',

              success: function(response) {
                   var type = response.type;
                   var message = response.message;

                   $.notify({
                       message: message
                   },{
                       type: type,
                       allow_dismiss: true,
                       placement: {
                           from: "top",
                           align: "center"
                       },
                       delay: 5000,
                       offset: 45,
                   });

              }
    });

});



$('#studentFormConfirmUpdate').click(function(event){
    var studentId = $('#studentId').text();
    $('#studentFormProgress').show('500');
    $.ajax({
              type: 'POST',
              url: '{{route('student.update', $student->id)}}',
              data: new FormData($('#studentForm')[0]),
              processData: false,
              contentType: false,
              success: function(response) {
                   var data = response;
                   $('#studentFormProgress').hide();

                   $('#editmodal').modal('hide');
                  if(data.errors){

                      var errorsMessage = '';

                      for(var a in data.errors){
                          errorsMessage += '- ' + data.errors[a] + '<br> '; //showing only the first error.

                      }

                      $.notify({message: errorsMessage},{type: 'danger',allow_dismiss: true,placement: {from: "top",align: "center"},delay: 5000,offset: 45,});
                  }else{

                       $('#fname').text(data.student.fname);
                       $('#lname').text(data.student.lname);
                       $('#sectionName').text(data.sectionName);
                       $('#gender').text(data.student.gender);
                       $('#avatarImg').attr('src', data.avatar_file);
                       $.notify({message: '<b>Success:</b> data updated.'},{type: 'success',allow_dismiss: true,placement: {from: "top",align: "center"},delay: 5000,offset: 45,});
                  }
              }
          });

});

$('#studentConfirmUpdatePassword').click(function(event){
    var studentId = $('#studentId').text();
    $.ajax({
              type: 'POST',
              url: '{{route('student.update.password', $student->id)}}',
              data: new FormData($('#updatePasswordForm')[0]),
              processData: false,
              contentType: false,
              success: function(response) {
                   var data = response;
                   $('#passwordModal').modal('hide');
                       $.notify({
                           message: '<b>Success:</b> password updated.'
                       },{
                           type: 'success',
                           allow_dismiss: true,
                           placement: {
                               from: "top",
                               align: "center"
                       },
                       delay: 5000,
                       offset: 45,
                   });
              },
              error: function(data){
              $('#passwordModal').modal('hide');
               var data = data.responseJSON;
               var errorsMessage = '';


               for(var a in data['errors']){
                   errorsMessage += '- ' + data['errors'][a] + '<br> '; //showing only the first error.

               }

               $.notify({
                   message: errorsMessage
               },{
                   type: 'danger',
                   allow_dismiss: true,
                   placement: {
                       from: "top",
                       align: "center"
                   },
                   delay: 5000,
                   offset: 45,

               });
             }
          });

});
</script>
@endsection
