@section('dashboard-content')
<section class="section">
    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class=" sameheight-item stats" data-exclude="xs">
                <div class="card-block">
                    <div class="title-block">
                        <h1 class="card-title text-primary"> Section List </h1>
                        <div class="sub-title">
                            <a href="{{route('section.create')}}" class="btn btn-secondary">Add section</a>
                        </div>
                    </div>
                    <div class="card row row-sm stats-container">
                        <div class="col col-12">
                            <table class="table table-striped" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="nosort">Folder</th>
                                        <th class="nosort">Change Status</th>
                                        <th class="nosort"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sections as $section)

                                        <tr>
                                            <td>{{$section->name}}</td>
                                            <td>{{$section->path}}</td>
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

@endsection
