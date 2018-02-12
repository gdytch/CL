@section('dashboard-content')
{{ Breadcrumbs::render('section.show', $section) }}
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
    <div class="row sameheight-container">
        <div class="col-md-4">
            <div class="card card-block sameheight-item" >
                <div class="title-block">
                    <h3 class="card-title text-primary">Details <button data-toggle="modal" data-target="#editmodal" class="btn btn-sm btn-secondary" style="float: right">Edit</button></h3>
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
                                    <td>Status</td><td><h5>@if($section->status)<p class="btn btn-success">Open</p> @else <p class="btn btn-danger">Close</p>@endif </h5></td>
                                </tr>
                                <tr>
                                    <td></td><td><h5><a href="{{route('section.folder',$section->id)}}" class="btn btn-secondary">open folder</a></h5></td>
                                </tr>
                                <tr>
                                    <td></td><td></td>
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
                    <h4 class="card-title text-primary">Activity Chart </h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-12">
                            <div id="morris-bar-chart"></div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-block sameheight-item">
                <div class="title-block">
                    <h4 class="card-title text-primary">Activity Table</h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col">
                            <table class="table table-striped table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <th>First name</th>
                                        @foreach($activities as $activity)
                                            <th>{{$activity->name}}</th>
                                        @endforeach
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                    <tr>
                                        <td>
                                            <a href="{{route('student.show',$student->id)}}">{{$student->lname}}, {{$student->fname}}</a>
                                        </td>
                                         @foreach($activities as $activity)
                                            <th>{!!$activity_table[$student->id][$activity->id]!!}</th>
                                        @endforeach
                                        <td width="100">
                                            <a href="{{route('student.folder',$student->id)}}" class="btn btn-sm btn-primary">OPEN FOLDER</a>
                                        </td>
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
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('section.update',$section->id)}}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <label class="control-label col-md-4">Section Name</label>
                            <input name="name" type="text" class="form-control underlined" required="" value="{{$section->name}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Folder</label>
                            <input name="path" type="text" class="form-control underlined" required="" value="{{$section->path}}" disabled>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="status">
                                <option value="1" @if($section->status) selected @endif>Open</option>
                                <option value="0" @if(!$section->status) selected @endif>Close</option>
                            </select>
                        </div>
                    </div>
                </div>
                    <input type="hidden" name="_method" value="PUT">
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">update</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
