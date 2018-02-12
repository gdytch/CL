@section('dashboard-content')
    <style>
    .question-container {
        min-height: 400px;
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
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                            <div class="col-1">
                                <div class="question-container">
                                    @if($page > 0)
                                        <a href="{{route('exam.open',[$exam_id,$page-1])}}" class="btn btn-secondary">Back</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="question-container">
                                    <h1>Finished</h1>
                                    <hr>
                                    <form class="form" style="text-align:center" action="{{route('exam.submit')}}" method="post">
                                        {{ csrf_field() }}
                                      <h6>Enter your <b>Login password</b> to submit</h6>
                                      <input type="hidden" name="exam_paper" value="{{$exam_paper->id}}">
                                      <input type="password" class="form-control underlined" name="password" value="" required autofocus>
                                        <br>
                                      <button type="submit" name="submit" class="btn btn-primary btn-center">Submit</button>
                                  </form>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="question-container">

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
                                                <a href="{{route('exam.open',[$exam_id,$p])}}" class="btn btn-primary @if($p == $page) active @endif exam_nav">{{$key2+1}}</a>
                                        @else
                                                <a href="{{route('exam.open',[$exam_id,$p])}}" class="btn btn-secondary @if($p == $page) active @endif exam_nav">{{$key2+1}}</a>
                                        @endif
                                        @php $p++; @endphp
                                    @endforeach


                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
