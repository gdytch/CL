@section('dashboard-content')
    @php $student = Auth::user(); @endphp
    <link rel="stylesheet" href="{{asset('css/checkanimation.css')}}">

    <section class="section" id="post">
        <h4 class="card-title text-primary">Activities</h4>
        <hr><br>
        @foreach($activities as $activity)
             @if($activity->Post != null)
                <div class="row" style="margin-bottom: 50px;">
                    <div class="col col-12 col-md-12 col-xs-12">
                        <div class="card post-container">
                            <div class="card-block">
                                <div class="title-block">
                                    <h4 class="card-title text-primary" id="activityTitle{{$activity->id}}">{{$activity->name}} &nbsp; @if(count($student->Records->where('activity_id', $activity->id)) > 0) <span class="text-success"><small><i class="fa fa-check-circle"></i> </small></span>@endif</h4>
                                    <hr>
                                </div>
                                <div class="card-content col">
                                    @if($activity->submission)
                                        <button type="button" name="button" class="btn btn-primary uploadButton" data-toggle="modal" data-target="#uploadModal"> <i class="fa fa-file"></i> Upload / Submit File
                                            <input type="hidden" name="activityName" class="activityName" value="{{$activity->name}}">
                                            <input type="hidden" name="activityId" class="activityId" value="{{$activity->id}}">
                                            <input type="hidden" name="activityValidExtensions" class="activityValidExtensions" value="{{$activity->FTRule->extensions}}">
                                        </button>
                                    @endif
                                    <div class="card-block post" >
                                        {!!$activity->Post->body !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

    $(document).on('click', '.uploadModalConfirmButton', function(event){
        $('.uploadModalProgress').show('500');
        var form = new FormData($(this).closest('.modal-dialog').find('.modalForm')[0]);
        $.ajax({
                  type: 'POST',
                  url: '{{route('file.store')}}',
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
                          $('#uploadModal').modal('hide');
                      }else{
                          $.notify({message: '<b>Success:</b> File saved.'},{type: 'success',allow_dismiss: true,placement: {from: "top",align: "center"},delay: 5000,offset: 45,});

                          $('#activityTitle'+ data.activityId).append('<span class="text-success"><small><i class="fa fa-check-circle"></i> </small></span>');
                          $('#uploadModal').modal('hide');
                      }
                  }
              });

    });
    </script>

    </section>

@endsection
