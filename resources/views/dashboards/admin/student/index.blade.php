@section('dashboard-content')

<section class="section">
    <div class="row sameheight-container">
        <div class="col col-12 ">
                <div class="card-block">
                    <div class="title-block">
                        <h1 class="card-title text-primary"> Student List</h1>
                        <div class="row">
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addmodal"><i class="fa fa-plus"></i> Add Student</button>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#batchModal"><i class="fa fa-plus"></i> Batch Add</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @php if(!isset($_GET['id'])) $_GET['id']='all'; @endphp
                                <br>
                                <a href="{{url('admin/student?id=all')}}" class="btn @if($_GET['id'] == 'all')  btn-primary @else  btn-secondary @endif" >All</a>
                                    @foreach ($sections as $key => $section)
                                        <a  href="{{url('admin/student?id='.$section->id)}}" class="btn @if($_GET['id'] == $section->id)  btn-primary @else  btn-secondary @endif">{{$section->name}}</a>
                                        @endforeach

                        </div>
                    </div>
                    <section class="section">
                        <div class="card row">

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

<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('student.store')}}" method="POST">
                <div class="row">
                    <div class=" col-md-4" style="text-align: right">
                        <img src="{{asset('storage/avatar/default-avatar.png')}}" alt="" class="student_avatar">
                        <a href="#" class="btn btn-info" style="width: 100%; ">Select Avatar</a>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <label class="control-label col-md-4">First Name</label>
                            <input name="fname" type="text" class="form-control underlined" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Last Name</label>
                            <input name="lname" type="text" class="form-control underlined" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Password</label>
                            <input name="password" type="password" class="form-control underlined" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Section</label>

                            <select class="form-control " name="section" required="">
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
