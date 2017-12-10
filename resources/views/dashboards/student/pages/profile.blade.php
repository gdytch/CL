@section('dashboard-content')
<section class="section">
    <style>

        .StudentTable{
            width: 100%;

        }
        .StudentTable td:first-child{
            text-align: right;
            padding-right: 20px;
        }
    </style>
    <div class="row ">
        <div class="col-md-3 col-xs-12">
            <div class="col-12 ">
            <div class="card-block sameheight-item" >

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12 col-md-4" style="">
                            <img src="{{asset('storage/avatar/'.$student->avatar)}}" alt="" class="student_avatar">
                        </div>
                        <div class="col-lg-12 col-md-6" style="margin-left: 20px">
                            <h6 class="text-primary"><small><strong>Firstname</strong></small></h6>
                            <h4>{{$student->fname}}</h4>
                            <h6 class="text-primary"><small><strong>Lastname</strong></small></h6>
                            <h4>{{$student->lname}}</h4>
                            <h6 class="text-primary"><small><strong>Section</strong></small></h6>
                            <h4>{{$student->sectionTo->name}}</h4>
                        </div>
                    </div>
                </section>
            </div>

        </div>

        </div>
        <div class="col-md-9 col-xs-12">
            <div class="col col-12 ">
                <div class="card card-block sameheight-item" >
                    <div class="title-block">
                        <h4 class="card-title text-primary"> Activities</h4>
                        <hr>
                    </div>
                    <section class="section">
                        <div class="row">
                            <div class="col-12">
                                @if($table_item != null)
                                    <table class="table table-striped table-responsive">
                                        <thead>
                                            <th>Activity</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Submitted</th>
                                            <th>Files</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @foreach ($table_item as $activity)
                                                <tr>
                                                    <td>{{$activity->name}}</td>
                                                    <td>{{$activity->description}}</td>
                                                    <td>{{$activity->date}}</td>
                                                    <td>

                                                        @if($activity->submitted)
                                                            <span class="green"><i class="fa fa-check"></i> <b>Yes</b></span>
                                                        @else
                                                            <span class="red"><i class="fa fa-close"></i> <b>No</b></span>
                                                        @endif
                                                    </td>


                                                    <td>
                                                        @if($activity->submitted)
                                                            @foreach ($activity->files as $result)
                                                                {{$result->filename}}<br>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('student.activity.show',$activity->id)}}" class="btn btn-sm btn-primary">open <br> activity</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    No Record
                                @endif

                            </div>
                        </div>
                    </section>
                </div>

            </div>

            <div class="col col-12">
                @if($exam_results != null && count($exam_results) > 0)
                    <div class="card">
                        <div class="card-header bordered">
                            <div class="header-block">
                                <h3 class="card-title text-primary">  Exam  </h3>
                                <p class="title-description"> </p>
                            </div>
                        </div>
                        <div class="card-block">
                            <table class="table table-striped table-responsive">
                                <tbody>
                                    @foreach ($exam_results as $key => $exam)
                                        <tr>
                                            <td> <small class="text-primary"><b>Exam: </b></small> {{$exam->description}}</td>
                                            @if($exam->show_to_students)
                                                <td> <small class="text-primary"><b>Date: </b></small> {{$exam->date}}</td>
                                                <td> <small class="text-primary"><b>Score: </b></small> {{$exam->score}}<small>/{{$exam->perfect_score}}</small></td>
                                                <td><a href="{{route('exam.student.show', $exam->exam_id)}}" class="btn btn-sm btn-primary">open</a></td>
                                            @else
                                                <td><p class="text-primary"><b><i class="fa fa-check"></i> Submitted</b></p></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col col-12">
                <div class="card">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="card-title text-primary"> Activity Files  </h3>
                            <p class="title-description"> </p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col">
                            <div class="row files">
                                @if($files != null)
                                    @foreach ($files as $key => $file)
                                        <div class="file-container">
                                            <div class="dropdown ">
                                                  <div class="file">
                                                      @if($file->type == 'jpg' || $file->type == 'jpeg' || $file->type == 'png')
                                                          <img id="file{{$key}}" src="{{asset('storage/'.$file->path.'/'.$file->basename)}}" alt="" class="file-icon">
                                                          <img  src="@if(file_exists(public_path('img/icons/'.$file->type.'.png'))){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-sub-icon">
                                                          <p class="file-name">{{$file->name}}.{{$file->type}}</p>
                                                          <script>
                                                              var viewer = new Viewer(document.getElementById('file{{$key}}'));
                                                          </script>
                                                      @else
                                                          <img src="@if(file_exists(public_path('img/icons/'.$file->type.'.png'))){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon">
                                                          <p class="file-name">{{$file->name}}.{{$file->type}}</p>
                                                      @endif
                                                  </div>
                                            </div>
                                        </div>


                                    @endforeach
                                @else
                                    <p>No Files</p>
                                @endif


                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
{{--
@if(count($student->Sectionto->Activities) > 0)
    <table class="table table-striped">
        <thead>
            <th>Activity</th>
            <th>Date</th>
            <th>Description</th>
            <th>Submitted</th>
            <th>Date Submitted</th>
            <th>File(s)</th>
        </thead>
        <tbody>
            @foreach ($student->Sectionto->Activities()->orderBy('name', 'desc')->get() as $activity)
                <tr>
                    <td>{{$activity->name}}</td>
                    <td>{{$activity->date}}</td>
                    <td>{{$activity->description}}</td>
                    <td>

                        @if(count($student->RecordsOf($activity->id))>0)
                            <span class="green"><i class="fa fa-check"></i> <b>Yes</b></span>
                        @else
                            <span class="red"><i class="fa fa-close"></i> <b>No</b></span>
                        @endif
                    </td>
                    <td>
                        @if(count($student->RecordsOf($activity->id))>0)
                            @foreach ($student->RecordsOf($activity->id) as $result)
                                {{$result->created_at}}<br>
                            @endforeach

                        @endif
                    </td>
                    <td>

                        @if(count($student->RecordsOf($activity->id))>0)
                            @foreach ($student->RecordsOf($activity->id) as $result)
                                {{$result->filename}}<br>
                            @endforeach

                        @endif

                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        No Record
    @endif --}}
