@section('dashboard-content')
    @php $admin = Auth::user(); @endphp
    <section class="section">
        <h4 class="card-title text-primary">Settings</h4>
        <hr>
        <div class="row sameheight-container">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary"> Password</h4>
                            <hr>
                        </div>
                        <div class="col-md-12">
                                <form class="form" action="{{route('update.password', $admin->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="control-label col">Current Password</label>
                                        <input name="old_password" type="password" class="form-control underlined" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col">New Password</label>
                                        <input name="password" type="password" class="form-control underlined" required="">
                                        <label class="control-label col">Confirm Password</label>
                                        <input name="password_confirmation" type="password" class="form-control underlined" required="" Validate>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary" >Change Password</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary">Theme</h4>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="customize-item">
                                        <a class="btn btn-primary" href="{{url('admin/theme?theme=red')}}" style="background: #FB494D; border-color: #FB494D; color: #fff;"> Red </a>
                                        <a class="btn btn-primary" href="{{url('admin/theme?theme=orange')}}" style="background-color: #FE7A0E;border-color: #FE7A0E; color: #fff;">Orange</a>
                                        <a class="btn btn-primary" href="{{url('admin/theme?theme=green')}}" style="background-color: #8CDE33;border-color: #8CDE33; color: #555;">Green</a>
                                        <a class="btn btn-primary" href="{{url('admin/theme?theme=seagreen')}}" style="background-color: #4bcf99;border-color: #4bcf99; color: #fff;">Seagreen</a>
                                        <a class="btn btn-primary" href="{{url('admin/theme?theme=blue')}}" style="background-color: #52BCD3;border-color: #52BCD3; color: #fff;">Blue</a>
                                        <a class="btn btn-primary" href="{{url('admin/theme?theme=purple')}}" style="background-color: #7867A7;border-color: #7867A7; color: #fff;">Purple</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="card-title text-primary">Filetype Rules <a href="#" data-toggle="modal" data-target="#addRule" class="btn btn-sm btn-secondary"style="float:right">Add</a></h4>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <th width="200">Name</th>
                                    <th width="200">Extensions</th>
                                    <th width="200"></th>
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
                                                <button type="button" data-target="#editRule{{$rule->id}}" data-toggle="modal" class="btn btn-sm btn-secondary " name="button">Edit</button>
                                                <button type="button" data-target="#deleteRule{{$rule->id}}" data-toggle="modal" class="btn btn-sm btn-danger " name="button">Delete</button>
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
                                                                <div class="form-group" >
                                                                    {{csrf_field()}}
                                                                    <label class="control-label col-md-4">Rule name</label>
                                                                    <input name="name" type="text" class="form-control underlined" required value='{{$rule->name}}'>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-4">File extensions</label>
                                                                    <input name="extensions" type="text" class="form-control underlined" placeholder='Separate extensions by comma, type "Any" for all files' required value="{{$rule->extensions}}">
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
                                                        Are you sure to delete this rule?
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
                                <div class="form-group" >
                                    {{csrf_field()}}
                                    <label class="control-label col-md-4">Rule name</label>
                                    <input name="name" type="text" class="form-control underlined" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">File extensions</label>
                                    <input name="extensions" type="text" class="form-control underlined" placeholder='Separate extensions by comma, type "Any" for all files' required>
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


    </section>

@endsection
