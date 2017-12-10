@section('dashboard-content')
    <style>
    .question-container {
        min-height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .item_nav-container{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
    p.question-text {
        font-size: 14pt;
        text-align: center;
    }
    .question-container .checkbox+span, .radio+span {
        padding: 0 10px 0 0;
        font-size: 11pt;
    }
    .sidebar{
        display: none;
    }
    .app{
        padding-left: 0px;
    }
    .header{
        left: 0px;
    }
    .card{
        background: none;
        border: none;
        box-shadow: none;
    }
    .item_image{
        height: 300px !important;
    }
    .item_image_choice{
        height: 100px;
    }
    .exam_nav{
        line-height: 7px;
        font-size: 9pt;
        padding: 8px;
    }

    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h4 class="card-title text-primary"> {{$exam_paper->description}}   </h4>
                        <p class="title-description"> {{$item->Test->name}}. <b>{{$item->Test->test_type}}. </b> <em>{{$item->Test->description}} </em></p>
                    </div>
                    @if($total_answered == count($item_list))
                        <div class="header-block pull-right">
                            <a href="{{route('exam.finish')}}" class="btn btn-primary">Submit Exam</a>
                        </div>
                    @endif
                </div>
                <div class="card-block">
                <form class="" action="{{route('exam.next')}}" method="post" enctype="multipart/form-data">
                    <div class="row">
                            {{ csrf_field() }}
                            <input type="hidden" name="page" value="{{$page}}">
                            <input type="hidden" name="exam_item_id" value="{{$item->id}}">
                            <input type="hidden" name="exam_name" value="{{$exam_paper->name}}">
                            <input type="hidden" name="exam_paper_id" value="{{$exam_paper->id}}">
                            <input type="hidden" name="prev_answer" value="{{$student_answer}}">
                            <div class="col-1">
                                <div class="question-container">
                                    @if($page > 0)
                                        <button type="submit" class="btn btn-secondary" name="prev" value="1">Back</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="question-container">
                                    <p class="question-text">
                                        @switch($item->question_type)
                                            @case('image')
                                                    <img src="{{asset('photos/shares/'.$item->question)}}" class="item_image" alt="">
                                                    @break;
                                            @case('HTML')
                                                     {!!$item->question!!}
                                                    @break;
                                            @case('post')
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="card" style="background: #fff">
                                                                <div class="card-header bordered">
                                                                    <div class="header-block">
                                                                        <h3 class="card-title text-primary"> Instructions   </h3>
                                                                        <p class="title-description"> </p>
                                                                    </div>
                                                                </div>
                                                                <div class="card-block">
                                                                    {!!$item->question!!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            @if($exam_file == null)
                                                                <h2 class="text-primary">Upload File</h2>
                                                                <div class="form-group">
                                                                    <input type="file" name="exam_file" value="" onchange="readURL(this);" class="form-control" >
                                                                </div>
                                                                <img src="" alt="" id="image" class="student_avatar" style="max-width: 100% !important;">
                                                                <button type="submit" class="btn btn-primary display_hidden" id="savebtn" name="save_exam_file" value="{{$item->id}}">Save File</button>

                                                                <script type="text/javascript">
                                                                function readURL(input) {
                                                                   if (input.files && input.files[0]) {
                                                                       var reader = new FileReader();

                                                                       reader.onload = function (e) {
                                                                           $('#image')
                                                                               .attr('src', e.target.result)
                                                                       };

                                                                       reader.readAsDataURL(input.files[0]);
                                                                   }
                                                                   var element = document.getElementById("savebtn");
                                                                   element.classList.remove("display_hidden");
                                                                }
                                                                </script>
                                                            @else
                                                                <h3 class="text-primary">Submitted File</h3>
                                                                <input type="hidden" name="submitted_exam_file" value="{{$exam_file->basename}}">
                                                                <div class="file" style="background-color:#fff">
                                                                    @if($exam_file->type == 'jpg' || $exam_file->type == 'jpeg' || $exam_file->type == 'png')
                                                                        <img id="file" src="{{asset('storage/'.$exam_file->path.'/'.$exam_file->basename)}}" alt="" class="file-icon">
                                                                        <p class="file-name">{{$exam_file->name}}.{{$exam_file->type}}</p>
                                                                        <script>
                                                                            var viewer = new Viewer(document.getElementById('file'));
                                                                        </script>
                                                                    @else
                                                                        <img style="width: 200px;" src="@if(file_exists(public_path('img/icons/'.$exam_file->type.'.png'))){{asset('img/icons/'.$exam_file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon">
                                                                        <p class="file-name">{{$exam_file->name}}.{{$exam_file->type}}</p>
                                                                    @endif
                                                                </div>
                                                                <button type="submit" class="btn btn-primary" name="delete_exam_file" value="{{$item->id}}">DELEte file</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @break;
                                            @default
                                                     {{$item->question}}
                                        @endswitch
                                    </p>
                                    <p class="question-choices">
                                        @switch($item->Test->test_type)
                                            @case('True or False')
                                                <div class="form-group">
                                                    <div >
                                                        <label>
                                                            <input class="radio" name="answer" type="radio" value="true" @if($student_answer == 'true') checked @endif>
                                                            <span>True</span>
                                                        </label>
                                                        <label>
                                                            <input class="radio" name="answer" type="radio" value="false"  @if($student_answer == 'false') checked @endif>
                                                            <span>False</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                @break
                                            @case('Identification')
                                            @case('Multiple Choice')
                                                <div class="form-group">
                                                    <div>

                                                        @foreach ($item_Choices as $choice)
                                                            <label style="margin-left: 50px">
                                                                <input class="radio" name="answer" type="radio" value='{{$choice}}'  @if($student_answer == $choice) checked @endif>
                                                                <span>
                                                                    @switch($item->answer_type)
                                                                        @case('image')
                                                                                <img src="{{asset('photos/shares/'.$choice)}}" class="item_image_choice" alt="">
                                                                                @break;
                                                                        @case('HTML')
                                                                                 {!!$choice!!}
                                                                                @break;
                                                                        @default
                                                                                 {{$choice}}
                                                                    @endswitch
                                                                </span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="question-container">
                                    @if($page < $page_max-1)
                                        <button type="submit" class="btn btn-primary" name="next" value="1">Next</button>
                                    @else
                                        <button type="submit" class="btn btn-primary" name="finish" value="1">Next</button>
                                    @endif
                                </div>
                            </div>

                    </div>



                    <div class="row">
                        @php $p = 0; @endphp
                        @foreach ($exam_paper->Tests as $key => $test1)
                            <div class="col-12 item_nav-container">

                                &nbsp;
                                <small>{{$test1->name}}</small> &nbsp;
                                <div class="btn-group" >

                                    @foreach ($test1->Items as $key2 => $item2)
                                        @if($item_list[$p]->answered)
                                                <button type="submit" name="jump" value="{{$p}}" class="btn btn-primary @if($p == $page) active @endif exam_nav">{{$key2+1}}</button>
                                        @else
                                                <button type="submit" name="jump" value="{{$p}}" class="btn btn-secondary @if($p == $page) active @endif exam_nav">{{$key2+1}}</button>
                                        @endif
                                        @php $p++; @endphp
                                    @endforeach


                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>
@endsection
