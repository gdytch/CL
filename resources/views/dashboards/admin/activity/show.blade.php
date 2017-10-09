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
                    <h4>Activity</h4>
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
    </div>

    <div class="row ">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h4>Students</h4>
                </div>
                <section class="section">
                    <div class="row">
                            <div class="col-6 col-md-6 col-sm-6">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Student</th>
                                        <th>Submitted</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($activity_log as $log)
                                            @if($log->status)
                                            <tr>
                                                <td>{{$log->name}}</td>
                                                <td>
                                                        <span class="green"><i class="fa fa-check"></i> <b>Yes</b></span>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6 col-md-6 col-sm-6">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Student</th>
                                        <th>Submitted</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($activity_log as $log)
                                            @if(!$log->status)
                                            <tr>
                                                <td>{{$log->name}}</td>
                                                <td>
                                                        <span class="red"><i class="fa fa-close"></i> <b>No</b></span>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
</section>

@endsection
