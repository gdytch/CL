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
        <div class="col-md-6 col-sm-12 sameheight-container">
            <div class="card card-block" >
                <div class="title-block">
                    <h4 class="card-title text-primary">Activity    <button type="button" data-target="#deletemodal" data-toggle="modal" class="btn btn-danger" style="float:right">Delete</button>&nbsp;<button type="button" data-target="#editModal" data-toggle="modal" class="btn btn-secondary" style="float:right; margin-right: 5px">Edit</button></h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="StudentTable">
                                <tr>
                                    <td width="200">Name</td><td><h3>{{$activity->name}}</h3></td>
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
                                <tr>
                                    <td>Filetype Rule</td><td><h3>{{$activity->FTRule->name}}</h3></td>
                                </tr>
                            </table>

                        </div>

                    </div>
                </section>
            </div>

        </div>
        <div class="col-md-6 col-sm-12 sameheight-container">
            <div class="card card-block" >
                <div class="title-block">
                    <h4 class="card-title text-primary">Activity Stats</h4>
                    <hr>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-md-12">
                        Activity stats
                        </div>

                    </div>
                </section>
            </div>

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-block" >
                <div class="title-block">
                    <h4 class="card-title text-primary">Submissions</h4>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-md-12">
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
        <div class="col-md-6 col-sm-12">
            <div class="card card-block">
                <div class="title-block">
                    <h4 class="card-title text-primary">
                        Post: {{$post->title}}
                    </h4>
                    <hr>

                </div>
                <div class="content-block">
                    <div class="col-12">
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('activity.update',$activity->id)}}" method="POST">
                <div class="row">
                    <div class="col">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="put">
                            <label class="control-label col-md-4">Activity name</label>
                            <input name="name" type="text" class="form-control underlined" required value="{{$activity->name}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Section</label>
                            <select class="select form-control" name="section_id">
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}" @if($section->id == $activity->section_id) selected @endif>{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Date</label>
                            <input name="date" type="date" class="form-control date" required value="{{$activity->date}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Description</label>
                            <input name="description" type="text" class="form-control underlined" value="{{$activity->description}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Extension Rule</label>
                            <select class="form-control" name="ftrule_id">
                                @foreach ($filetype_rules as $rule)
                                    <option value="{{$rule->id}}" @if($activity->FTRule->id == $rule->id) selected @endif>{{$rule->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Delete</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          Are you sure to delete this activity?

      </div>
      <div class="modal-footer">
          <form action="{{route('activity.destroy',$activity->id)}}" method="post">
              {{csrf_field()}}
              <input type="hidden" name="_method" value="DELETE">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
              <button type="submit" name="submit" class="btn btn-primary">Yes</button>
          </form>
      </div>
    </div>
  </div>
</div>


@endsection
