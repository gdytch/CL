@section('dashboard-content')
<section class="section">
    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class=" sameheight-item stats" data-exclude="xs">
                <div class="card-block">
                    <div class="title-block">
                        <h1 class="title"> Student List </h1>
                        <br>
                        <div class="sub-title">
                            <a href="{{route('student.create')}}" class="btn btn-primary">Add Student</a>
                        </div>
                    </div>
                    <div class="row row-sm stats-container">
                        <table class="table table-striped" id="DataTable">
                            <thead>
                                <tr>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Section</th>
                                    <th class="nosort">Folder</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{$student->fname}}</td>
                                    <td>{{$student->lname}}</td>
                                    <td>{{$student->section}}</td>
                                    <td>{{$student->path}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
