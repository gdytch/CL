@section('dashboard-content')
<section class="section">

    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" style="height: 708px;">
                <div class="title-block">
                    <h1>Edit Section </h1>
                </div>
                <form role="form" action="{{route('section.update',$section->id)}}" method="POST">
                <div class="row">
                    <div class="col-md-4">
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
                <div class="form-group">
                    <input type="hidden" name="_method" value="PUT">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    <a href="{{URL::previous()}}" class="btn btn-warning">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
