@section('dashboard-content')
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
                            <h3 class="card-title text-primary">  {{$exam_paper->name}}  </h3>
                            <h4> {{$exam_paper->description}} </h4>
                            <h6 class="text-primary"><small><strong>Date</strong></small></h6>
                            <h4> {{$exam_paper->date}} </h4>
                            <h6 class="text-primary"><small><strong>Student Score</strong></small></h6>
                            <h4> {{$exam_paper->score}} </h4>
                            <h6 class="text-primary"><small><strong>Exam Perfect Score</strong></small></h6>
                            <h4> {{$exam_paper->perfect_score}} </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12 col-lg-6 col-sm-12">
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
                                            <div class="col">
                                                {{-- Question --}}
                                                <li><p> {{$test_item->question}} @if($item_answers[$test_item->id]->correct) <i class="fa fa-check green"></i> @else <i class="fa fa-close red"></i> @endif
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
                                                                @case('Multiple Choice')
                                                                <div class="form-group">
                                                                    <div>

                                                                        @foreach ($test_item->Choices as $choice)
                                                                            <label style="margin-left: 50px">
                                                                                <input class="radio" name="{{$test_item->id}}" type="radio" value='{{$choice->choice}}'  @if($item_answers[$test_item->id]->answer == $choice->choice) checked @else disabled  @endif>
                                                                                <span>{{$choice->choice}}</span>
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


    {{-- Answer key --}}
        <div class="col-md-12 col-12 col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h4 class="card-title text-primary">
                            Answer key
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
                                            <div class="col">
                                                {{-- Question --}}
                                                <li><p> {{$test_item->question}}
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
                                                                            <input class="radio green" name="{{$test_item->id}}ak" type="radio" value="true" @if($test_item->correct_answer == 'true') checked @else disabled @endif>
                                                                            <span>True</span>
                                                                        </label>
                                                                        <label>
                                                                            <input class="radio" name="{{$test_item->id}}ak" type="radio" value="false"  @if($test_item->correct_answer == 'false') checked @else disabled @endif>
                                                                            <span>False</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                @break
                                                                @case('Multiple Choice')
                                                                <div class="form-group">
                                                                    <div>

                                                                        @foreach ($test_item->Choices as $choice)
                                                                            <label style="margin-left: 50px">
                                                                                <input class="radio" name="{{$test_item->id}}ak" type="radio" value='{{$choice->choice}}'  @if($test_item->correct_answer == $choice->choice) checked @else disabled  @endif>
                                                                                <span>{{$choice->choice}}</span>
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


    <div id="bottom"></div>

@endsection
