@section('dashboard-content')

    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 ">
                    <div class="card post-container">
                            <div class="card-block">
                                    <h4 class="card-title text-primary">
                                        {{$post->title}}
                                        @if($post->draft) <small><em class="text-secondary">draft</em></small>@endif
                                         <a href="{{route('post.edit',$post->id)}}" class="btn btn-sm btn-secondary" style="float:right">Edit</a>
                                     </h4>
                                    <hr>
                            </div>
                            <div class="card-block post" id="post">
                                {!!$post->body !!}
                            </div>
                            <div class="card-footer">
                                <small>
                                    <em> Date created: {{date("M d Y", strtotime($post->created_at))}} </em> |
                                    @foreach ($post->Activities as $activity)
                                        <em>{{$activity->name}} {{$activity->SectionTo->name}} </em> •
                                    @endforeach
                                </small>
                            </div>

                    </div>

                </div>
            </div>
    </section>
@endsection
