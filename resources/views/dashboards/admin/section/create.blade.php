@section('dashboard-content')
<section class="section">

    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" style="height: 708px;">
                <div class="title-block">
                    <h1>Add Section </h1>
                </div>
                <form role="form" action="{{route('section.store')}}" method="POST">
                <div class="row">
                    <div class="col-md-6">
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
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    <a href="{{URL::previous()}}" class="btn btn-warning">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
