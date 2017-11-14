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
                                        <a href="{{route('exam.open',$page-1)}}" class="btn btn-secondary">Back</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="question-container">
                                    <h1>Finished</h1>
                                    <hr>
                                    <button type="button" class="btn btn-lg btn-primary" name="button" data-toggle="modal" data-target="#finishmodal">Submit Exam</button>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="question-container">

                                </div>
                            </div>
                        <div class="modal fade" id="finishmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h4 class="modal-title" id="">Submit Exam</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              </div>
                              <div class="modal-body">
                                  <form class="" action="{{route('exam.submit')}}" method="post">
                                      {{ csrf_field() }}
                                    <h6>Enter password to confirm</h6>
                                    <input type="password" class="form-control underlined" name="password" value="" required autofocus>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>



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
