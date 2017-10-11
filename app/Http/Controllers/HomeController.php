<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Student;
use App\Activity;
use Auth;
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
        $student = Student::find(Auth::user()->id);

        $files = app('App\Http\Controllers\StudentsController')->getFiles($student);

        return view('layouts.student')->with('dashboard_content', 'dashboards.student.pages.home')->with('student', $student)->with('files', $files);
    }

    public function login(Request $request){

        if($request->id == null){
            return back()->withError('Select an account');
        }

        if(Auth::guard('web')->attempt(['id' => $request->id, 'password' => $request->password]))
          return redirect()->intended('home');

        return redirect()->back()->withError('Invalid Password')->with('error', 'Invalid password')->withInput();
    }

    public function checkUser(Request $request){
        if(Auth::guard('web')->check())
            return redirect('home');

        if($request->lname != null)
            $users = Student::where('lname' , $request->lname)->get()->except('password');
        else if($request->id != null){
            $users = Student::where('id' , $request->id)->get()->except('password');
        }

        if(count($users) == 0 )
            return back()->withError('Last name not found');
            
        return view('auth.login')->with('users', $users);
    }



    public function welcome(){
        if(Auth::guard('web')->check())
            return redirect('home');
        return view('welcome');
    }

    public function trash(){
        $student = Student::find(Auth::user()->id);
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\trash\\";
        $contents = File::allFiles($directory);

        if($contents != null)
            foreach ($contents as $key => $file) {
               $path = pathinfo((string)$file."");
               $files[$key] = (object) array('name' => $path['filename'], 'type' => $path['extension'], 'path' => $path['dirname']);
           }
        else
           $files = null;

        return view('layouts.student')->with('dashboard_content', 'dashboards.student.pages.trash')->with('student', $student)->with('files', $files);
    }

    public function settings(){
        $student = Student::find(Auth::user()->id);
        return view('layouts.student')->with('dashboard_content', 'dashboards.student.pages.settings')->with('student', $student);

    }

    public function profile(){
        $student = Student::find(Auth::user()->id);


        $file_log = app('App\Http\Controllers\StudentsController')->checkActivities($student);

        return view('layouts.student')->with('dashboard_content', 'dashboards.student.pages.profile')->with('student', $student)->with('file_log', $file_log);

    }

}
