@section('dashboard-content')
    <style>
    .question-container {
        min-height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .item_nav-container{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
    p.question-text {
        font-size: 14pt;
        text-align: center;
    }
    .question-container .checkbox+span, .radio+span {
        padding: 0 10px 0 0;
        font-size: 11pt;
    }
    .sidebar{
        display: none;
    }
    .app{
        padding-left: 0px;
    }
    .header{
        left: 0px;
    }
    .card{
        background: none;
        border: none;
        box-shadow: none;
    }
    .item_image{
        height: 300px !important;
    }
    .item_image_choice{
        height: 100px;
    }
    .exam_nav{
        line-height: 7px;
        font-size: 9pt;
        padding: 8px;
    }

    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h4 class="card-title text-primary"> <span id="examDescription"></span>   </h4>
                        <p class="title-description"> <span id="itemTestName"></span>. <b><span id="itemTestType"></span>. </b> <em><span id="itemTestDescription"></span> </em></p>
                    </div>
                    {{-- @if($total_answered == count($item_list))
                        <div class="header-block pull-right">
                            <a href="{{route('exam.finish',$exam_id)}}" class="btn btn-primary">Submit Exam</a>
                        </div>
                    @endif --}}
                </div>
                <div class="card-block">

                    <div class="row">
                            <div class="col-1">
                                <div class="question-container">
                                    {{-- @if($page > 0) --}}
                                        <button type="button" class="btn btn-secondary" id="prev">Back</button>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="col-10">
                                <div style="height:64px; margin-bottom: -64px;">
                                    <div class="col hidden" id="progressBar">
                                        <center><div class="lds-ring"><div></div><div></div><div></div><div></div></div></center>
                                    </div>
                                </div>
                                <form class="" action="#" id='examForm' method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="exam_id" value="{{$exam_id}}" id="examId">
                                    <input type="hidden" name="page" value="{{$page}}" id="page">
                                    <input type="hidden" name="next_page" value="" id="nextPage">
                                    <input type="hidden" name="exam_item_id" value="" id="itemId">
                                    <input type="hidden" name="exam_name" value="" id="examPaperName">
                                    <input type="hidden" name="exam_paper_id" value="" id="examPaperId">
                                    <input type="hidden" name="prev_answer" value="" id='prevAnswer'>
                                    <input type="hidden" name='page_max' value='' id="page_max">
                                    <input type="hidden" name='delete_exam_file' value='no' id="delete_exam_file">
                                    <div class="question-container">

                                        <p class="question-text" id="question-text">
                                        </p>
                                        <p class="question-choices" id="question-choices">

                                        </p>
                                    </div>
                                    </form>
                            </div>
                            <div class="col-1">
                                <div class="question-container">
                                    {{-- @if($page < $page_max-1) --}}
                                        <button type="button" class="btn btn-primary"  id="next" >Next</button>
                                    {{-- @else
                                        <button type="button" class="btn btn-primary" name="finish" value="1">Next</button>
                                    @endif --}}
                                </div>
                            </div>

                    </div>



                    <div class="row" id="item_nav">

                    </div>

                </div>
            </div>
        </div>
    </div>


{{csrf_field()}}
<script type="text/javascript">
    function getContents(examId, page){

        $.ajax({
                  type: 'get',
                  url: '/home/exam_Contents/'+ examId +'/'+ page +'',
                  success: function(response) {
                      var data = response;
                      if(data.error != null){

                          $.notify({
                              message: '<b>Error:</b>'+data.error,
                          },{
                              type: 'danger',
                              allow_dismiss: true,
                              placement: {
                                  from: "top",
                                  align: "center"
                              },
                              delay: 5000,
                              offset: 45,

                          });
                          if(data.redirect != 'none')
                              window.location.href = data.redirect;
                      }else{
                          $('#examDescription').text(data.exam_paper.description);
                          $('#itemTestName').text(data.item.test_name);
                          $('#itemTestType').text(data.item.test_type);
                          $('#examId').val(data.exam_id);
                          $('#page').val(data.page);
                          $('#itemId').val(data.item.id);
                          $('#examPaperName').val(data.exam_paper.name);
                          $('#examPaperId').val(data.exam_paper.id);
                          $('#prevAnswer').val(data.student_answer);
                          $('#page_max').val(data.page_max);
                          $('#delete_exam_file').val('no');
                          renderQuestion(data.item, data.exam_file);
                          renderChoices(data.item, data.student_answer, data.item_Choices, data.exam_file);
                          renderItemNav(data.all_tests, data.item_list);
                      }
                  },

              });
    }
    $(document).on('click', '#next', function(event){
        if($('#page').val() == $('#page_max').val())
            window.location.href = '/home/exam/finish/'+$('#examId').val();
        else
           nextPage('next',0);
    });
    $(document).on('click', '#prev', function(event){
       if($('#page').val() == 0)
           $('#prev').attr('disabled', true);
       else
           nextPage('prev',0);
    });
    $(document).on('click', '.exam_nav', function(event){
           nextPage('jump',$(this).val());
    });
    $(document).on('click', '#savebtn', function(event){
           nextPage('jump',$('#page').val());
    });
    $(document).on('click', '#delete_exam_file_button', function(event){
           $('#delete_exam_file').val('yes')
           nextPage('jump',$('#page').val());
    });

    function renderItemNav(Tests, item_list){
        var p = 0;
        var content = '';
        Tests.forEach(function(test) {
          content += '\
          <div class="col-12 item_nav-container">\
              &nbsp;\
              <small>'+ test.name +'</small> &nbsp;\
              <div class="btn-group" >';
              var i;
              for(i = 1; i<=test.number_of_items; i++){
                  if(item_list[p].answered)
                      content += '<button id="nav'+ p +'" type="button" name="jump" value="'+ p +'" class="btn btn-primary  exam_nav">'+i+ '</button>';
                  else
                      content += '<button id="nav'+ p +'" type="button" name="jump" value="'+ p +'" class="btn btn-secondary  exam_nav">'+i+ '</button>';
                  p++;
              }
            content += '\
                      </div>\
                  </div>';

        });
        var current_page = $('#page').val();
        $('#item_nav').html(content);
        $('#nav'+current_page).addClass('active');

    }

    function nextPage(page,pageNo){
        $('#examForm').fadeOut('200');
        $('#progressBar').show();

        $('button').attr('disabled', true);
        switch (page) {
            case 'next':
                pageNo = $('#page').val();
                pageNo++;
                $('#nextPage').val(pageNo);
                break;
            case 'prev':
                pageNo = $('#page').val();
                pageNo--;
                $('#nextPage').val(pageNo);
                break;
            default:
                $('#nextPage').val(pageNo);
        }

        $.ajax({
                  type: 'post',
                  url: '{{route("exam.next")}}',
                  data: new FormData($('#examForm')[0]),
                  processData: false,
                  contentType: false,
                  success: function(response) {
                    console.log(response);
                    $('#question-text').empty();
                    $('#question-choices').empty();
                    getContents(response.exam_id, response.page);
                    $('#examForm').fadeIn('200');
                    $('button').attr('disabled', false);
                    $('#progressBar').hide();
                  }
              });
    }

    function renderQuestion(item, exam_file){

        var content = '';
        var fileCard = 'text';
        switch (item.question_type) {
            case 'image':
                $('#question-text').html(item.question);
                break;
            case 'HTML':
                $('#question-text').html(item.question);
                break;
            case 'post':
                if(exam_file == null){
                    fileCard = '\
                        <div class="col-md-4">\
                                 <h2 class="text-primary">Upload File</h2>\
                                 <div class="form-group">\
                                     <input type="file" name="exam_file" value="" onchange="readURL(this);" class="form-control" >\
                                 </div>\
                                 <img src="" alt="" id="image" class="student_avatar" style="max-width: 100% !important;">\
                                 <button type="button" class="btn btn-primary display_hidden" id="savebtn" name="save_exam_file" value="'+ item.id +'">Save File</button>\
                        </div>';
                }else {
                    var temp;
                    fileCard = '\
                    <div class="col-md-4">\
                        <h3 class="text-primary">Submitted File</h3>\
                        <input type="hidden" name="submitted_exam_file" value="'+exam_file.basename+'">\
                        <div class="file" style="background-color:#fff">';
                    if(exam_file.type.toLowerCase() == 'jpg' || exam_file.type.toLowerCase() == 'jpeg' || exam_file.type.toLowerCase() == 'png')
                        temp = '<img id="file" src="{{asset('storage/')}}'+ exam_file.path+'/'+ exam_file.basename +'    " alt="" class="file-icon">\
                        <p class="file-name">'+ exam_file.name +'.'+ exam_file.type +'</p>\
                        <input type="hidden" name="page_max" value="" id="page_max">\
                        <button type="button" id="delete_exam_file_button" class="btn btn-primary" name="delete_exam_file" value="'+ item.id +'">DELEte file</button>\
                        ';
                    else{
                        temp = '\
                        <img style="width: 200px;" src="{{asset('img/icons')}}'+ '/'+ exam_file.type +'.png" alt="" class="file-icon">\
                        <p class="file-name">'+ exam_file.name +'.'+ exam_file.type +'</p>\
                        </div>\
                        <button type="button" id="delete_exam_file_button" class="btn btn-primary" name="delete_exam_file" value="'+ item.id +'">DELEte file</button>\
                        </div>\
                        ';
                    }
                    // var viewer = new Viewer(document.getElementById("file"));
                    fileCard += temp;
                }

                content = '\
                <div class="row">\
                    <div class="col-md-8">\
                        <div class="card" id="post" style="background: #fff; text-align: left">\
                            <div class="card-header bordered">\
                                <div class="header-block">\
                                    <h3 class="card-title text-primary"> Instructions   </h3>\
                                    <p class="title-description"> </p>\
                                </div>\
                            </div>\
                            <div class="card-block post" style="font-size: 12pt;">\
                                '+ item.question +'\
                            </div>\
                        </div>\
                    </div>\
                    '+ fileCard +'\
                </div>\
                ';
                $('#question-text').html(content);
                break;
            default:
                $('#question-text').html(item.question);
        }

    }

    function renderChoices(item, student_answer, item_Choices){
        switch (item.test_type) {
            case 'True or False':
                var content = '\
                <div class="form-group">\
                    <div >\
                        <label>\
                            <input class="radio" name="answer" type="radio" value="true" id="radioTrue">\
                            <span>True</span>\
                        </label>\
                        <label>\
                            <input class="radio" name="answer" type="radio" value="false" id="radioFalse" >\
                            <span>False</span>\
                        </label>\
                    </div>\
                </div>\
                ';
                $('#question-choices').html(content);
                if(student_answer != null)
                    if(student_answer == 'true')
                        $('#radioTrue').attr('checked', true);
                    else
                        $('#radioFalse').attr('checked', true);

                break;
            case 'Identification':
            case 'Multiple Choice':
                $('#question-choices').html('<div class="form-group"><div id="choices1"></div></div>');
                var choiceText = '';
                var input = '';
                item_Choices.forEach(function(choice) {
                    switch (item.answer_type) {
                        case 'image':
                            choiceText = '<img src="{{asset('photos/shares/')}}'+ choice+'" class="item_image_choice" alt="">';
                            break;

                        default:
                            choiceText = choice;
                    }
                    if(student_answer == choice)
                        input = '<input class="radio" name="answer" type="radio" value="'+ choice +'" checked>';
                    else
                    input = '<input class="radio" name="answer" type="radio" value="'+ choice +'" >';

                    $('#choices1').append('\
                    <label style="margin-left: 50px">\
                        '+ input +'\
                        <span>\
                            '+ choiceText +'\
                        </span>\
                    </label>\
                    ');

                });
                break;
            default:

        }
    }




    window.onload = function () {
        var examId = $('#examId').val();
        var page = $('#page').val();
        getContents(examId, page);
    }

    function readURL(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function (e) {
               $("#image")
                   .attr("src", e.target.result)
           };
           reader.readAsDataURL(input.files[0]);
       }
       var element = document.getElementById("savebtn");
       element.classList.remove("display_hidden");
   }
</script>


@endsection
