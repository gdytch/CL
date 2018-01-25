@section('dashboard-content')
    {{ Breadcrumbs::render('exam.show.student', $student, $exam) }}
    <a href="{{route('exam.show',$exam->id)}}" class="btn btn-secondary">Back</a>
    <div class="row ">
        <div class="col col-12 ">
            <div class="card sameheight-item" >
                <div class="card-header bordered">
                    <div class="header-block ">
                        <h4 class="card-title text-primary">Student</h4>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class=" col-md-2" style="">
                            <img src="{{asset('storage/avatar/'.$student->avatar)}}" alt="" class="student_avatar">
                        </div>
                        <div class="col-md-4" style="margin-left: 20px">
                            <h6 class="text-primary"><small><strong>Firstname</strong></small></h6>
                            <h4>{{$student->fname}}</h4>
                            <h6 class="text-primary"><small><strong>Lastname</strong></small></h6>
                            <h4>{{$student->lname}}</h4>
                            <h6 class="text-primary"><small><strong>Section</strong></small></h6>
                            <h4>{{$student->sectionTo->name}}</h4>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-primary"><small><strong>Exam</strong></small></h6>
                            <h4> {{$exam_paper->description}} </h4>
                            <h6 class="text-primary"><small><strong>Date</strong></small></h6>
                            <h4> {{$exam_paper->date}} </h4>
                            <h6 class="text-primary"><small><strong>Submitted</strong></small>
                            </h6>
                            <h4>
                                @if($exam_paper->submitted)
                                    <i class="fa fa-check green"></i>
                                    <form class="" action="{{route('exam.reOpen')}}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden"  name="exam_id" value="{{$exam->id}}">
                                        <input type="hidden" name="student_id" value="{{$student->id}}">
                                        <button type="submit" class="btn btn-sm btn-primary" name="submit">reopen</button>
                                    </form>
                                @else
                                    <i class="fa fa-close red"></i>
                                @endif
                            </h4>
                            <h6 class="text-primary"><small><strong>Score</strong></small></h6>
                            <h1 style="font-size: 32pt; font-weight:100;"> <span class="text-primary" >{{$exam_paper->score}}</span>
                                <span style="position: relative;left: -10px;font-size: 25pt;">/</span>
                                 <span style="left: -20px;font-size: 24pt;position: relative;"> {{$exam_paper->perfect_score}} </span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h4 class="card-title text-primary">
                            Exam Result
                        </h4>
                    </div>
                </div>
                <div class="card-block">
                    @foreach ($exam_paper->Tests as $test)
                        <div class="card-block">
                            <div class="row">
                                <div class="col-12">
                                    {{-- Test --}}
                                    {{$test->name}}. <strong>{{$test->test_type}}.</strong> <i>{{$test->description}}</i>
                                </div>
                            </div>

                            <div class="card-block col">
                                <ol>
                                    {{-- Question Items --}}
                                    @foreach ($test->Items as $key => $test_item)
                                        <div class="row">
                                            <div class="col-1" style="text-align:center">
                                                @if($item_answers[$test_item->id]->correct)
                                                    <i class="fa fa-check green"></i>
                                                @else
                                                    <i class="fa fa-close red"></i> <br><span class="text-primary">ans: {{$test_item->correct_answer}}</span>
                                                @endif

                                            </div>
                                            <div class="col-11">
                                                {{-- Question --}}
                                                <li><p class="question-text">
                                                    @switch($test_item->question_type)
                                                        @case('image')
                                                                <img src="{{asset('photos/shares/'.$test_item->question)}}" class="item_image" alt="">
                                                                @break;
                                                        @case('HTML')
                                                                 {!!$test_item->question!!}
                                                                @break;
                                                        @case('post')
                                                                <div class="form-group" style="width: 100%;">
                                                                    <label class="col-12 control-label"> Hands On Instructions </label>
                                                                    <div class="row">
                                                                        <div class="col-sm-6" style="max-height: 500px; overflow: auto;">
                                                                            {!!$test_item->question!!}
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="file" style="background-color:#fff">
                                                                                @if($item_answers[$test_item->id]->type == 'jpg' || $item_answers[$test_item->id]->type == 'jpeg' || $item_answers[$test_item->id]->type == 'png')
                                                                                    <img id="file" src="{{asset('storage/'.$item_answers[$test_item->id]->path.'/'.$item_answers[$test_item->id]->basename)}}" alt="" class="file-icon">
                                                                                    <p class="file-name">{{$item_answers[$test_item->id]->name}}.{{$item_answers[$test_item->id]->type}}</p>
                                                                                    <script>
                                                                                    var viewer = new Viewer(document.getElementById('file'));
                                                                                    </script>
                                                                                @else
                                                                                    <img style="width: 200px;" src="@if(file_exists(public_path('img/icons/'.$item_answers[$test_item->id]->type.'.png'))){{asset('img/icons/'.$item_answers[$test_item->id]->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon">
                                                                                    <p class="file-name">{{$item_answers[$test_item->id]->name}}.{{$item_answers[$test_item->id]->type}}</p>
                                                                                @endif
                                                                            </div>
                                                                            <a href="{{route('student.exam-folder',$student->id)}}" class="btn btn-primary">OPEN FOLDER</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @break;
                                                        @default
                                                                 {{$test_item->question}}
                                                    @endswitch
                                                    <br>
                                                </p>

                                                    <div class="row">
                                                            {{-- Choices --}}
                                                            @switch($test->test_type)
                                                                @case('True or False')
                                                                <div class="form-group">
                                                                    <div >
                                                                        <label>
                                                                            <input class="radio" name="{{$test_item->id}}" type="radio" value="true" @if($item_answers[$test_item->id]->answer == 'true') checked @else disabled @endif>
                                                                            <span>True</span>
                                                                        </label>
                                                                        <label>
                                                                            <input class="radio" name="{{$test_item->id}}" type="radio" value="false"  @if($item_answers[$test_item->id]->answer == 'false') checked @else disabled @endif>
                                                                            <span>False</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                @break
                                                                @case('Identification')
                                                                @case('Multiple Choice')
                                                                <div class="form-group">
                                                                    <div>

                                                                        @foreach ($test_item->Choices as $choice)
                                                                            <label style="margin-left: 50px">
                                                                                <input class="radio" name="{{$test_item->id}}" type="radio" value='{{$choice->choice}}'  @if($item_answers[$test_item->id]->answer == $choice->choice) checked @else disabled  @endif>
                                                                                <span>
                                                                                    @switch($choice->answer_type)
                                                                                        @case('image')
                                                                                                <img src="{{asset('photos/shares/'.$choice->choice)}}" class="item_image" alt="">
                                                                                                @break;
                                                                                        @case('HTML')
                                                                                                 {!!$choice->choice!!}
                                                                                                @break;
                                                                                        @default
                                                                                                 {{$choice->choice}}
                                                                                    @endswitch
                                                                                </span>
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                @break
                                                            @endswitch
                                                    </div>
                                                @if($test_item->points_type == 'Manual')
                                                    <form class="" action="{{route('exam.saveHandsOnPoints')}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label for="">Points</label>
                                                            <input type="hidden" name="answer_entry_id" value="{{$item_answers[$test_item->id]->answer_entry_id}}">
                                                            <input type="hidden" name="item_id" value="{{$test_item->id}}">
                                                            <input type="hidden" name="student_id" value="{{$student->id}}">
                                                            <input type="hidden" name="exam_paper_id" value="{{$exam_paper->id}}">
                                                            <input type="number" name="points" class="form-control underlined" value="{{$item_answers[$test_item->id]->points}}"  placeholder="Number of points" required>
                                                            <button type="submit" name="submit" class="btn btn-primary">Save Points</button>
                                                        </div>
                                                    </form>
                                                @endif
                                                </li>
                                            </div>
                                        </div>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>


    <div id="bottom"></div>

@endsection
