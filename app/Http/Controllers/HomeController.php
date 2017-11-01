<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Student;
use App\Activity;
use App\Stats;
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

        $variables = array(
            'dashboard_content' => 'dashboards.student.pages.home',
            'student'           => $student,
            'files'             => $files,
            'activities'        => $activities,
            'todays_activity'   => $todays_activity,
            'message_infos'     => $message_infos
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

        return redirect()->back()->withError('Invalid Password')->with('error', 'Invalid password')->withInput();
    }



    public function checkUser(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect('home');
        }

        if ($request->lname != null) {
            $lname = ucwords(strtolower($request->lname));
            $users = Student::where('lname', $lname)->get()->except('password');
        }

        if ($request->id != null) {
            $users = Student::where('id', $request->id)->get()->except('password');
        }

        if (count($users) == 0) {
            return back()->withError('Last name not found');
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

        return redirect('checkUsers?id='.$student->id)->withSuccess('Enter new password');
    }
}
