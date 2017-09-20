<div class="container" style="padding-top: 60px;">
@if(count($errors) > 0)
    @foreach ($errors->all() as $error)
      <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">×</button>
        {{$error}}
      </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
      {{session('success')}}
    </div>
  </dv>
@endif
@if(session('error'))
  <div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
    {{session('error')}}
  </div>
@endif

</div>
