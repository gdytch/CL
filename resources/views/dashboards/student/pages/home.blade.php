@section('dashboard-content')
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
                                            @if($activity->submitted) <span class="text-success"> <i class="fa fa-check-circle"></i> </span> @else <span class="text-danger"> <i class="fa fa-close"></i> </span> @endif
                                            {{$activity->name}},
                                        @endforeach
                                    <hr>
                                </div>
                                <div class="section" id="post">
                                    @foreach ($todays_activity as $activity)
                                        <div class="col col-12">
                                            <div class="card-block post" >
                                                <h4 class="card-title text-primary">
                                                    {{$activity->name}} &nbsp;
                                                    @if($activity->submitted)
                                                         <span class="text-success"><small><i class="fa fa-check-circle"></i> Submitted </small></span>
                                                    @endif
                                                </h4>
                                                &nbsp;
                                                <button type="button" name="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadmodal{{$activity->post->id}}"><i class="fa fa-file"></i> Upload / Submit File</button>
                                                <hr>
                                                @if(!$activity->submitted)
                                                    <h4 class="card-title text-primary">
                                                        Instructions
                                                    </h4>

                                                    {!!$activity->post->body !!}
                                                @endif

                                            </div>
                                            <div class="modal fade" id="uploadmodal{{$activity->post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Save/Upload File</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <form action="{{route('file.store')}}" method="post" enctype="multipart/form-data">
                                                          {{csrf_field()}}
                                                          <br>
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
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
        @else
            @if($exam_paper == null)
            <button type="button" name="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadmodal"><i class="fa fa-file"></i> Upload / Submit File</button>
            @endif
        @endif
        @if($exam_paper != null)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bordered">
                            <div class="header-block">
                                Exam: <h3 class="card-title text-primary">   {{$exam_paper->description}}</h3>
                            </div>
                        </div>
                        <div class="card-block">
                            <a href="{{route('exam.open',0)}}"  class="btn btn-primary">Start Exam</a>
                        </div>
                    </div>
                </div>
            </div>
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
                            <div class="row files">
                                @if($files != null)
                                    @foreach ($files as $key => $file)
                                        <div class="file-container">
                                            <div class="dropdown ">
                                              <a id='dropDown{{$key}}' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0">
                                                  <div class="file">
                                                      @if($file->type == 'jpg' || $file->type == 'jpeg' || $file->type == 'png')
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
                                                  <div class="dropdown-menu file-dropdown pull-menu-right" aria-labelledby="dropDown{{$key}}">
                                                      <form action="{{route('file.show',$student->id)}}" method="get">
                                                          {{ csrf_field() }}
                                                          <input type="hidden" name="file" value="{{$file->basename}}">
                                                          <button type="submit" name="submit"class="dropdown-item" ><i class="fa fa-download"></i> Download</button>
                                                      </form>

                                                    <a  class="dropdown-item" href="#" data-toggle="modal" data-target="#deletemodal{{$key}}"><i class="fa fa-trash"></i> Delete</a>
                                                  </div>
                                                </div>
                                            </a>

                                            {{-- Delete modal  --}}
                                            <div class="modal fade" id="deletemodal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                  </div>
                                                  <div class="modal-body">
                                                      Are you sure to delete this file?
                                                      <div class="">
                                                          <img src="@if(file_exists(public_path('img/icons/'.$file->type.'.png'))){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon" style="width: 100px">
                                                          <p class="file-name">{{$file->name}}.{{$file->type}}</p>
                                                      </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                      <form action="{{route('file.destroy',$student->id)}}" method="post">
                                                          {{csrf_field()}}
                                                          <input type="hidden" name="_method" value="DELETE">
                                                          <input type="hidden" name="method" value="recycle">
                                                          <input type="hidden" name="file" value="{{$file->basename}}">
                                                          <input type="hidden" name="file_id" value="{{$file->id}}">
                                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                          <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                                                      </form>
                                                  </div>
                                                </div>
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

        <div class="modal fade" id="uploadmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Save/Upload File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  <form action="{{route('file.store')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <br>
                      <div class="form-group">
                          <label class="control-label col-md-4">Select File</label>
                          <input type="file" id="file" class="form-control file-input" name="file" required placeholder="">
                      </div>
                      <input type="hidden" name="id" value="{{$student->id}}">
                      <br>
                      <div class="form-row align-items-center">
                        <div class="col">
                         <label class="control-label col-md-4">Activity </label>

                          <select name="activity" class="select form-control" id="inlineFormCustomSelect" required>
                            @foreach ($activities as $activity)
                                <option value="{{$activity->id}}">{{$activity->name}} {{$activity->description}}</option>

                            @endforeach
                          </select>
                        </div>

                      </div>
                      <form>



              </div>
              <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="success">Upload</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>

@endsection
