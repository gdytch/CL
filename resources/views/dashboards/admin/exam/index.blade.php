@section('dashboard-content')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <h4 class="card-title text-primary">Exam Manager</h4>
                <button class="btn btn-secondary pull-right" data-toggle="modal" data-target="#addexammodal"><i class="fa fa-plus"></i> New Exam</button>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col col-12">
                <div class="card">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="card-title text-primary">  Exam List  </h3>
                            <p class="title-description"> </p>
                        </div>
                    </div>
                    <div class="card-block">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <td>Title</td><td>Description</td><td>Exam Paper</td><td>Section</td><td>Active</td><td>Submitted</td><td></td><td>Show to Students</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exams as $exam)
                                    <tr>
                                        <td><a href="{{route('exam.show',$exam->id)}}">{{$exam->name}}</a></td>
                                        <td>{{$exam->description}}</td>
                                        <td>@if($exam->exam_paper_id){{$exam->ExamPaper->name}}@endif</td>
                                        <td>
                                            {{$exam->SectionTo->name}}
                                        </td>
                                        <td>
                                            @if($exam->active)
                                                <a href="{{route('exam.active', $exam->id)}}" class="btn btn-success btn-sm"> <i class="fa fa-check"></i> Yes</a>
                                            @else
                                                <a href="{{route('exam.active', $exam->id)}}" class="btn btn-danger btn-sm"> <i class="fa fa-close"></i> No</a>
                                            @endif
                                        </td>
                                        <td>
                                            {{$exam->submitted}}/{{count($exam->SectionTo->Students)}}
                                        </td>
                                        <td>
                                            @if(!$exam->generated_papers)
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#confirmPublish" name="button">Generate Papers</button>
                                                <div class="modal fade" id="confirmPublish" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-body">
                                                        Are you sure to generate papers for students?<br>
                                                        This action is irreversable.
                                                        <form class="" action="{{route('exam.generate_papers')}}" method="post">
                                                            <input type="hidden" name="id" value="{{$exam->id}}">
                                                            {{ csrf_field() }}
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                        <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                                                        </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($exam->show_to_students)
                                                <a href="{{route('exam.show_to_students', $exam->id)}}" class="btn btn-success btn-sm"> <i class="fa fa-check"></i> Yes</a>
                                            @else
                                                <a href="{{route('exam.show_to_students', $exam->id)}}" class="btn btn-danger btn-sm"> <i class="fa fa-close"></i> No</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4 class="card-title text-primary">Exam Papers</h4>
                <button class="btn btn-secondary pull-right" data-toggle="modal" data-target="#addexampapermodal"><i class="fa fa-plus"></i> New Exam Paper</button>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col col-12">
                <div class="card">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="card-title text-primary"> Exam Paper List  </h3>
                            <p class="title-description"> </p>
                        </div>
                    </div>
                    <div class="card-block">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <td>Title</td><td>Description</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exam_papers as $exam_paper)
                                    <tr>
                                        <td><a href="{{route('exam_paper.show',$exam_paper->id)}}">{{$exam_paper->name}}</a></td>
                                        <td>{{$exam_paper->description}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>



        </div>
    </section>
    <div class="modal fade" id="addexammodal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Exam Paper</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" action="{{route('exam.store')}}" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" >
                                {{csrf_field()}}
                                <label class="control-label col-md-4">Exam Name</label>
                                <input name="name" type="text" class="form-control underlined" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Description</label>
                                <input name="description" type="text" class="form-control underlined" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Exam paper</label>
                                <select class="form-control" name="exam_paper_id">
                                    @foreach ($exam_papers as $exam_paper)
                                        <option value="{{$exam_paper->id}}">{{$exam_paper->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Section</label>
                                <select class="form-control" name="section_id">
                                    @foreach ($sections as $section)
                                        <option value="{{$section->id}}">{{$section->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Add</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addexampapermodal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Exam Paper</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" action="{{route('exam_paper.store')}}" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" >
                                {{csrf_field()}}
                                <label class="control-label col-md-12">Exam Paper Name</label>
                                <input name="name" type="text" class="form-control underlined" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Description</label>
                                <input name="description" type="text" class="form-control underlined" required="">
                            </div>

                            <div class="form-group">
                              <span class="control-label col-md-4">Number of Test</span>
                              <input type="number" name="number_of_test" class="form-control underlined" placeholder="" required>

                            </div>
                            <div class="form-group">
                              <span class="control-label col-md-4">Perfect Score</span>
                              <input type="number" name="perfect_score" class="form-control underlined" placeholder="" required>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Add</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
