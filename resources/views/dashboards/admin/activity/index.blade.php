@section('dashboard-content')
    @php if(!isset($active)) $active = $sections[0]->id; @endphp
<section class="section">
    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class=" sameheight-item stats" data-exclude="xs">
                <div class="card-block">
                    <div class="title-block">
                        <h1 class="card-title text-primary"> Activity List </h1>
                        <div class="sub-title">
                            <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#addModal">Add Activity</a>
                        </div>
                    </div>
                    <div class="row row-sm stats-container">
                        <div class="col-xl-12  ">
                                <div class=" sameheight-item">
                                    <div class="card-block">
                                        <!-- Nav tabs -->
                                        <div class="card-title-block">

                                        </div>
                                        <ul class="nav nav-tabs nav-tabs-bordered">
                                            @foreach ($sections as $key => $section)
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link @if($active == $section->id)active @endif" data-target="#{{$section->id}}" data-toggle="tab" aria-controls="home" role="tab" aria-expanded="false">{{$section->name}}</a>
                                                </li>

                                            @endforeach


                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content tabs-bordered card">
                                            @foreach ($sections as $key => $section)
                                                <div class="tab-pane @if($active == $section->id)active show @endif fade in" id="{{$section->id}}" @if($active == $section->id)aria-expanded="true" @else aria-expanded="false" @endif>
                                                    <br>
                                                    @if(count($section->Activities) > 0)
                                                        <table class="table table-striped" id="StudentTable{{$section->name}}">
                                                            <thead>
                                                                <tr>
                                                                    <th>Activity</th>
                                                                    <th>Description</th>
                                                                    <th>Published</th>
                                                                    <th class="nosort">Submissions</th>
                                                                    <th width="100">Status</th>
                                                                    <th class="nosort" width="50"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($section->Activities()->orderBy('name', 'desc')->get() as $activity)
                                                                <tr>
                                                                    <td>{{$activity->name}}</td>
                                                                    <td>{{$activity->description}}</td>
                                                                    <td>{{$activity->date}}</td>
                                                                    <td>{{count($activity->Records()->distinct()->get(['student_id']))}}/{{count($section->Students)}}</td>
                                                                    <td>@if($activity->active) <a href="{{route('activity.status',$activity->id)}}" class="btn btn-sm btn-success">Active</a> @else <a href="{{route('activity.status',$activity->id)}}" class="btn btn-sm btn-danger">Inactive</a> @endif </td>
                                                                    <td><a href="{{route('activity.show',$activity->id)}}" class="btn btn-sm btn-info">View</a></td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p>No Activities</p>

                                                    @endif

                                                </div>
                                            @endforeach


                                        </div>
                                    </div>
                                    <!-- /.card-block -->
                                </div>
                                <!-- /.card -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('activity.store')}}" method="POST">
                <div class="row">
                    <div class="col">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <label class="control-label col-md-4">Activity name</label>
                            <input name="name" type="text" class="form-control underlined" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Section</label>
                            <select class="select form-control" name="section_id">
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Date</label>
                            <input name="date" type="date" class="form-control date" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Description</label>
                            <input name="description" type="text" class="form-control date" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection