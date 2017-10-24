@section('dashboard-content')
<section class="section">
<style>
    .StudentTable{
        width: 100%;

    }
    .StudentTable td:first-child{
        text-align: right;
        padding-right: 20px;
        color: #85CE36;
    }
    .student_avatar{
        width: 100%;
        border-radius: 12px;
        margin-bottom: 10px;
    }

</style>
    <div class="row sameheight-container">
        <div class="col col-12 ">
            <div class="card card-block sameheight-item" style="height: 708px;">
                <div class="title-block">
                    <h1>Edit Student </h1>
                </div>
                <div class="row">
                    <div class=" col-md-2" style="text-align: right">
                        <img src="{{asset('storage/avatar/'.$student->avatar)}}" alt="" class="student_avatar">
                        <a href="#" class="btn btn-info" style="width: 100%;">Change Avatar</a>
                    </div>
                    <form role="form" class="col col-md-4" action="{{route('student.update',$student->id)}}" method="POST">
                        <div class="form-group" >
                            {{csrf_field()}}
                            <label class="control-label col-md-4">First Name</label>
                            <input name="fname" type="text" class="form-control underlined" required="" value="{{$student->fname}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Last Name</label>
                            <input name="lname" type="text" class="form-control underlined" required="" value="{{$student->lname}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Section</label>

                            <select class="form-control" name="section" required="">
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}" @if($section->id == $student->section) selected @endif>{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#passwordModal">
                              Change password
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                              Delete
                            </button>
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                </div>
                <div class="row">
                    <div class="form-group col"><br><br>
                        <button type="submit" name="submit" class="btn btn-primary">Save</button> <a href="{{URL::previous()}}" class="btn btn-warning">Cancel</a>
                    </div>

                </div>
                </form>

            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" action="{{route('student.update', $student->id)}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label col-md-4">New Password</label>
                        <input name="password" type="password" class="form-control underlined" required="">
                    </div>
                    <div class="form-group">
                    <label class="control-label col-md-4">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="form-control underlined" required="" Validate>
                    </div>
                    <input type="hidden" name="_method" value="PUT">

            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                <form class="" action="{{route('student.destroy', $student->id)}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" name="submit" class="btn btn-primary">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
