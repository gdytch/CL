@section('dashboard-content')
    @php $student = Auth::user(); @endphp

    <section class="section">
        <h4 class="card-title text-primary">Activities</h4>
        <hr><br>
        @foreach($activities as $activity)
            <div class="row">
            <div class="col col-12 col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary">{{$activity->name}} @if(count($student->Records->where('activity_id', $activity->id)) > 0) <span class="text-success"><small><i class="fa fa-check-circle"></i> Submitted</small></span>@endif</h4>
                            <hr>
                        </div>
                        <div class="card-content col">
                            activity contents
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </section>
@endsection
