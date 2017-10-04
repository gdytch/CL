<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Student;
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
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\";
        $contents = File::allFiles($directory);

        foreach ($contents as $key => $file) {
            $path = pathinfo((string)$file."");
            $files[$key] = (object) array('name' => $path['basename'], 'type' => $path['extension'], 'path' => $path['dirname']);
        }

        return view('layouts.student')->with('dashboard_content', 'dashboards.student.pages.home')->with('student', $student)->with('files', $files);
    }

    public function login(Request $request){

        if($request->id == null){
            return back()->withError('Select an account');
        }

        if(Auth::guard('web')->attempt(['id' => $request->id, 'password' => $request->password])){
          return redirect()->intended('home');
        }

        // if($student->password == $request->password){
        //     return redirect('/home');
        // }
        else {
            return redirect()->back()->withError('Invalid Password')->with('error', 'Invalid password')->withInput();
        }

    }

    public function checkUser(Request $request){
        if(Auth::guard('web')->check())
            return redirect('home');

        $users = Student::where('lname' , $request->lname)->get()->except('password');
        if(count($users) == 0 ){
            return back()->withError('Lastname not found');
        }
        return view('auth.login')->with('users', $users);
    }



    public function welcome(){
        if(Auth::guard('web')->check())
            return redirect('home');
        return view('welcome');
    }
}
