@section('dashboard-content')
<section class="section">
    <style>
            .student_avatar{
            width: 80%;
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
                    <h4 class="card-title text-primary"> Profile</h4>
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

                            </table>

                        </div>

                    </div>
                </section>
            </div>

        </div>
    </div>

    <div class="row ">
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
                                <table class="table table-striped">
                                    <thead>
                                        <th>Activity</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Submitted</th>
                                        <th>Date Submitted</th>
                                        <th>Files</th>
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
                                                            {{$result->date_submitted}}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($activity->submitted)
                                                        @foreach ($activity->files as $result)
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
                                @endif

                        </div>
                    </div>
                </section>
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
