<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('layouts.student')->with('dashboard_content', 'dashboards.student.pages.home');
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
