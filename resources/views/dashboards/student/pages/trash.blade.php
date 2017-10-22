@section('dashboard-content')
    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                @if($files != null)<button type="button" name="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#emptybinmodal"> <i class="fa fa-trash"></i> Empty trash</button><br><br> @endif
                <div class="card sameheight-item">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary"> Trash </h4>
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
                                                      <form action="{{route('file.destroy',$student->id)}}" method="post">
                                                          {{csrf_field()}}
                                                          <input type="hidden" name="_method" value="DELETE">
                                                          <input type="hidden" name="file_id" value="{{$file->id}}">
                                                          <input type="hidden" name="file" value="{{$file->basename}}">
                                                          <input type="hidden" name="method" value="restore">
                                                          <button type="submit" name="submit" class="dropdown-item">Restore</button>
                                                      </form>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deletemodal{{$key}}">Delete</a>
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
                                                      Are you sure to permanently delete this file?
                                                      <div class="">
                                                          <img src="@if(file_exists(public_path('img/icons/'.$file->type.'.png'))){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon" style="width: 100px">
                                                          <p class="file-name">{{$file->name}}.{{$file->type}}</p>
                                                      </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                      <form action="{{route('file.destroy',$student->id)}}" method="post">
                                                          {{csrf_field()}}
                                                          <input type="hidden" name="_method" value="DELETE">
                                                          <input type="hidden" name="method" value="delete">
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

        <div class="modal fade" id="emptybinmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  Are you sure to delete all files?

              </div>
              <div class="modal-footer">
                  <form action="{{route('file.destroy',$student->id)}}" method="post">
                      {{csrf_field()}}
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="method" value="empty">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                      <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
    </section>

@endsection
