@section('dashboard-content')
    @php $student = Auth::user(); @endphp

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
                            <h4 class="card-title text-primary">{{$activity->name}} &nbsp; @if(count($student->Records->where('activity_id', $activity->id)) > 0) <span class="text-success"><small><i class="fa fa-check-circle"></i> </small></span>@endif</h4>

                            <hr>
                        </div>
                        <div class="card-content col">
                            @if($activity->submission)
                                <button type="button" name="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadmodal{{$activity->id}}"> <i class="fa fa-file"></i> Upload / Submit File</button>
                            @endif
                            <div class="card-block post" >
                                {!!$activity->Post->body !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
            <div class="modal fade" id="uploadmodal{{$activity->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Save/Upload File</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                      <form action="{{route('file.store')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                          <div class="form-group">
                              <h4 class="text-primary">{{$activity->name}}</h4>
                              <h5>{{$activity->description}}</h5>
                              <input type="hidden" class="form-control" name="activity" value="{{$activity->id}}">
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-4">Select File</label>
                              <input type="file" id="file" class="form-control file-input" name="file" required placeholder="">
                          </div>
                          <input type="hidden" name="id" value="{{$student->id}}">
                          <br>

                          <form>
                  </div>
                  <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="success">Upload</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        @endif
        @endforeach

    </section>

@endsection
