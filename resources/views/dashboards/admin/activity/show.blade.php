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
        <div class="col-6 ">
            <div class="card card-block" >
                <div class="title-block">
                    <h4 class="card-title text-primary">Activity</h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col">
                            <table class="StudentTable">
                                <tr>
                                    <td width="100">Name</td><td><h3>{{$activity->name}}</h3></td>
                                </tr>
                                <tr>
                                    <td>Date</td><td><h3>{{$activity->date}}</h3></td>
                                </tr>
                                <tr>
                                    <td>Description</td><td><h3>{{$activity->description}}</h3></td>
                                </tr>
                                <tr>
                                    <td>Section</td><td><h3>{{$activity->SectionTo->name}}</h3></td>
                                </tr>
                            </table>

                        </div>

                    </div>
                </section>
            </div>

        </div>
        <div class="col-6 ">
            <div class="card card-block" >
                <div class="title-block">
                    <h4 class="card-title text-primary">Activity Stats</h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col">
                        Activity stats
                        </div>

                    </div>
                </section>
            </div>

        </div>
    </div>
    <div class="row">

        <div class="col col-6 ">
            <div class="card card-block" >
                <div class="title-block">
                    <h4 class="card-title text-primary">Submissions</h4>
                </div>
                <section class="section">
                    <div class="row">
                            <div class="col-12 col-md-12 col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Student</th>
                                        <th>Submitted</th>
                                        <th>Submitted on</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($activity_log as $log)
                                            @if($log->status)
                                            <tr>
                                                <td><a href="{{route('student.show',$log->id)}}">{{$log->name}}</a></td>
                                                <td><span class="green"><i class="fa fa-check"></i> <b>Yes</b></span></td>
                                                <td>{{$log->submitted_at}}</td>
                                            </tr>
                                            @endif
                                        @endforeach

                                        @foreach ($activity_log as $log)
                                            @if(!$log->status)
                                            <tr>
                                                <td><a href="{{route('student.show',$log->id)}}">{{$log->name}}</a></td>
                                                <td>
                                                        <span class="red"><i class="fa fa-close"></i> <b>No</b></span>
                                                </td>
                                                <td></td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </section>
                </div>
            </div>

            @if($post != null || count($post) != 0)
                <div class="col col-6">
                    <div class="card card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary">
                                Post: {{$post->title}}
                            </h4>
                            <hr>

                        </div>
                        <div class="content-block">
                            <div class="col col-12">
                                    <div class="card-block post ">
                                        {!!$post->body!!}
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
</section>

@endsection
