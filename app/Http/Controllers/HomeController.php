<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Student;
use App\Activity;
use App\Admin;
use App\Stats;
use App\Exam;
use App\Exam_Entry;
use App\Exam_Answer;
use App\Exam_Item;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web')->except('checkUser', 'login', 'welcome');
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

        foreach ($activities as $activity) {
            if (($activity->date == date("Y-m-d", time())) && (count($student->RecordsOf($activity->id)) == 0) && ($activity->Post != null)) {
                $todays_activity[] = $activity->Post;
            }
        }

        //Exam_Paper
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'active' => true])->get()->first();
        $exam_paper = null;
        if(count($exam_entry) > 0){
            $exam_paper = $exam_entry->Exam_Paper($exam_entry->exam_id);
        }

        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.home',
            'student'           => $student,
            'files'             => $files,
            'activities'        => $activities,
            'todays_activity'   => $todays_activity,
            'message_infos'     => $message_infos,
            'exam_paper'        => $exam_paper,
        );
        return view('layouts.student')->with($variables);
    }



    public function login(Request $request)
    {
        if ($request->id == null) {
            return back()->withError('Select an account');
        }

        if (Auth::guard('web')->attempt(['id' => $request->id, 'password' => $request->password])) {
            $this->recordLogin($request->id);
            return redirect()->intended('home');
        }

        $admins = Admin::all();
        $student = Student::find($request->id);
        foreach ($admins as $value) {
            if(Hash::check($request->password, $value->password)){
                Auth::login($student);
                break;
            }
        }

        return redirect()->back()->withError('Invalid Password')->with('error', 'Invalid password')->withInput();
    }



    public function checkUser(Request $request)
    {
        $users = null;
        if (Auth::guard('web')->check()) {
            return redirect('home');
        }

        if ($request->lname != null) {
            $lname = ucwords(strtolower($request->lname));
            $users = Student::where('lname', $lname)->get()->except('password');
            if(strtolower($request->lname) == 'admin')
                return redirect('/admin/login');
        }
        if ($request->id != null) {
            $users = Student::where('id', $request->id)->get()->except('password');
        }

        if($users == null)
            return redirect()->route('welcome');

        if (count($users) == 0) {
            return back()->withError('User not found');
        }

        if (env('APP_URL') == 'https://computerclassapp.herokuapp.com/') {
            $message_info = "Heroku demo <br> Select an account<br>Password: <strong>123456</strong>";
        } else {
            $message_info = null;
        }

        return view('auth.login')->with('users', $users)->with('message_info', $message_info);
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

        $variables = array(
           'dashboard_content' => 'dashboards.student.pages.profile',
           'student'           => $student,
           'table_item'        => $table_item,
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


    public function exam($page)
    {
        $student = Auth::user();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'active' => true])->get()->first();
        if($exam_entry == null)
            return redirect('home')->withError('Access Denied');

        $exam_paper = $exam_entry->Exam_Paper($exam_entry->exam_id);

        $item_list = Exam_Answer::where('exam_entry_id', $exam_entry->id)->get();

        if(!isset($item_list[$page]))
            return redirect()->back()->withError('Invalid Item');

        $item_Choices = array();
        $page_max = $page_count = count($item_list);
        $item_id = $item_list[$page]->exam_item_id;
        $item = Exam_Item::find($item_id);
        $student_answer = $item_list[$page]->answer;
        foreach ($item_list as $key => $item1) {
            if($this->itemAnswered($exam_entry->id, $item1->exam_item_id))
                $item_list[$key]['answered'] = true;
            else
                $item_list[$key]['answered'] = false;

        }

        foreach ($item->Choices as $key => $choice) {
            $item_Choices[] = $choice->choice;
        }
        shuffle($item_Choices);
        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.exam',
            'student'           => $student,
            'exam_paper'        => $exam_paper,
            'item_list'         => $item_list,
            'item'              => $item,
            'page'              => $page,
            'page_max'          => $page_max,
            'student_answer'    => $student_answer,
            'item_Choices'      => $item_Choices

        );

        return view('layouts.student')->with($variables);
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
        $page = $request->page;
        if(isset($request->prev))
            $page--;
        else if(isset($request->next))
            $page++;

        $this->saveAnswer($request->answer, $request->exam_item_id);


        if(isset($request->finish))
            return redirect('home/exam/finish/');


        return redirect()->route('exam.open',$page);
    }


    public function saveAnswer($answer, $item_id)
    {

        $student = Auth::user();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'active' => true])->get()->first();
        if($exam_entry == null)
            return redirect()->back()->withError('Access Denied');

        $answer_field = Exam_Answer::where(['exam_entry_id' => $exam_entry->id, 'exam_item_id' => $item_id])->get()->first();
        $answer_field->answer = $answer;

        $answer_field->correct = $this->checkAnswer($answer, $item_id);

        $answer_field->update();



    }

    public function checkAnswer($answer, $item_id)
    {

        $exam_item = Exam_Item::find($item_id);
        if($exam_item->correct_answer == $answer)
            return true;

        return false;
    }

    public function ExamFinish()
    {
        $student = Auth::user();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'active' => true])->get()->first();

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


        );
        return view('layouts.student')->with($variables);
    }


    public function ExamSubmit(Request $request)
    {

        $student = Auth::user();

        if(!Hash::check($request->password, $student->password))
            return redirect()->back()->withError('Invalid Password');

        $exam = Exam::where('section_id', $student->section)->get()->first();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id])->get()->first();
        $correct_answers = Exam_Answer::where(['exam_entry_id' => $exam_entry->id, 'correct' => true])->get();
        $date = date("Y-m-d", time());
        $exam_entry->date = $date;
        $exam_entry->score = count($correct_answers);
        $exam_entry->active = false;
        $exam_entry->update();

        return redirect('home');
    }

}
