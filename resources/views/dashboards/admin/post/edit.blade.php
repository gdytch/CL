@section('dashboard-content')
    {{-- <link rel="stylesheet" href="{{asset('css/quill.core.css')}}">
    <link rel="stylesheet" href="{{asset('css/quill.snow.css')}}"> --}}

    <section class="section">
        <div class="row">
            <div class="col col-12 ">
                <div class="card-block item-editor-page">
                    <div class="title-block">
                        <h3 class="card-title text-primary"> Edit Post
                        </h3>
                    </div>
                    <form name="item" method="post" action="{{route('post.update',$post->id)}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                    <div class="row">
                        <div class="card col-8" style="margin: 10px;">
                            <div class="card-block">
                                <h3 class="card-title">Post</h3>

                                <div class="row form-group">

                                            <label class="control-label col-12"> Title </label>
                                        <div class="col col-12">
                                            <input type="text" name="title" class="form-control underlined" value="{{$post->title}}"> </div>

                                </div>
                                <div class="row form-group">
                                    <label class="col-12 control-label"> Content </label>
                                    <div class="col-sm-12">
                                        <div id="wyswyg">
                                            <div id="toolbar">

                                            </div>
                                            <!-- Create the editor container -->
                                            {{-- <div id="editor" type="textarea" name="content"> --}}
                                                <textarea  type="text" name="content" style="width: 100%; height: 600px;">
                                                    {!!$post->body!!}
                                                </textarea>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card row" style="margin: 10px; padding: 20px">
                                <div class="card-block">
                                    <div class="form-group row">
                                        <h3 class="card-title">Publish</h3>
                                    </div>
                                    <div class="row">
                                            <label class="">
                                                <input class="checkbox" type="checkbox" name="draft" value="1" @if($post->draft) checked @endif>
                                                    <span>Set as Draft</span>
                                            </lable>
                                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    <div class="row">
                                            <button type="button" data-toggle="modal" data-target="#deletemodal" class="btn btn-danger">Delete</button>
                                            &nbsp;
                                            <a href="{{route('post.show',$post->id)}}" class="btn btn-secondary">Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card row" style="margin: 10px; padding: 20px">
                                <div class="card-block">
                                    <div class="form-group row">
                                        <h3 class="card-title">Activities</h3>
                                        <div class="col col-12 col-sm-12" style="max-height: 400px; overflow: auto;">
                                            @foreach ($checked_activities as $activity)
                                                <label class="row">
                                                    <input class="checkbox" type="checkbox" name="activity[]" value="{{$activity->id}}" checked>
                                                    <span> {{$activity->name}} <small>{{$activity->SectionTo->name}}</small></span>
                                                </label>

                                            @endforeach
                                            @foreach ($unchecked_activities as $activity)
                                                <label class="row">
                                                    <input class="checkbox" type="checkbox" name="activity[]" value="{{$activity->id}}">
                                                    <span> {{$activity->name}} <small>{{$activity->SectionTo->name}}</small></span>
                                                </label>

                                            @endforeach

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  Are you sure to delete this post?

              </div>
              <div class="modal-footer">
                  <form action="{{route('post.destroy',$post->id)}}" method="post">
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

        {{-- @if(env('APP_ENV') !== 'local')
            <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
        @else --}}
            <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
        {{-- @endif --}}

        <script>
          var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
          };
        </script>
        <script>
        CKEDITOR.replace('content', options);
        </script>
@endsection
