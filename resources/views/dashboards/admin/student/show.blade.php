@section('dashboard-content')
<section class="section">
    <style>
            .student_avatar{
            width: 100%;
            border-radius: 12px;
        }
        .StudentTable{
            width: 100%;

        }
        .StudentTable td:first-child{
            text-align: right;
            padding-right: 20px;
        }
    </style>
    <div class="row ">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h1>Student  <a href="{{route('student.edit',$student->id)}}" class="btn btn-warning">Edit</a></h1>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class=" col-md-2" style="text-align: right">
                            <img src="{{asset('storage/avatar/'.$student->avatar)}}" alt="" class="student_avatar">
                        </div>
                        <div class="col">
                            <table class="StudentTable">
                                <tr>
                                    <td width="100">Firstname</td><td><h3>{{$student->fname}}</h3></td>
                                </tr>
                                <tr>
                                    <td>Lastname</td><td><h3>{{$student->lname}}</h3></td>
                                </tr>
                                <tr>
                                    <td>Section</td><td><h3>{{$student->sectionTo->name}}</h3></td>
                                </tr>
                                <tr>
                                    <td></td><td><h3><a href="{{route('student.folder',$student->id)}}" class="btn btn-primary">OPEN FOLDER</a></h3></td>
                                </tr>
                            </table>

                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col col-md-6 col-6 ">
            <div class="card sameheight-item">
                <div class="card-block">
                    <div class="title-block">
                        <h4 class="title"> Files </h4>
                        <hr>
                    </div>
                    <div class="col">
                        <div class="row files">
                            @if($files != null)
                                @foreach ($files as $key => $file)
                                    <div class="file-container">
                                        <div class="dropdown ">
                                          <a id='dropDown{{$key}}' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0">
                                              <div class="file">
                                                  <img src="@if(file_exists($file->path)){{asset('img/icons/'.$file->type.'.png')}} @else {{asset('img/icons/file.png')}}@endif" alt="" class="file-icon">
                                                  <p class="file-name">{{$file->name}}</p>
                                              </div>

                                            </div>
                                        </a>


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
        <div class="col col-md-6 col-6">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h4>Activities</h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-12">
                            @if(count($student->Sectionto->Activities) > 0 && $file_log != null)
                                <table class="table table-striped">
                                    <thead>
                                        <th>Activity</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Submitted</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($student->Sectionto->Activities as $activity)
                                            <tr>
                                                <td>{{$activity->name}}</td>
                                                <td>{{$activity->date}}</td>
                                                <td>{{$activity->description}}</td>
                                                <td>
                                                    @foreach($file_log as $log)
                                                        @if($activity->name == $log->activity)
                                                            @if($log->status)
                                                                <span class="green"><i class="fa fa-check"></i> <b>Yes</b></span>
                                                            @else
                                                                <span class="red"><i class="fa fa-close"></i> <b>No</b></span>
                                                            @endif
                                                        @endif
                                                    @endforeach
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
    </div>
</section>

@endsection
