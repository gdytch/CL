@section('dashboard-content')

<section class="section">
    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class="sameheight-item stats" data-exclude="xs">
                <div class="card-block">
                    <div class="title-block">
                        <h1 class="card-title text-primary"> Student List
                        </h1>
                            <a href="{{route('student.create')}}" class="btn btn-secondary">Add Student</a>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#batchModal">Batch Add</button>
                        </div>
                    <section class="section">
                        <div class="card row">
                            <div class="col col-12">

                                @php if(!isset($_GET['id'])) $_GET['id']='all'; @endphp
                                <br>
                                <h4 class="card-title">Sections</h4>
                                <a href="{{url('admin/student?id=all')}}" class="btn @if($_GET['id'] == 'all')  btn-primary @else  btn-secondary @endif" >All</a>
                                @foreach ($sections as $key => $section)
                                    <a href="{{url('admin/student?id='.$section->id)}}" class="btn @if($_GET['id'] == $section->id)  btn-primary @else  btn-secondary @endif">{{$section->name}}</a>
                                @endforeach
                            </div>
                            <div class="col col-12" style="padding: 30px;">
                                <table class="table table-striped" id="StudentTable">
                                    <thead>
                                        <tr>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Section</th>
                                            <th class="nosort">Folder</th>
                                            <th>Activities</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td><a href="{{route('student.show',$student->id)}}">{{$student->fname}}</a></td>
                                                <td><a href="{{route('student.show',$student->id)}}">{{$student->lname}}</a></td>
                                                <td><a href="{{route('section.show',$student->sectionTo->id)}}">{{$student->sectionTo->name}}</a></td>
                                                <td><a href="{{route('student.folder',$student->id)}}" class="">OPEN FOLDER</a></td>
                                                <td>{{count($student->Records()->distinct()->get(['activity_id']))}}/{{count($student->sectionTo->Activities)}}</td>
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
