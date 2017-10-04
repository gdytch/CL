@section('dashboard-content')
    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 col-sm-12 col-md-12 col-xl-12">
                <button type="button" name="button" class="btn btn-lg btn-success">Save/Upload File</button><br><br>
                <div class="card sameheight-item">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="title"> Files </h4>
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
                                                      <img src="@if(file_exists($file->path)){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon">
                                                      <p class="file-name">{{$file->name}}</p>
                                                  </div>
                                                  <div class="dropdown-menu file-dropdown pull-menu-right" aria-labelledby="dropDown{{$key}}">
                                                    <a class="dropdown-item" href="#">Download</a>
                                                    <a class="dropdown-item" href="#">Rename</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                  </div>
                                                </div>
                                            </a>


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
    </section>

@endsection
