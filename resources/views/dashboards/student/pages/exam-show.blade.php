@section('dashboard-content')
    <div class="row ">
        <div class="col col-12 ">
            <div class=" sameheight-item" >

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
    <div class="col-md-12 col-12 col-sm-12">
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
                                        <div class="col-1">
                                            @if($item_answers[$test_item->id]->correct) <i class="fa fa-check green"></i> @else <i class="fa fa-close red"></i> @endif

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
                                                    @default
                                                             {{$test_item->question}}
                                                @endswitch
                                                <br>
                                            </p>
                                            </li>
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
@endsection