<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Student;
use App\Activity;
use App\Admin;
use App\Section;
use App\Stats;
use App\Exam;
use App\Exam_Entry;
use App\Exam_Answer;
use App\Exam_Item;
use Auth;
use Session;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web')->except('checkUser', 'login', 'welcome', 'checkUserSection');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Auth::user();
        $todays_activity = null;
        $message_infos   = null;
        if (env('APP_URL') == 'https://computerclassapp.herokuapp.com/') {
            $message_infos[0] = "Heroku Demo, file uploads will be deleted in every dyno restart (deployment)";
        }

        $files = app('App\Http\Controllers\StudentsController')->getFiles($student);

        $activities = $student->SectionTo->Activities()->where(['active' => true, 'submission' => true])->orderBy('date', 'desc')->get();

        foreach ($activities as $key => $activity) {
            if (($activity->date == date("Y-m-d", time())) && ($activity->Post != null)) {
                $todays_activity[$key] = $activity;
                $todays_activity[$key]['post'] = $activity->Post;
                if(count($student->RecordsOf($activity->id)) != 0)
                    $todays_activity[$key]['submitted'] = true;
            }
        }

        //Exam_Paper
        $exams = Exam::where(['section_id' => $student->section, 'active' => true])->get();
        $exam_paper = array();
        if(count($exams) > 0){
            foreach ($exams as $key => $exam) {
                $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'active' => true, 'exam_id' => $exam->id])->get()->first();
                if(count($exam_entry) > 0){
                        $exam_paper[$key] = $exam_entry->Exam_Paper($exam_entry->exam_id);
                }
            }
        }

        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.home',
            'student'           => $student,
            'files'             => $files,
            'activities'        => $activities,
            'todays_activity'   => $todays_activity,
            'message_infos'     => $message_infos,
            'exam_paper'        => $exam_paper,
            'exams'             => $exams,
        );
        return view('layouts.student')->with($variables);
    }



    public function login(Request $request)
    {
        $error = null;
        $redirect = null;

        if ($request->id == null) {
            return response()->json([
                'error'    => 'Select an account',
                'redirect' => $redirect
            ]);
        }

        $student = Student::find($request->id);
        if(!$student->sectionTo->status)
            return response()->json([
                'error'    => 'Section Closed',
                'redirect' => $redirect
            ]);

        if (Auth::guard('web')->attempt(['id' => $request->id, 'password' => $request->password])) {
            $this->recordLogin($request->id);
            // return redirect()->intended('home');
            $redirect = route('home');
        }else{
            $error = 'Invalid password';
        }

        $admins = Admin::all();
        foreach ($admins as $value) {
            if(Hash::check($request->password, $value->password)){
                Auth::login($student);
                $redirect = route('home');
            }
        }

        return response()->json([
            'error'    => $error,
            'redirect' => $redirect
        ]);
        // return redirect()->back()->withError('Invalid Password')->with('error', 'Invalid password')->withInput();
    }



    public function checkUser(Request $request)
    {
        $users = null;
        $error = 'null';
        if ($request->lname != null) {
            $lname = ucwords(strtolower($request->lname));
            $users = Student::where('lname', $lname)->get()->except('password');
            foreach ($users as $key => $user) {
                $users[$key]['avatar_file'] = ''. asset('storage/avatar/'.$user->avatar). '';
                $users[$key]['section_name'] = $user->sectionTo->name;
                $users[$key]['section_status'] = $user->sectionTo->status;
            }
        }
        if ($request->id != null) {
            $users = Student::where('id', $request->id)->get()->except('password');
        }

        if($users == null)
            $error = 'Error: no user indicated';

        if (count($users) == 0) {
            $error = 'User not found';
        }

        if(strtolower($request->lname) == 'admin')
        return response()->json([
            'redirect' => route('admin.login.form'),
            'users' => $users,
        ]);

        // return view('auth.login')->with('users', $users)->with('message_info', $message_info);
        return response()->json([
            'users' => $users,
            'error' => $error
        ]);
    }

    public function checkUserSection(Request $request)
    {
        $sections = [];
        $this_section = null;
        foreach ($request->sections as $key => $section) {
            $this_section = Section::find($section);
            $sections[$key] = ['name' => $this_section->name, 'status' => $this_section->status];
        }

        return response()->json($sections);
    }

    public function welcome()
    {
        if (Auth::guard('web')->check()) {
            return redirect('home');
        }
        if (Auth::guard('admin')->check()) {
            return redirect('admin');
        }

        if (env('APP_URL') == 'https://computerclassapp.herokuapp.com/') {
            $message_infos[0] = "Heroku demo <br> Lastname: <strong>Demo, Demo2, Demo3, Demo4, Demo5</strong>";
            $message_infos[1] = "For admin click <a href='/admin'>here</a>";
        } else {
            $message_infos = null;
        }

        return view('welcome')->with('message_infos', $message_infos);
    }



    public function trash()
    {
        $student = Auth::user();
        $directory = "/".$student->sectionTo->path."/".$student->path."/trash/";
        $contents = Storage::allFiles($directory);
        $files = null;

        if ($contents != null) {
            foreach ($contents as $key => $file) {
                $file = pathinfo((string)$file."");
                $temp = explode("id=", $file['filename']);
                $file_id = $temp[1];
                $file['filename'] = $temp[0];
                $files[$key] = (object) array(
                  'name'     => $file['filename'],
                  'type'     => $file['extension'],
                  'path'     => $file['dirname'],
                  'id'       => $file_id,
                  'basename' => $file['basename']);
            }
        }

        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.trash',
            'student'           => $student,
            'files'             => $files
        );

        return view('layouts.student')->with($variables);
    }



    public function settings()
    {
        $student = Auth::user();

        $variables = array(
           'dashboard_content' => 'dashboards.student.pages.settings',
           'student' => $student,
        );

        return view('layouts.student')->with($variables);
    }



    public function profile()
    {
        $student = Auth::user();

        $table_item = app('App\Http\Controllers\StudentsController')->checkActivities($student);
        $exam_results = $this->studentExamPaper($student);
        $files = app('App\Http\Controllers\StudentsController')->getFiles($student);

        $variables = array(
           'dashboard_content' => 'dashboards.student.pages.profile',
           'student'           => $student,
           'table_item'        => $table_item,
           'exam_results'      => $exam_results,
           'files'             => $files,
        );

        return view('layouts.student')->with($variables);
    }



    public function activity()
    {
        $student = Auth::user();
        $activities = $student->sectionTo->Activities()->where('active', true)->orderBy('created_at', 'desc')->get();

        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.activity',
            'activities'        => $activities,
        );

        return view('layouts.student')->with($variables);
    }



    public function recordLogin($id)
    {
        $student = Auth::user();

        $date = date("Y-m-d", time());

        $stat = Stats::where(['date' => $date, 'section_id' => $student->section])->get()->first();

        if($stat != null){
            if($student->last_login != $date){
                $stat->value += 1;
                $stat->update();
            }
        }else{
            $stat = new Stats();
            $stat->name = $student->sectionTo->name;
            $stat->section_id = $student->section;
            $stat->date = $date;
            $stat->value = 1;
            $stat->category = "Login History";
            $stat->save();
        }
        $student->last_login = date("Y-m-d");
        $student->session_id = Session::getId();
        $student->update();

    }



    public function pingSession()
    {
        $student = Auth::user();
        if($student != null || count($student) != 0)
        return response()->json(['message' => 'ping']);
    }


    public function checkConnection()
    {
        $student = Auth::user();
        if($student != null || count($student) != 0)
            return response()->json(['message' => 'ping']);
    }


    public function update_password(Request $request, $id)
    {
        $this->Validate($request, [
            'password' => 'confirmed|min:5'
        ]);

        $student = Student::find($id);

        if (!Hash::check($request->old_password, $student->password)) {
            return redirect()->back()->withError('Incorrect password');
        }

        $student->password = $request->password;
        $student->save();

        Auth::logout();
        // return redirect()->route('welcome');
        return redirect('/checkUser?id='.$student->id)->withSuccess('Enter new password');
    }

    public function update_Avatar(Request $request)
    {
        $this->Validate($request, [
            'avatar_file' => 'file|max:10000',
        ]);

        $student = Auth::user();

        //new avatar
        if ($request->hasFile('avatar_file')) {
            $avatar = $request->file('avatar_file');
            $filename = $student->lname."-".$student->fname." - ".time().".".$avatar->getClientOriginalExtension();
            if ($student->avatar != 'default-avatar.png') {
                Storage::delete("avatar/".$student->avatar);
            }
            Image::make($avatar)->fit(250)->save(public_path().'/storage/avatar/'.$filename);

            $student->avatar = $filename;
            $student->update();
        }


        return redirect()->back()->withSuccess('Avatar updated');

    }


    public function showActivity($id)
    {
        $activity = Activity::find($id);
        $post = $activity->Post;
        $student = Auth::user();
        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.activity-show',
            'student'           => $student,
            'activity'          => $activity,
            'post'              => $post,

        );
        return view('layouts.student')->with($variables);
    }

    public function exam_page($id, $page)
    {
        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.exam',
            'exam_id'           => $id,
            'page'              => $page
        );
        return view('layouts.student')->with($variables);
    }

    public function exam_contents($id, $page)
    {

        $student = Auth::user();

        $exam = Exam::find($id);
        if(!$exam->active)
            return response(['error'=> 'Access Denied', 'redirect' => route('home')]);

        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'active' => true, 'exam_id' => $exam->id])->get()->first();
        if($exam_entry == null)
            return response(['error'=> 'Access Denied', 'redirect' => route('home')]);

        $exam_paper = $exam_entry->Exam_Paper($exam_entry->exam_id);

        $item_list = Exam_Answer::where('exam_entry_id', $exam_entry->id)->get();

        if(!isset($item_list[$page]))
            return response(['error'=> 'Invalid Item', 'redirect' => 'none']);


        $total_answered = 0;
        $item_Choices = array();
        $page_max = $page_count = count($item_list);
        $item_id = $item_list[$page]->exam_item_id;
        $item = Exam_Item::find($item_id);
        $student_answer = $item_list[$page]->answer;
        foreach ($item_list as $key => $item1) {
            if($this->itemAnswered($exam_entry->id, $item1->exam_item_id)){
                $item_list[$key]['answered'] = true;
                $total_answered++;
            }else
                $item_list[$key]['answered'] = false;

        }

        foreach ($item->Choices as $key => $choice) {
            $item_Choices[] = $choice->choice;
        }
        shuffle($item_Choices);
        $exam_file = null;
        if($item->Test->test_type == 'HandsOn' && $student_answer != null){
            $directory = "/".$student->sectionTo->path."/".$student->path."/exam_files";
            $exam_file = $directory."/".$student_answer;
            $file = pathinfo((string)$exam_file."");
            $temp = explode("item_id=", $file['filename']);
            $file_id = $temp[1];
            $file['filename'] = $temp[0];
            $exam_file = (object) array('name' => $file['filename'], 'type' => $file['extension'], 'path' => $file['dirname'], 'id' => $file_id, 'basename' => $file['basename']);

        }
        $item['test_name'] = $item->Test->name;
        $item['test_type'] = $item->Test->test_type;
        $item['test_description'] = $item->Test->description;

        if($item->question_type == 'image')
            $item->question = '<img src="'. asset('photos/shares/'.$item->question). '" class="item_image" alt="">';

        $variables = array(
            'student'           => $student,
            'exam_paper'        => $exam_paper,
            'all_tests'         => $exam_paper->Tests,
            'item_list'         => $item_list,
            'item'              => $item,
            'page'              => $page,
            'page_max'          => $page_max-1,
            'student_answer'    => $student_answer,
            'item_Choices'      => $item_Choices,
            'total_answered'    => $total_answered,
            'exam_file'         => $exam_file,
            'exam_id'           => $exam->id

        );
        return response()->json($variables);
        // return view('layouts.student')->with($variables);
    }



    public function itemAnswered($entry_id, $item_id)
    {
        $result = Exam_Answer::where(['exam_entry_id' => $entry_id, 'exam_item_id' => $item_id])->get()->first();
        if($result->answer != null)
            return true;
        return false;
    }


    public function NextPage(Request $request)
    {

        $student   = Auth::user();
        $page = $request->next_page;


        $answer = $request->answer;

        if(isset($request->submitted_exam_file)){
            $answer = $request->submitted_exam_file;
        }

        if($request->delete_exam_file == 'yes'){
            $answer = null;
            $directory = '/'.$student->sectionTo->path."/".$student->path."/exam_files";
            Storage::delete($directory."/".$request->submitted_exam_file);
        }

        $exam_id = $request->exam_id;

        if(isset($request->exam_file)){
            $this->Validate($request, [
                'exam_file'     => 'max:30000',
            ]);
            $directory = '/'.$student->sectionTo->path."/".$student->path."/exam_files";
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory, 0777, true);
            }
            $file = $request->file('exam_file');
            $extension = $file->getClientOriginalExtension();

            $filename = $request->exam_name." - ".$student->lname." item_id=".$request->exam_item_id.".".$extension;
            if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' ){
                $img = Image::make($request->file('exam_file'));
                $img->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save(public_path().'/storage'.$directory.'/'.$filename);
            }
            else
                $request->file('exam_file')->storeAs($directory, $filename);
            $answer = $filename;
        }

        if($answer != $request->prev_answer)
            $this->saveAnswer($answer, $request->exam_item_id,$exam_id);


        return response()->json(['page' => $page, 'exam_id' => $exam_id]);
        // return redirect()->route('exam.open',[$exam_id,$page]);
    }


    public function saveAnswer($answer, $item_id,$exam_id)
    {

        $student = Auth::user();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'active' => true, 'exam_id' => $exam_id])->get()->first();
        if($exam_entry == null)
            return redirect('home')->withError('Access Denied');
        $exam = Exam::find($exam_entry->exam_id);
        if(!$exam->active)
            return redirect('home')->withError('Access Denied');

        $answer_field = Exam_Answer::where(['exam_entry_id' => $exam_entry->id, 'exam_item_id' => $item_id])->get()->first();
        $answer_field->answer = $answer;

        $exam_item = Exam_Item::find($item_id);
        if($exam_item->points_type == 'Auto'){
            $answer_field->points = $exam_item->points;
        }
        else if($answer != null){
            $answer_field->points = 1;
            $answer = 'submitted';
        }
        $answer_field->correct = $this->checkAnswer($answer, $item_id);
        $answer_field->update();



    }

    public function checkAnswer($answer, $item_id)
    {

        $exam_item = Exam_Item::find($item_id);
        if(strtolower($exam_item->correct_answer) == strtolower($answer))
            return true;

        return false;
    }

    public function ExamFinish($exam_id)
    {
        $student = Auth::user();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'active' => true, 'exam_id' => $exam_id])->get()->first();
        $exam_paper = $exam_entry->Exam_Paper($exam_entry->exam_id);

        $item_list = Exam_Answer::where('exam_entry_id', $exam_entry->id)->get();

        $page_max = $page_count = count($item_list);
        $page = $page_max;


        foreach ($item_list as $key => $item1) {
            if($this->itemAnswered($exam_entry->id, $item1->exam_item_id))
                $item_list[$key]['answered'] = true;
            else
                $item_list[$key]['answered'] = false;

        }
        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.exam-finish',
            'student'           => $student,
            'exam_paper'        => $exam_paper,
            'item_list'         => $item_list,
            'page'              => $page,
            'page_max'          => $page_max,
            'exam_id'           => $exam_id


        );
        return view('layouts.student')->with($variables);
    }


    public function ExamSubmit(Request $request)
    {

        $student = Auth::user();

        $invalid = false;
        if(!Hash::check($request->password, $student->password))
            $invalid = true;


        $admins = Admin::all();
        foreach ($admins as $value) {
            if(Hash::check($request->password, $value->password) ){
                $invalid = false;
                break;
            }
        }


        if($invalid)
            return redirect()->back()->withError('Invalid Password');

        $exam = Exam::where(['section_id' => $student->section, 'exam_paper_id' => $request->exam_paper])->get()->first();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'exam_id' => $exam->id])->get()->first();
        $correct_answers = Exam_Answer::where(['exam_entry_id' => $exam_entry->id, 'correct' => true])->get();
        $score = 0;
        if(count($correct_answers) > 0)
            foreach ($correct_answers as $key => $answer_entry) {
                $score += $answer_entry->points;
            }
        $date = date("Y-m-d", time());
        $exam_entry->date = $date;
        $exam_entry->score = $score;
        $exam_entry->active = false;
        $exam_entry->update();

        return redirect()->route('student.profile')->withSuccess('Exam Submitted');
    }



    public function studentExamPaper($student)
    {
        $exam_entries = Exam_Entry::where(['student_id' => $student->id, 'active' => false])->get();
        if(count($exam_entries) == 0)
            return null;
        $exam_results = null;
        foreach ($exam_entries as $key => $exam_entry) {
            $exam = Exam::find($exam_entry->exam_id);
            $exam_paper = $exam->ExamPaper;
            $exam_paper['date'] = $exam_entry->date;
            $exam_paper['score'] = $exam_entry->score;
            $exam_paper['exam_id'] = $exam->id;
            $exam_paper['submitted'] = $exam_entry->active;
            $exam_paper['show_to_students'] = $exam->show_to_students;
            $exam_results[$key] = $exam_paper;

        }

        return $exam_results;
    }



    public function showStudentExamPaper($id)
    {
        $exam = Exam::find($id);
        if($exam == null || count($exam) == 0 || $exam->show_to_students == false)
            return redirect()->back()->withError('Error');
        $exam_paper = $exam->ExamPaper;
        $student = Auth::user();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'exam_id' => $exam->id])->get()->first();
        if($exam_entry == null)
            return redirect()->back()->withError('Error');
        $exam_paper['date'] = $exam_entry->date;
        $exam_paper['score'] = $exam_entry->score;
        foreach ($exam_paper->Tests as $key => $test) {
            foreach ($test->Items as $key2 => $item) {
                $answer_entry = Exam_Answer::where(['exam_entry_id' => $exam_entry->id, 'exam_item_id' => $item->id])->get()->first();
                $item_answers[$item->id] = (object) array('answer' => $answer_entry->answer, 'correct' => $answer_entry->correct);
                if($test->test_type == 'HandsOn' && $answer_entry->answer != null){
                    $directory = "/".$student->sectionTo->path."/".$student->path."/exam_files";
                    $exam_file = $directory."/".$answer_entry->answer;
                    $file = pathinfo((string)$exam_file."");
                    $temp = explode("item_id=", $file['filename']);
                    $file_id = $temp[1];
                    $file['filename'] = $temp[0];
                    $item_answers[$item->id] = (object) array('answer_entry_id' => $answer_entry->id, 'correct' => $answer_entry->correct, 'points' => $answer_entry->points, 'name' => $file['filename'], 'type' => $file['extension'], 'path' => $file['dirname'], 'id' => $file_id, 'basename' => $file['basename']);
                }
            }
        }

        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.exam-show',
            'exam_paper'        => $exam_paper,
            'student'           => $student,
            'item_answers'      => $item_answers

        );

        return view('layouts.student')->with($variables);
    }

}
