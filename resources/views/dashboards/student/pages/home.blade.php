@section('dashboard-content')
    <link rel="stylesheet" href="{{asset('css/checkanimation.css')}}">
    <section class="section" >
        @if(count($todays_activity) != 0)
                <div class="row ">
                    <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                        <div class="card">
                            <div class="card-block">
                                <div class="title-block">
                                    <h5 class="card-title text-primary">Today's Activities:
                                    </h5>
                                        @foreach ($todays_activity as $activity)
                                            @if($activity->submitted) <span id="activityTabSpan{{$activity->id}}" class="text-success"> <i id="activityTabIcon{{$activity->id}}" class="fa fa-check-circle"></i> </span> @else <span id="activityTabSpan{{$activity->id}}" class="text-danger"> <i id="activityTabIcon{{$activity->id}}" class="fa fa-close"></i> </span> @endif
                                            {{$activity->name}},
                                        @endforeach
                                    <hr>
                                </div>
                                <div class="section" id="post">
                                    @foreach ($todays_activity as $activity)
                                        <div class="col col-12" id="activityPost{{$activity->id}}">
                                            <div class="card-block post" >
                                                <h4 class="card-title text-primary">
                                                    {{$activity->name}} &nbsp;
                                                    @if($activity->submitted)
                                                         <span class="text-success" id="activityPostSubmitted{{$activity->id}}"><small><i class="fa fa-check-circle"></i> Submitted </small></span>
                                                    @endif
                                                </h4>
                                                &nbsp;
                                                @if(!$activity->submitted)
                                                     <button type="button" id="activityPostSubmitButton{{$activity->id}}" name="button" class="btn btn-primary uploadButton" data-toggle="modal" data-target="#uploadModal1"><i class="fa fa-file"></i> Upload / Submit File
                                                         <input type="hidden" name="activityName" class="activityName" value="{{$activity->name}}">
                                                         <input type="hidden" name="activityId" class="activityId" value="{{$activity->id}}">
                                                         <input type="hidden" name="activityValidExtensions" class="activityValidExtensions" value="{{$activity->FTRule->extensions}}">
                                                     </button>
                                                @endif
                                                <hr>
                                                @if(!$activity->submitted)
                                                    <div id="activityPostInstructions{{$activity->id}}">
                                                        <h4 class="card-title text-primary" >
                                                            Instructions
                                                        </h4>
                                                        {!!$activity->post->body !!}
                                                    </div>
                                                @endif

                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
        @else
            @if(count($exam_paper) == 0)
            <button type="button" name="button" class="btn btn-primary uploadButton" data-toggle="modal" data-target="#uploadModal"><i class="fa fa-file"></i> Upload / Submit File</button>
            @endif
        @endif
        @if(count($exam_paper) > 0)
            @foreach ($exam_paper as $key => $exam_paper1)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bordered">
                                <div class="header-block">
                                    Exam: <h3 class="card-title text-primary">   {{$exam_paper1->description}}</h3>
                                </div>
                            </div>
                            <div class="card-block">
                                <a href="{{route('exam.open',[$exams[$key]->id,0])}}"  class="btn btn-primary">Start Exam</a>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        @endif
        <div class="row ">
            <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                {{-- <button type="button" name="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadmodal"><i class="fa fa-file"></i> Upload File</button> --}}

                <br><br>

                <div class="card sameheight-item">
                    <div class="card-block">
                        <div class="title-block">
                            <h5 class="card-title text-primary"> My Files </h5>
                            <hr>
                        </div>
                        <div class="col">
                            <div class="row files" id="files_container">
                                @if($files != null)
                                    @foreach ($files as $key => $file)
                                        <div class="file-container" id="{{$file->id}}">
                                            <div class="dropdown">
                                              <a id="dropDown{{$key}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0">
                                                  <div class="file">
                                                      @if(strtolower($file->type) == 'jpg' ||strtolower($file->type) == 'jpeg' ||strtolower($file->type) == 'png' )
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
                                                </a>
                                                <div class="dropdown-menu file-dropdown pull-menu-right" aria-labelledby="dropDown{{$key}}">
                                                    <form action="{{route('file.show',$student->id)}}" method="get">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="file" id="downFileBasename" value="{{$file->basename}}">
                                                        <button type="submit"  class="dropdown-item" id="downloadButtonConfirm"><i class="fa fa-download"></i> Download
                                                        </button>
                                                    </form>
                                                    <a  class="dropdown-item deleteButton" data-toggle="modal" data-target="#deletemodal" ><i class="fa fa-trash"></i> Delete
                                                        <input type="hidden" name="" class="fileId" value="{{$file->id}}">
                                                        <input type="hidden" name="" class="fileBasename" value="{{$file->basename}}">
                                                    </a>
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

        {{-- Delete modal  --}}
        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  Are you sure to delete this file?
                  <hr>
                      <div class="deleteModalFile">

                      </div>
              </div>
              <div class="modal-footer">
                  <form action="#" method="post" id="deleteForm">
                      {{csrf_field()}}
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="method" value="recycle">
                      <input type="hidden" name="file" value="" id="deleteModalFile">
                      <input type="hidden" name="file_id" value="" id="deleteModalFileId">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                      <button type="button" name="submit" class="btn btn-primary" id="deleteModalConfirm">Yes</button>
                  </form>
              </div>
            </div>
          </div>
        </div>



        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Save/Upload File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  <form action="#" method="post" class='modalForm' enctype="multipart/form-data">
                      {{csrf_field()}}
                      <br>

                      <div class="form-group">
                          <select name="activity" class="select form-control" id="inlineFormCustomSelect" required>
                            @foreach ($activities as $activity)
                                <option value="{{$activity->id}}">{{$activity->name}} {{$activity->description}}</option>

                            @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-4">Select File</label>
                          <input type="file" class="uploadModalFile form-control file-input" name="file" required placeholder=""  accept="">
                      </div>
                      <input type="hidden" name="id" class="uploadModalStudentId" value="{{$student->id}}">
                      <br>
                  </form>
                  <div class="hidden successCheck">
                      <div class="check_mark">
                        <div class="sa-icon sa-success animate">
                          <span class="sa-line sa-tip animateSuccessTip"></span>
                          <span class="sa-line sa-long animateSuccessLong"></span>
                          <div class="sa-placeholder"></div>
                          <div class="sa-fix"></div>
                        </div>
                      </div>
                      <center>
                          <h3 class="success" style="font-weight:100">File Submitted</h3>
                      </center>
                  </div>
              </div>
              <div class="modal-footer">
                  <div class="progress col hidden uploadModalProgress">
                    <div class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Saving...</div>
                  </div>
                    <button type="button" class="uploadModalConfirmButton btn btn-primary" name="success">Upload</button>
              </div>
            </div>
          </div>
        </div>



        <div class="modal fade" id="uploadModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModal1Label">Save/Upload File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  <form action="#" method="post" class='modalForm'  enctype="multipart/form-data">
                      {{csrf_field()}}
                      <br>

                      <div class="form-group">
                          <h4 class="text-primary uploadModalActivityName"></h4>
                          <h5 class="uploadModalActivityDescription"></h5>
                          <input type="hidden" class="form-control uploadModalActivityId" name="activity" value="">
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-4">Select File</label>
                          <input type="file" class="uploadModalFile form-control file-input" name="file" required placeholder=""  accept="">
                      </div>
                      <input type="hidden" name="id" class="uploadModalStudentId" value="{{$student->id}}">
                      <br>
                  </form>
                  <div class="hidden successCheck">
                      <div class="check_mark">
                        <div class="sa-icon sa-success animate">
                          <span class="sa-line sa-tip animateSuccessTip"></span>
                          <span class="sa-line sa-long animateSuccessLong"></span>
                          <div class="sa-placeholder"></div>
                          <div class="sa-fix"></div>
                        </div>
                      </div>
                      <center>
                          <h3 class="success" style="font-weight:100">File Submitted</h3>
                      </center>
                  </div>
              </div>
              <div class="modal-footer">
                  <div class="progress col hidden uploadModalProgress">
                    <div class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Saving...</div>
                  </div>
                    <button type="button" class="uploadModalConfirmButton btn btn-primary" name="success">Upload</button>
              </div>
            </div>
          </div>
        </div>



    </section>
<script type="text/javascript">
$(document).on('click', '.uploadButton', function(event){
    var activityId = $(this).find('.activityId').val();
    var activityName = $(this).find('.activityName').val();
    var extensions = $(this).find('.activityValidExtensions').val();
    $('.uploadModalFile').attr('accept', extensions);
    $('.uploadModalActivityName').text(activityName);
    $('.uploadModalActivityId').val(activityId);
    $('.uploadModalConfirmButton').show();
    $('.modalForm').show();
    $('.successCheck').hide();
});

$(document).on('click', '.deleteButton', function(event){
    $(".deleteModalFile").find('.file').remove();
    var file = $(this).find('.fileId').val();
    var basename = $(this).find('.fileBasename').val();
    $('#deleteModalFile').val(basename);
    $('#deleteModalFileId').val(file);
    $(this).closest('.dropdown').find('.file').clone().appendTo(".deleteModalFile");
    $(".deleteModalFile").find('.file-sub-icon').remove();


});

$('#deleteModalConfirm').click(function(event){
    $.ajax({
              type: 'POST',
              url: '{{route("file.destroy", $student->id)}}',
              data: new FormData($('#deleteForm')[0]),
              processData: false,
              contentType: false,
              success: function(response) {
                    var data = response;
                    $('#activityTabSpan'+data.activityId).removeClass('text-success');
                    $('#activityTabSpan'+data.activityId).addClass('text-danger');
                    $('#activityTabIcon'+data.activityId).removeClass('fa-check-circle');
                    $('#activityTabIcon'+data.activityId).addClass('fa-close');
                    $('#activityPostSubmitted'+data.activityId).hide('200');
                    $('#activityPost'+ data.activityId).find('.post').append('\
                    <button type="button" id="activityPostSubmitButton'+ data.activityId +'" name="button" class="btn btn-primary uploadButton" data-toggle="modal" data-target="#uploadModal1"><i class="fa fa-file"></i> Upload / Submit File\
                    <input type="hidden" name="activityName" class="activityName" value="'+ data.activity.name +'">\
                    <input type="hidden" name="activityId" class="activityId" value="' + data.activityId + '">\
                    </button>');
                    $('#activityPostInstructions'+data.activityId).show('200');
                    $('#'+ data.fileId).remove();
                    $('#deletemodal').modal('hide');
                    $('#activityPost'+ data.activityId).find('.post').append('\
                       <div id="activityPostInstructions'+ data.activityId +'">\
                           <h4 class="card-title text-primary" >\
                               Instructions\
                           </h4>\
                           '+ data.post.body +'\
                       </div>');
                   $.notify({
                       message: '<b>Success:</b> File moved to trash.'
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
              }
    });

});

$(document).on('click', '.uploadModalConfirmButton', function(event){
    $('.uploadModalProgress').show('500');
    var form = new FormData($(this).closest('.modal-dialog').find('.modalForm')[0]);
    $.ajax({
              type: 'POST',
              url: 'file/',
              data: form,
              processData: false,
              contentType: false,
              success: function(response) {
                   var data = response;
                   console.log(data)
                   $('.uploadModalProgress').hide();
                  if(data.errors){
                      var errorsMessage = '';
                      for(var a in data.errors){
                          errorsMessage += '- ' + data.errors[a] + '<br> '; //showing only the first error.
                      }
                      $.notify({message: errorsMessage},{type: 'danger',allow_dismiss: true,placement: {from: "top",align: "center"},delay: 5000,offset: 45,});
                      $('#uploadModal1').modal('hide');
                      $('#uploadModal').modal('hide');
                  }else{

                        $('#activityTabSpan'+data.activityId).removeClass('text-danger');
                        $('#activityTabSpan'+data.activityId).addClass('text-success');
                        $('#activityTabIcon'+data.activityId).removeClass('fa-close');
                        $('#activityTabIcon'+data.activityId).addClass('fa-check-circle');
                        $('#activityPost'+ data.activityId).find('.post').append('\
                        <span class="text-success" id="activityPostSubmitted'+ data.activityId +'"><small><i class="fa fa-check-circle"></i> Submitted </small></span>\
                        ');
                        $('#activityPostSubmitButton'+data.activityId).remove();
                        $('#activityPostInstructions'+data.activityId).remove();
                        $('.uploadModalFile').val('');
                        $('.uploadModalConfirmButton').hide('200');
                        $('.modalForm').hide();
                        $('.successCheck').show('200');
                        $(".sa-success").addClass("hide");
                         setTimeout(function() {
                           $(".sa-success").removeClass("hide");
                         }, 10);
                        if(data.extension.toLowerCase() == 'jpg' || data.extension.toLowerCase() == 'jpeg' || data.extension.toLowerCase() == 'png' ){
                            var file_icon =  '\
                                  <img id="file' + data.fileId + '" src="' + data.image_src + '" alt="" class="file-icon">\
                                  <img  src="' + data.fileIcon + '" alt="" class="file-sub-icon">\
                                  <p class="file-name">' + data.filename + '</p>\
                                  ';
                        }else {
                            var file_icon = '\
                            <img src="' + data.fileIcon + '" alt="" class="file-icon">\
                            <p class="file-name">'+ data.filename +'</p>\
                            ';
                        }
                        $('#files_container').append('<div class="file-container" id="'+ data.fileId +'">\
                             <div class="dropdown">\
                               <a id="dropDown' + data.fileId + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0">\
                                   <div class="file">\
                                     ' + file_icon + '\
                                   </div>\
                                 </a>\
                                 <div class="dropdown-menu file-dropdown pull-menu-right" aria-labelledby="dropDown' + data.fileId + '">\
                                     <form action=" {{route('file.show',$student->id)}}" method="get">{{ csrf_field() }}\
                                         <input type="hidden" name="file" id="downFileBasename" value="' + data.basename + '">\
                                         <button type="submit"  class="dropdown-item" id="downloadButtonConfirm"><i class="fa fa-download"></i> Download\
                                         </button>\
                                     </form>\
                                     <a  class="dropdown-item deleteButton" data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i> Delete\
                                     <input type="hidden" name="" class="fileId" value="'+ data.fileId +'">\
                                     <input type="hidden" name="" class="fileBasename" value="'+ data.basename +'">\
                                     </a>\
                                 </div>\
                             </div>\
                         </div>');

                        var viewer = new Viewer(document.getElementById('file'+data.fileId));


                  }
              }
          });

});

</script>
@endsection
