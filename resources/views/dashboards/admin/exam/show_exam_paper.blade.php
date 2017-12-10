@section('dashboard-content')
    <div class="row">
        <div class="col-12">
            <h4 class="card-title text-primary">
                Exam Paper
            </h4>
        </div>

        <div class="col-12">
            <div class="card" id="exam">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h3 class="card-title text-primary">  {{$exam_paper->name}}  </h3>
                    </div>
                    <div class="header-block">
                        <p class="title-description"> {{$exam_paper->description}} </p>
                    </div>
                    <div class="header-block">
                        <p class="title-description"> Number of test: {{$exam_paper->number_of_test}} </p>
                    </div>
                    <div class="header-block">
                        <p class="title-description"> Perfect score: {{$exam_paper->perfect_score}} </p>
                    </div>
                    <div class="header-block pull-right">
                        <button type="button" data-toggle="modal" data-target="#editExam" class="btn btn-secondary">edit</button>
                        <div class="modal fade" id="editExam" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                          <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="">Edit Exam</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          </div>
                          <div class="modal-body">
                              <form role="form" action="{{route('exam_paper.update',$exam_paper->id)}}" method="POST">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group" >
                                          {{csrf_field()}}
                                          <input type="hidden" name="_method" value="put">
                                          <label class="control-label col-md-12">Exam Paper Name</label>
                                          <input name="name" type="text" class="form-control underlined" required="" value="{{$exam_paper->name}}">
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label col-md-4">Description</label>
                                          <input name="description" type="text" class="form-control underlined" required="" value="{{$exam_paper->description}}">
                                      </div>

                                      <div class="form-group">
                                        <span class="control-label col-md-4">Number of Test</span>
                                        <input type="number" name="number_of_test" class="form-control underlined" placeholder="" required value="{{$exam_paper->number_of_test}}">

                                      </div>
                                      <div class="form-group">
                                        <span class="control-label col-md-4">Perfect Score</span>
                                        <input type="number" name="perfect_score" class="form-control underlined" placeholder="" required value="{{$exam_paper->perfect_score}}">

                                      </div>

                                  </div>
                              </div>
                              </div>
                              <div class="modal-footer">
                              <div class="form-group">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit" class="btn btn-primary">Add</button>
                              </div>
                              </form>
                          </div>
                        </div>
                      </div>
                        </div>
                        <a href="{{route('exam.preview',[$exam_paper->id,0])}}" class="btn btn-primary">preview</a>&nbsp;
                    </div>

                </div>
                <div class="card-block">


                    @foreach ($exam_paper->Tests as $test)
                        <div class="card-block">
                            <div class="row">
                                <div class="col-12">

                                    {{-- Test --}}
                                    {{$test->name}}. <strong>{{$test->test_type}}.</strong> <i>{{$test->description}}</i> <a href="#" data-toggle="modal" data-target="#testeditmodal{{$test->id}}" class="btn btn-sm btn-secondary">Edit</a>

                                    {{-- Test Edit Modal --}}
                                    <div class="modal fade" id="testeditmodal{{$test->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id=""></h4>
                                          </div>
                                          <div class="modal-body">
                                              <form class="" action="{{route('exam_test.update',$test->id)}}" method="POST">
                                                  {{ csrf_field() }}
                                                  <input type="hidden" name="_method" value="put">
                                                  <input type="hidden" name="exam_paper_id" value="{{$exam_paper->id}}">
                                                  <div class="form-group">
                                                      <label for="">Test Name</label>
                                                      <input type="text" name="name" class="form-control underlined" value="{{$test->name}}" placeholder="Name" required>
                                                  </div>

                                                  <div class="form-group">
                                                      <label for="">Test Intructions</label>
                                                      <input type="text" name="description" value="{{$test->description}}" class="form-control underlined"  placeholder="Instructions" required>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="">Number of Items</label>
                                                      <input type="number" name="number_of_items" value="{{$test->number_of_items}}" class="form-control underlined"  placeholder="Number of items" required>
                                                  </div>
                                                  <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#testdeletemodal{{$test->id}}"  class="btn btn-danger form-control">Delete</a>

                                          </div>
                                          <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit"  class="btn btn-primary">Update</button>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal fade" id="testdeletemodal{{$test->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-body">
                                              Are you sure to delete this test?
                                              <form class="" action="{{route('exam_test.delete',$test->id)}}" method="POST">
                                                  {{ csrf_field() }}
                                                  <input type="hidden" name="_method" value="delete">
                                          </div>
                                          <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                <button type="submit"  class="btn btn-primary">Yes</button>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-block col">
                                <ol>

                                    {{-- Question Items --}}
                                    @foreach ($test->Items as $key => $test_item)
                                        <div class="row">
                                            <div class="col">
                                                {{-- Question --}}
                                                <li><p>
                                                    @switch($test_item->question_type)
                                                        @case('image')
                                                                <img src="{{asset('photos/shares/'.$test_item->question)}}" class="item_image" alt="">
                                                                @break;
                                                        @case('HTML')
                                                                {!!$test_item->question!!}
                                                               @break;
                                                        @case('post')
                                                                <div style="border: 1px solid grey; padding: 50px;">
                                                                        {!!$test_item->question!!}
                                                                </div>
                                                                @break;
                                                        @default
                                                                 {{$test_item->question}}
                                                    @endswitch

                                                    <span class="text-primary"><em>---Answer: {{$test_item->correct_answer}} Point(s): {{$test_item->points}}</em></span>
                                                    <a href="#" data-toggle="modal" data-target="#test_item{{$test_item->id}}" class="btn btn-sm btn-secondary">Edit</a>
                                                    <br>
                                                </p>
                                                </li>

                                                @if($test->test_type == 'Multiple Choice' || $test->test_type == 'Identification')
                                                    <div class="row">
                                                        <ol type="a">
                                                            @foreach ($test_item->Choices as $choice)
                                                                    <li style="display: list-item;"> <a href="#" data-toggle="modal" data-target="#test_item_edit_choice{{$choice->id}}">
                                                                        <span style="margin-left: 20px;">
                                                                            @switch($test_item->answer_type)
                                                                                @case('image')
                                                                                        <img src="{{asset('photos/shares/'.$choice->choice)}}" class="item_image" alt="">
                                                                                        @break;
                                                                                @case('HTML')
                                                                                         {!!$choice->choice!!}
                                                                                        @break;
                                                                                @default
                                                                                         {{$choice->choice}}
                                                                            @endswitch
                                                                        </span>
                                                                    </a></li>
                                                                    {{-- Edit choice modal --}}
                                                                    <div class="modal fade" id="test_item_edit_choice{{$choice->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                                      <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                          <div class="modal-header">
                                                                              <h4 class="modal-title" id="">Edit Choice</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                          </div>
                                                                          <div class="modal-body">
                                                                              <form class="" action="{{route('exam_item_choice.update',$choice->id)}}" method="POST">
                                                                                  {{ csrf_field() }}
                                                                                  <input type="hidden" name="_method" value="put">
                                                                                  <input type="hidden" name="exam_item_id" value="{{$test_item->id}}">
                                                                                  <div class="form-group">
                                                                                      <label for="">Question Choice</label>
                                                                                      <input type="text" name="choice" class="form-control underlined" value="{{$choice->choice}}" placeholder="Choice" value="" required>
                                                                                  </div>
                                                                                  <a href="{{route('exam_item_choice.delete',$choice->id)}}" class="btn btn-danger form-control">Delete Choice</a>
                                                                          </div>
                                                                          <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                <button type="submit"  class="btn btn-primary">update</button>
                                                                            </form>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                    <a  href="#" data-toggle="modal" data-target="#test_item_add_choice{{$test_item->id}}" class="btn btn-sm btn-secondary">Add Choice</a>


                                                    {{-- Add choice modal --}}
                                                    <div class="modal fade" id="test_item_add_choice{{$test_item->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                              <h4 class="modal-title" id="">Add Choice</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                          </div>
                                                          <div class="modal-body">
                                                              <form class="" action="{{route('exam_item_choice.store')}}" method="POST">
                                                                  {{ csrf_field() }}
                                                                  <input type="hidden" name="exam_item_id" value="{{$test_item->id}}">
                                                                  <div class="form-group">
                                                                      Question: {{$key+1}}. {{$test->name}}
                                                                      <label for="">Question Choice</label>
                                                                      <input type="text" name="choice" class="form-control underlined"  placeholder="Choice" value="" required>
                                                                  </div>
                                                          </div>
                                                          <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit"  class="btn btn-primary">add</button>
                                                            </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                @endif


                                                {{-- Question Edit modal --}}
                                                <div class="modal fade" id="test_item{{$test_item->id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                          <h4 class="modal-title" id="">Edit</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                      </div>
                                                      <div class="modal-body">
                                                          <form class="" action="{{route('exam_item.update',$test_item->id)}}" method="POST">
                                                              {{ csrf_field() }}
                                                              <input type="hidden" name="_method" value="put">
                                                              <input type="hidden" name="exam_paper_id" value="{{$exam_paper->id}}">
                                                              <input type="hidden" name="exam_test_id" value="{{$test->id}}">


                                                              @switch($test->test_type)
                                                                  @case('True or False')
                                                                      <div class="form-group">
                                                                          <label for="">Question</label>
                                                                          <textarea type="text" name="question" class="form-control underlined"  placeholder="Question" required>{{$test_item->question}}</textarea>
                                                                      </div>
                                                                      <div class="form-group">
                                                                          <label for="">Correct Answer</label>
                                                                          <select class="form-control" name="correct_answer">
                                                                              <option value="true" @if($test_item->correct_answer == 'true') selected @endif >True</option>
                                                                              <option value="false" @if($test_item->correct_answer == 'false') selected @endif>False</option>
                                                                          </select>
                                                                      </div>
                                                                      @break
                                                                  @case('Identification')
                                                                  @case('Multiple Choice')
                                                                          <div class="form-group">
                                                                              <label for="">Question</label>
                                                                              <textarea type="text" name="question" class="form-control underlined"  placeholder="Question" required>{{$test_item->question}}</textarea>
                                                                          </div>
                                                                          <div class="form-group">
                                                                              <select class="form-control" name="question_type">
                                                                                  <option value="text" @if($test_item->question_type == 'text') selected @endif>Text</option>
                                                                                  <option value="HTML" @if($test_item->question_type == 'HTML') selected @endif>HTML code</option>
                                                                                  <option value="image" @if($test_item->question_type == 'image') selected @endif>Image</option>
                                                                              </select>
                                                                          </div>
                                                                          <div class="form-group">
                                                                              <label for="">Correct Answer</label>
                                                                              <input type="text" name="correct_answer" class="form-control underlined" value="{{$test_item->correct_answer}}"  placeholder="Correct Answer" required>
                                                                          </div>
                                                                      @break
                                                                  @case('HandsOn')
                                                                          <div class="form-group" style="width: 100%;">
                                                                              <label class="col-12 control-label"> Hands On Instructions </label>
                                                                              <div class="col-sm-12">
                                                                                  <div id="wyswyg">
                                                                                      <div id="toolbar">

                                                                                      </div>
                                                                                      <!-- Create the editor container -->
                                                                                      {{-- <div id="editor" type="textarea" name="content"> --}}
                                                                                          <textarea id="content"  type="text" name="question" style="width: 100%; height: 800px;" >
                                                                                              {!!$test_item->question!!}
                                                                                          </textarea>
                                                                                      {{-- </div> --}}
                                                                                  </div>
                                                                              </div>
                                                                          </div>
                                                                          <div class="form-group">
                                                                            <label for=""> Answer Type:</label>
                                                                            <input type="hidden" name="correct_answer" value="submitted">
                                                                            <input type="hidden" name="question_type" value="post">
                                                                            <select class="form-control" name="answer_type">
                                                                                  <option value="image"  @if($test_item->answer_type == 'image') selected @endif>Image</option>
                                                                                  <option value="file" @if($test_item->answer_type == 'file') selected @endif>File</option>
                                                                            </select>
                                                                          </div>
                                                                          <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
                                                                          <script>
                                                                            var options = {
                                                                              filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                                                                              filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                                                                              filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                                                                              filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
                                                                            };
                                                                          </script>
                                                                          <script>
                                                                              CKEDITOR.replace('content', options);
                                                                          </script>
                                                                      @break
                                                                  @default
                                                                      <div class="form-group">
                                                                          <label for="">Correct Answer</label>
                                                                          <input type="text" name="correct_answer underlined" class="form-control" value="{{$test_item->correct_answer}}" placeholder="Correct Answer" required>
                                                                      </div>
                                                              @endswitch

                                                              <div class="form-group">
                                                                  <label for="">Points</label>
                                                                  <input type="number" name="points" class="form-control underlined" value="{{$test_item->points}}"  placeholder="Number of points" required>
                                                              </div>
                                                              <a href="{{route('exam_item.delete', $test_item->id)}}" class="btn btn-danger form-control">Delete Question</a>
                                                      </div>
                                                      <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit"  class="btn btn-primary">update</button>
                                                        </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>




                                            </div>
                                        </div>
                                    @endforeach
                                    @if(count($test->Items ) < $test->number_of_items)

                                        {{-- Add Question modal --}}
                                        <div class="row">
                                            <a name="addQuestion"></a>
                                            <div class="col" >
                                                <h5 class="text-primary">Add Question</h5>
                                                <form class="form-inline" action="{{route('exam_item.store')}}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="exam_paper_id" value="{{$exam_paper->id}}">
                                                    <input type="hidden" name="exam_test_id" value="{{$test->id}}">

                                                    @switch($test->test_type)
                                                        @case('True or False')
                                                            <div class="form-group" style="width:100%">
                                                                <input type="text" name="question" class="form-control"  placeholder="Question" required style="width:100%">
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="form-control" name="question_type">
                                                                    <option value="text">Text</option>
                                                                    <option value="HTML">HTML code</option>
                                                                    <option value="image">Image</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="form-control" name="correct_answer">
                                                                    <option value="true">True</option>
                                                                    <option value="false">False</option>
                                                                </select>
                                                            </div>
                                                            @break
                                                        @case('Identification')
                                                        @case('Multiple Choice')
                                                            <div class="form-group" style="width:100%">
                                                                <input type="text" name="question" class="form-control"  placeholder="Question" required style="width:100%">
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="form-control" name="question_type">
                                                                    <option value="text">Text</option>
                                                                    <option value="HTML">HTML code</option>
                                                                    <option value="image">Image</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" name="correct_answer" class="form-control"  placeholder="Correct Answer" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="form-control" name="answer_type">
                                                                    <option value="text">Text</option>
                                                                    <option value="HTML">HTML code</option>
                                                                    <option value="image">Image</option>
                                                                </select>
                                                            </div>
                                                            @break
                                                        @case('HandsOn')

                                                                <div class="form-group" style="width: 100%;">
                                                                    <label class="col-12 control-label"> Hands On Instructions </label>
                                                                    <div class="col-sm-12">
                                                                        <div id="wyswyg">
                                                                            <div id="toolbar">

                                                                            </div>
                                                                            <!-- Create the editor container -->
                                                                            {{-- <div id="editor" type="textarea" name="content"> --}}
                                                                                <textarea id="content"  type="text" name="question" style="width: 100%; height: 800px;"></textarea>
                                                                            {{-- </div> --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                  <label for=""> Answer Type:</label>
                                                                  <input type="hidden" name="correct_answer" value="submitted">
                                                                  <input type="hidden" name="question_type" value="post">
                                                                  <select class="form-control" name="answer_type">
                                                                        <option value="image">Image</option>
                                                                        <option value="file">File</option>
                                                                  </select>
                                                                </div>
                                                                <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
                                                                <script>
                                                                  var options = {
                                                                    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                                                                    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                                                                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                                                                    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
                                                                  };
                                                                </script>
                                                                <script>
                                                                    CKEDITOR.replace('content', options);
                                                                </script>
                                                            @break
                                                        @default
                                                            <div class="form-group">
                                                                <input type="text" name="correct_answer" class="form-control"  placeholder="Correct Answer" required>
                                                            </div>

                                                    @endswitch

                                                    <div class="form-group">
                                                        <label for="">Points:</label>
                                                        <input type="number" name="points" class="form-control" value="1" placeholder="Number of points" required>
                                                    </div>
                                                    <button type="submit"  class="btn btn-primary">Add</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="text-primary">Add Image</h5>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <a href="#" id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                            <i class="fa fa-picture-o"></i> Choose
                                                        </a>
                                                    </span>
                                                    <input type="text" id="thumbnail" class="form-control" name="filepath">
                                                </div>
                                                <img src="" id="holder" style="margin:20px; max-height: 100px;" alt="">
                                            </div>
                                        </div>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    @endforeach
                    @if(count($exam_paper->Tests ) < $exam_paper->number_of_test)
                    <hr>

                    {{-- Add test modal --}}
                    <h5 class="text-primary">Add Test</h5>
                    <form class="form-inline" action="{{route('exam_test.store')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="exam_paper_id" value="{{$exam_paper->id}}">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control"  placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="test_type">
                                <option value="True or False">True or False</option>
                                <option value="Multiple Choice">Multiple Choice</option>
                                <option value="Identification">Identification</option>
                                <option value="HandsOn">Hands On</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="description" class="form-control"  placeholder="Instructions" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="number_of_items" class="form-control"  placeholder="Number of items" required>
                        </div>
                        <button type="submit"  class="btn btn-primary">Add</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <div id="bottom"></div>

@endsection
