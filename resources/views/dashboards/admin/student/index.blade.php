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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#batchModal">Batch Add</button>
                        </div>
                    </div>

                    <div class="row row-sm stats-container">
                        <table class="table table-striped" id="StudentTable">
                            <thead>
                                <tr>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Section</th>
                                    <th class="nosort">Folder</th>
                                    <th class="nosort"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{$student->fname}}</td>
                                    <td>{{$student->lname}}</td>
                                    <td>{{$student->sectionTo->name}}</td>
                                    <td>{{$student->path}}</td>
                                    <td><a href="{{route('student.show',$student->id)}}" class="btn btn-sm btn-info">View</a></td>
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

<div class="modal fade" id="batchModal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" action="{{route('student.create.batch')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="file" name="file" value="">
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
