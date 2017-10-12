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
        <div class="col-md-4">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h3 class="card-title text-primary">Details</h3>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col">
                            <table class="StudentTable">
                                <tr>
                                    <td>Section</td><td><h5>{{$section->name}}</h5></td>
                                </tr>
                                <tr>
                                    <td>Students</td><td><h5>{{count($section->Students)}}</h5></td>
                                </tr>
                                <tr>
                                    <td>Status</td><td><h5>@if($section->status)<p class="btn btn-primary">Open</p> @else <p class="btn btn-danger">Close</p>@endif </h5></td>
                                </tr>
                                <tr>
                                    <td></td><td><h5><a href="{{route('section.folder',$section->id)}}" class="btn btn-primary">open folder</a></h5></td>
                                </tr>
                                <tr>
                                    <td></td><td><a href="{{route('section.edit', $section->id)}}" class="btn btn-warning">Edit</a></td>
                                </tr>
                            </table>

                        </div>

                    </div>
                </section>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h4 class="card-title text-primary">Stats </h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-md-4">
                            reports

                        </div>

                    </div>
                </section>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h4 class="card-title text-primary">Students</h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col">
                            <table class="table table-striped" id="StudentTable">
                                <thead>
                                    <tr>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th class="nosort">Folder</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($section->Students as $student)
                                        <tr>
                                            <td><a href="{{route('student.show',$student->id)}}">{{$student->fname}}</a></td>
                                            <td><a href="{{route('student.show',$student->id)}}">{{$student->lname}}</a></td>
                                            <td><a href="{{route('student.folder',$student->id)}}" class="btn btn-sm btn-primary">OPEN FOLDER</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </section>
            </div>

        </div>
    </div>
</section>

@endsection
