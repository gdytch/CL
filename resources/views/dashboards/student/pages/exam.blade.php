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
        font-size: 12pt;
        text-align: center;
    }
    .question-container .checkbox+span, .radio+span {
        padding: 0 10px 0 0;
        font-size: 10pt;
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

    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h4 class="card-title text-primary"> {{$exam_paper->description}}   </h4>
                        <p class="title-description"> {{$item->Test->name}}. <b>{{$item->Test->test_type}}. </b> <em>{{$item->Test->description}} </em></p>
                    </div>
                </div>
                <div class="card-block">
                <form class="" action="{{route('exam.next')}}" method="post">
                    <div class="row">
                            {{ csrf_field() }}
                            <input type="hidden" name="page" value="{{$page}}">
                            <input type="hidden" name="exam_item_id" value="{{$item->id}}">
                            <div class="col-1">
                                <div class="question-container">
                                    @if($page > 0)
                                        <button type="submit" class="btn btn-secondary" name="prev" value="1">Back</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="question-container">
                                    <p class="question-text"> {{$item->question}} </p>
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
                                            @case('Multiple Choice')
                                            <div class="form-group">
                                                <div>

                                                    @foreach ($item_Choices as $choice)
                                                        <label style="margin-left: 50px">
                                                            <input class="radio" name="answer" type="radio" value='{{$choice}}'  @if($student_answer == $choice) checked @endif>
                                                            <span>{{$choice}}</span>
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
                </form>



                    <div class="row">
                        <div class="col-12 item_nav-container">
                            @php $p = 0; @endphp
                            @foreach ($exam_paper->Tests as $key => $test1)

                            &nbsp;
                            <div class="btn-group" >

                                @foreach ($test1->Items as $key2 => $item2)
                                    @if($item_list[$p]->answered)
                                            <button type="button" class="btn btn-primary @if($p == $page) active @endif">{{$key2+1}}</button>
                                    @else
                                            <button type="button" class="btn btn-secondary @if($p == $page) active @endif">{{$key2+1}}</button>
                                    @endif
                                    @php $p++; @endphp
                                @endforeach


                            </div>
                        @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
