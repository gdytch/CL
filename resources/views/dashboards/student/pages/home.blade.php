@section('dashboard-content')
    <section class="section">
        @if(count($todays_activity) != 0)
                <div class="row ">
                    <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                        <div class="card">
                            <div class="card-block">
                                <div class="title-block">
                                    <h5 class="card-title text-primary">Today's Activity</h5>
                                    <hr>
                                </div>
                                <div class="section">
                                    @foreach ($todays_activity as $post)
                                    <div class="col col-12">
                                        <div class="card-block">
                                                <h4 class="card-title"> {{$post->title}}  </h4>
                                        </div>
                                        <div class="card-block post">
                                            {!!$post->body !!}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
        @endif
        <div class="row ">
            <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                <button type="button" name="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#uploadmodal"><i class="fa fa-file"></i> Submit File</button>

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
                                                      <img src="@if(file_exists(public_path('img/icons/'.$file->type.'.png'))){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon">
                                                      <p class="file-name">{{$file->name}}.{{$file->type}}</p>
                                                  </div>
                                                  <div class="dropdown-menu file-dropdown pull-menu-right" aria-labelledby="dropDown{{$key}}">
                                                      <form action="{{route('file.show',$student->id)}}" method="get">
                                                          {{ csrf_field() }}
                                                          <input type="hidden" name="file" value="{{$file->name}}.{{$file->type}}">
                                                          <button type="submit" name="submit"class="dropdown-item" >Download</button>
                                                      </form>

                                                    <a  class="dropdown-item" href="#" data-toggle="modal" data-target="#deletemodal{{$key}}">Delete</a>
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
                                                          <input type="hidden" name="file" value="{{$file->name}}.{{$file->type}}">
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
