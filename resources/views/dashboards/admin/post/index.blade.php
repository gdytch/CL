@section('dashboard-content')

    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 ">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary">Posts</h4>
                            <a href="{{route('post.create')}}" class="btn btn-secondary " ><i class="fa fa-plus"></i> Create post</a>
                        </div>
                    </div>
                    <div class="card-block">
                        @if($posts != null)
                            @foreach($posts as $post)
                            <div class="row" style="margin-bottom: 50px;">
                                <div class="col col-12 col-md-12 col-xs-12" style=" ">
                                    <div class="card">
                                            <div class="card-block">
                                                    <h4 class="card-title text-primary">
                                                        {{$post->title}}
                                                        @if($post->draft) <small><em class="text-secondary">draft</em></small>@endif
                                                         <a href="{{route('post.edit',$post->id)}}" class="btn btn-sm btn-secondary" style="float:right">Edit</a>
                                                     </h4>
                                                    <hr>
                                            </div>
                                            <div class="card-block post">
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
                            @endforeach
                        @else
                            No posts
                        @endif
                    </div>
                </div>
            </div>
    </section>
@endsection
