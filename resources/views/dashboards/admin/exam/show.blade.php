@section('dashboard-content')
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="card-title text-primary">  {{$exam->name}}  </h3>
                            <p class="title-description"> {{$exam->description}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
          <div class="col-12">
                 <div class="card">
                     <div class="card-header bordered">
                         <div class="header-block">
                             <h3 class="card-title text-primary">  Exam Result  </h3>
                             <p class="title-description"> {{$section->name}} </p>
                         </div>
                         <div class="header-block">
                             <p class="title">Perfect Score: {{$exam_paper->perfect_score}}</p>
                         </div>
                     </div>
                     <div class="card-block">
                         <table class="table table-striped table-responsive">
                             <thead>
                                 <tr><th>Student</th><th>Submitted</th><th>Score</th></tr>
                             </thead>
                             <tbody>
                                 @foreach ($students as $key => $student)
                                     <tr>
                                         <td><a href="{{route('exam.show.student',[$exam->id, $student->id])}}">{{$student->lname}}, {{$student->fname}}</a></td>
                                         <td>
                                             @if($student->submitted)
                                                 <span class="green"> <i class="fa fa-check"></i> <strong>Yes</strong> </span>
                                            @else
                                                <span class="red"> <i class="fa fa-close"></i> <strong>No</strong> </span>
                                            @endif
                                         </td>
                                         <td>
                                             {{$student->score}}
                                         </td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>
          </div>
        </div>
    </section>
@endsection
