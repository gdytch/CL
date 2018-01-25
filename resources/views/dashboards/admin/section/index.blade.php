@section('dashboard-content')
{{ Breadcrumbs::render('section.index') }}
<section class="section">
    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class=" sameheight-item stats" data-exclude="xs">
                <div class="card-block">
                    <div class="title-block">
                        <h1 class="card-title text-primary"> Section List </h1>
                            <button type="button" data-toggle="modal" data-target="#addmodal" class="btn btn-secondary pull-right"><i class="fa fa-plus"></i> Add section</button>
                    </div>
                    <div class="card row row-sm stats-container">
                        <div class="col col-12">
                            <table class="table table-striped table-responsive" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Students</th>
                                        <th class="nosort">Folder</th>
                                        <th class="nosort" >Login Status</th>
                                        <th class="nosort"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sections as $section)

                                        <tr>
                                            <td>{{$section->name}}</td>
                                            <td>{{count($section->Students)}}</td>
                                            <td><a href="{{route('section.folder',$section->id)}}">{{$section->path}}</a></td>
                                            <td><a href="{{route('section.status', $section->id)}}" class="btn btn-sm @if($section->status) btn-success @else btn-danger @endif" >@if($section->status)Open @else Close @endif</a></td>
                                                <td><a href="{{route('section.show',$section->id)}}" class="btn btn-sm btn-info">View</a></td>
                                            </tr>


                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('section.store')}}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <label class="control-label col-md-4">Section Name</label>
                            <input name="name" type="text" class="form-control underlined" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Folder</label>
                            <input name="path" type="text" class="form-control underlined" required="">
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
