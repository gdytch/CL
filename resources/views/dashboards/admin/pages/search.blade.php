@section('dashboard-content')
    <section class="section">
        <h4 class="card-title text-primary">Search Results for "{{$keyword}}"</h4>
        <hr>
        @if (count($student_result))
            <div class="card">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h3 class="card-title text-primary">   </h3>
                        <p class="title-description"> Result(s) in Students  </p>
                    </div>
                </div>
                <div class="card-block">
                        <table class="table table-striped table-responsive">
                            <tbody>
                                @foreach ($student_result as $student)
                                    <tr>
                                        <td><a href="{{route('student.show',$student->id)}}">{{$student->fname}}</a></td>
                                        <td><a href="{{route('student.show',$student->id)}}">{{$student->lname}}</a></td>
                                        <td><a href="{{route('section.show',$student->section_id)}}">{{$student->sectionTo->name}}</a></td>
                                        <td><a href="{{route('student.folder',$student->id)}}" class="">OPEN FOLDER</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        @endif

        @if (count($activity_result))
            <div class="card">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h3 class="card-title text-primary">  </h3>
                        <p class="title-description"> Result(s) in Activity  </p>
                    </div>
                </div>
                <div class="card-block">
                        <table class="table table-striped table-responsive">
                            <tbody>
                            @foreach ($activity_result as $key => $activity)
                                <tr>
                                    <td>{{$activity->name}}</td>
                                    <td>{{$activity->description}}</td>
                                    <td>{{$activity->section}}</td>
                                    <td>{{$activity->date}}</td>
                                    <td>{{$activity->activity_rule}}</td>
                                    <td>{{$activity->submit_count}}</td>
                                    <td>
                                        @if($activity->active)
                                            <a href="{{route('activity.status',$activity->id)}}" class="btn btn-sm btn-success">Active</a>
                                            @else <a href="{{route('activity.status',$activity->id)}}" class="btn btn-sm btn-danger">Inactive</a>
                                        @endif
                                    </td>

                                    <td>
                                        @if($activity->submission)
                                            <a href="{{route('activity.submission',$activity->id)}}" class="btn btn-sm btn-success">Open</a>
                                        @else <a href="{{route('activity.submission',$activity->id)}}" class="btn btn-sm btn-danger">Close</a>
                                        @endif
                                    </td>
                                    <td><a href="{{route('activity.show',$activity->id)}}" class="btn btn-sm btn-info">View</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        @endif

        @if (count($post_result))
            <div class="card">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h3 class="card-title text-primary"></h3>
                        <p class="title-description">  Result(s) in Activity posts  </p>
                    </div>
                </div>
                <div class="card-block">
                            @foreach($post_result as $post)
                            <div class="row post-container" style="width: 100% !important; max-width:100% !important;">
                                <div class="col col-12 col-md-12 col-xs-12" >
                                    <div class="card">
                                            <div class="card-block" >
                                                    <h4 class="card-title text-primary">
                                                        {{$post->title}}
                                                        @if($post->draft) <small><em class="text-secondary">draft</em></small>@endif
                                                    </h4>
                                                         <a href="{{route('post.edit',$post->id)}}" class="btn btn-sm btn-secondary pull-right">Edit</a>
                                                    <hr>
                                            </div>
                                            <div class="card-block post" style="max-height:300px; overflow:auto">
                                                {!!$post->body !!}
                                            </div>
                                            <div class="card-footer">
                                                <small>
                                                    <em> Date created: {{$post->created_at}} </em>
                                                </small>
                                            </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach


                </div>
            </div>
        @endif
        @if ($no_result)
            No results
        @endif
    </section>
@endsection
