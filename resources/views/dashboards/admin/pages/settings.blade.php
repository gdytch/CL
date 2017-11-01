@section('dashboard-content') @php $admin = Auth::user(); @endphp
<section class="section">
  <h4 class="card-title text-primary">Settings</h4>
  <hr>
  <div class="row sameheight-container">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-header bordered">
          <div class="header-block">
            <h4 class="card-title text-primary"> Admin </h4>
          </div>
          <div class="header-block pull-right">
              <button data-toggle="modal" data-target="#editAdmin" class="btn btn-sm btn-secondary" style="float: right">Edit</button>
          </div>
        </div>
        <div class="card-block">
          <div class="col-md-12">
              <div class="row">
                  <div class=" col-md-4" style="">
                      <img src="{{asset('storage/avatar/'.$admin->avatar)}}" alt="" class="student_avatar">
                  </div>
                  <div class="col" style="margin: 10px">
                      <h6 class="text-primary"><small><strong>Firsname</strong></small></h6>
                      <h4>{{$admin->fname}}</h4>
                      <h6 class="text-primary"><small><strong>Lastname</strong></small></h6>
                      <h4>{{$admin->lname}}</h4>

                  </div>

              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6  col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-header bordered">
          <div class="header-block">
            <h4 class="card-title text-primary">Theme</h4>
          </div>
        </div>
        <div class="card-block">
              <div class="col-md-12">
            <div class="customize-item">
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=red')}}" style="background: #FB494D; border-color: #FB494D; color: #fff;">  </a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=orange')}}" style="background-color: #FE7A0E;border-color: #FE7A0E; color: #fff;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=green')}}" style="background-color: #8CDE33;border-color: #8CDE33; color: #555;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=seagreen')}}" style="background-color: #4bcf99;border-color: #4bcf99; color: #fff;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=blue')}}" style="background-color: #52BCD3;border-color: #52BCD3; color: #fff;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=purple')}}" style="background-color: #7867A7;border-color: #7867A7; color: #fff;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=turquoise')}}" style="background-color: #1abc9c;border-color: #1abc9c;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=red2')}}" style="background-color: #F44336;border-color: #F44336;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=sunflower')}}" style="background-color: #f1c40f;border-color: #f1c40f;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=pink')}}" style="background-color: #E91E63;border-color: #E91E63;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=bright-purple')}}" style="background-color: #9C27B0;border-color: #9C27B0;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=blue2')}}" style="background-color: #2196F3;border-color: #2196F3;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=cyan')}}" style="background-color: #00BCD4;border-color: #00BCD4;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=teal')}}" style="background-color: #009688;border-color: #009688;"></a>
              <a class="btn btn-primary theme-item" href="{{url('admin/theme?theme=blue-grey')}}" style="background-color: #607D8B;border-color: #607D8B;"></a>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="col-md-6  col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-header bordered">
          <div class="header-block">
            <h4 class="card-title text-primary">Filetype Rules </h4>
          </div>
          <div class="header-block pull-right">
              <a href="#" data-toggle="modal" data-target="#addRule" class="btn btn-sm btn-secondary pull-right">Add</a>
          </div>
        </div>
        <div class="card-block">
              <div class="col-md-12">
                <table class="table table-striped table-responsive">
                  <thead>
                    <th>Name</th>
                    <th>Extensions</th>
                    <th></th>
                  </thead>
                  <tbody>
                    @foreach ($filetype_rules as $rule)
                    <tr>
                      <td>
                        <span class="">{{$rule->name}}</span>
                      </td>
                      <td>
                        <span class="">{{$rule->extensions}}</span>
                      </td>
                      <td>
                        @if($rule->name != 'Default')
                        <button type="button" data-target="#editRule{{$rule->id}}" data-toggle="modal" class="btn btn-sm btn-secondary " name="button">Edit</button>
                        <button type="button" data-target="#deleteRule{{$rule->id}}" data-toggle="modal" class="btn btn-sm btn-danger " name="button">Delete</button> @endif
                      </td>
                    </tr>
                    <div class="modal fade" id="editRule{{$rule->id}}" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Rule</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form role="form" action="{{route('filetype_rule.update',$rule->id)}}" method="POST">
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    {{csrf_field()}}
                                    <label class="control-label col-md-4">Rule name</label>
                                    <input name="name" type="text" class="form-control underlined" required value='{{$rule->name}}'>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-md-4">File extensions</label>
                                    <input name="extensions" type="text" class="form-control underlined" placeholder='Separate extensions by comma' required value="{{$rule->extensions}}">
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <input type="hidden" name="_method" value="put">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal fade" id="deleteRule{{$rule->id}}" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Rule</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are you sure to delete '{{$rule->name}}' rule?
                          </div>
                          <div class="modal-footer">
                            <form role="form" action="{{route('filetype_rule.update',$rule->id)}}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="_method" value="delete">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                              <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-header bordered">
          <div class="header-block">
            <h4 class="card-title text-primary">Administrators</h4>
          </div>
          <div class="header-block pull-right">
              <a href="#" data-toggle="modal" data-target="#addAdmin" class="btn btn-sm btn-secondary"style="float:right">Add</a>
          </div>
        </div>
        <div class="card-block">
          <div class="col-md-12">
            <table class="table table-striped table-responsive">
              <thead>
                <tr>
                  <th>Admin</th> <th>Fname</th> <th>Lname</th> <th> </th>
                </tr>
              </thead>
              @foreach ($admins as $admin_item)
                <tr>
                  <td> {{$admin_item->username}} </td>
                  <td> {{$admin_item->fname}}    </td>
                  <td> {{$admin_item->lname}}    </td>
                  <td> @if(!($admin_item->id == Auth::user()->id)) <button type="button" data-target="#deletemodal{{$admin_item->id}}" data-toggle="modal" class="btn btn-sm btn-danger">Delete</button> @endif
                      <div class="modal fade" id="deletemodal{{$admin_item->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      Are you sure to delete this account?
                                  </div>
                                  <div class="modal-footer">
                                      <form class="" action="{{route('admin-user.destroy', $admin_item->id)}}" method="post">
                                          {{csrf_field()}}
                                          <input type="hidden" name="_method" value="DELETE">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                          <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addRule" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Rule</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" action="{{route('filetype_rule.store')}}" method="POST">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  {{csrf_field()}}
                  <label class="control-label col-md-4">Rule name</label>
                  <input name="name" type="text" class="form-control underlined" required>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-4">File extensions</label>
                  <input name="extensions" type="text" class="form-control underlined" placeholder='Separate extensions by comma' required>
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

  <div class="modal fade" id="addAdmin" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Administrator</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
          <form class="form-horizontal" method="POST" action="{{route('admin-user.store')}}">
              {{ csrf_field() }}
              <label for="username" class="col-md-12 control-label">Username</label>
              <input id="username" type="text" class="form-control underlined" name="username" value="{{ old('username') }}" required autofocus>
              <label for="password" class="col-md-12 control-label">Password</label>
              <input id="password" type="password" class="form-control underlined" name="password" required>
              <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>
              <input id="password-confirm" type="password" class="form-control underlined" name="password_confirmation" required>
              <label for="username" class="col-md-12 control-label">Firstname</label>
              <input id="username" type="text" class="form-control underlined" name="fname" value="{{ old('fname') }}" required autofocus>
              <label for="username" class="col-md-12 control-label">Lastname</label>
              <input id="username" type="text" class="form-control underlined" name="lname" value="{{ old('lname') }}" required autofocus>
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

  <div class="modal fade" id="editAdmin" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Admin</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="" method="POST" action="{{route('admin-user.update', $admin->id)}}" enctype="multipart/form-data">
            <div class="row">
                <div class=" col-md-4" style="text-align: right">
                    <img src="{{asset('storage/avatar/'.$admin->avatar)}}" alt="" id="avatar" class="student_avatar">
                    <input type="file" name="avatar_file" value="" onchange="readURL(this);" class="form-control">
                </div>
                <div class="col-md-8">
                        {{ csrf_field() }}
                        <label for="username" class="col-md-12 control-label">Username</label>
                        <input id="username" type="text" class="form-control underlined" name="username" value="{{ $admin->username }}" required >
                        <label for="username" class="col-md-12 control-label">Firstname</label>
                        <input id="username" type="text" class="form-control underlined" name="fname" value="{{$admin->fname }}" required >
                        <label for="username" class="col-md-12 control-label">Lastname</label>
                        <input id="username" type="text" class="form-control underlined" name="lname" value="{{ $admin->lname }}" required >
                        <br>
                        <button type="button" data-toggle="modal" data-target="#changePass" data-dismiss="modal" name="button" class="btn btn-secondary">Change Password</button>
                        <button type="button" data-toggle="modal" data-target="#deleteAdmin" data-dismiss="modal" name="button" class="btn btn-danger">Delete account</button>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
              <input type="hidden" name="_method" value="put">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" data-toggle="modal" data-target="#confirmUpdate" class="btn btn-primary">Update</button>
              <div class="modal fade" id="confirmUpdate" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                  <div class="modal-content">
                    <div class="modal-body">
                      <div class="col-md-12">
                            <div class="form-group">
                              <label class="control-label col">Enter Admin Password</label>
                              <input name="confirm_password" type="password" class="form-control underlined" required="">
                            </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <button type="submit" name="submit" class="btn btn-primary">Continue</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
              <form class="form" action="{{route('admin.update.password', $admin->id)}}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                  <label class="control-label col">New Password</label>
                  <input name="password" type="password" class="form-control underlined" required="">
                  <label class="control-label col">Confirm Password</label>
                  <input name="password_confirmation" type="password" class="form-control underlined" required="" Validate>
                </div>
          </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="_method" value="put">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" data-toggle="modal" data-target="#confirmPassUpdate" class="btn btn-primary">Update password</button>
          <div class="modal fade" id="confirmPassUpdate" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="col-md-12">
                        <div class="form-group">
                          <label class="control-label col">Enter Admin Password</label>
                          <input name="confirm_password" type="password" class="form-control underlined" required="">
                        </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" name="submit" class="btn btn-primary">Continue</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteAdmin" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  Are you sure to delete your account?
              </div>
              <div class="modal-footer">
                  <form class="" action="{{route('admin-user.destroy', $admin->id)}}" method="post">
                      {{csrf_field()}}
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                      <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                  </form>
              </div>
          </div>
      </div>
  </div>




  <script type="text/javascript">
  function readURL(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();

         reader.onload = function (e) {
             $('#avatar')
                 .attr('src', e.target.result)
         };

         reader.readAsDataURL(input.files[0]);
     }
  }
  </script>



</section>

@endsection
