@section('dashboard-content')
    {{-- <link rel="stylesheet" href="{{asset('css/quill.core.css')}}">
    <link rel="stylesheet" href="{{asset('css/quill.snow.css')}}"> --}}

    <section class="section">
        <div class="row">
            <div class="col col-12 ">
                <div class="card-block item-editor-page">
                    <div class="title-block">
                        <h3 class="card-title text-primary"> Create Post
                        </h3>
                    </div>
                    <form name="item" method="post" action="{{route('post.store')}}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                <div class="card col">
                                    <div class="card-block">
                                        <h3 class="card-title">Post</h3>

                                        <div class="row form-group">

                                                    <label class="control-label col-12"> Title </label>
                                                <div class="col col-12">
                                                    <input type="text" name="title" class="form-control underlined" placeholder="" required> </div>

                                        </div>
                                        <div class="row form-group">
                                            <label class="col-12 control-label"> Content </label>
                                            <div class="col-sm-12">
                                                <div id="wyswyg">
                                                    <div id="toolbar">

                                                    </div>
                                                    <style>
                                                    .cke_editable img{
                                                        max-height: 100px;
                                                        width: auto !important;
                                                    }
                                                    </style>
                                                    <!-- Create the editor container -->
                                                    {{-- <div id="editor" type="textarea" name="content"> --}}
                                                        <textarea id="content"  type="text" name="content" style="width: 100%; height: 600px;"></textarea>
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="card col">
                                        <div class="card-block">
                                            <div class="form-group">
                                                <h3 class="card-title">Publish</h3>
                                                <div class="col-sm-12">
                                                    <label>
                                                        <input class="checkbox" type="checkbox" name="draft" value="1">
                                                        <span>Set as Draft</span>
                                                    </label>
                                                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card col">
                                        <div class="card-block">
                                            <div class="form-group">
                                                <h3 class="card-title">Activities</h3>
                                                <div class="col col-12 col-sm-12" style="max-height: 400px; overflow: auto;">
                                                    @foreach ($activities as $activity)
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

                        </div>
                    </form>
                </div>
            </div>
        </div>

    {{-- @if(env('APP_ENV') != 'local')
        <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    @else --}}
        {{-- <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> --}}
    {{-- @endif --}}

    <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>

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
