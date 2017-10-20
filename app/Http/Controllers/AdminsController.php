<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Auth;
use App\Student;
use App\Section;
use App\Activity;

class AdminsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:admin')->except('showLoginForm','login','store_first');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    public function store_first(Request $request)
    {
        $this->Validate($request, [
            'password' => 'confirmed|max:5'
        ]);
        $admin = new Admin($request->all());
        $admin->avatar = 'default-avatar.png';
        $admin->theme = 'green';
        $admin->save();
        return redirect()->route('admin.login.form');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function showLoginForm()
    {

        $admins = Admin::all();
        if(count($admins) == 0)
            return view('auth.register');

        if(Auth::guard('admin')->check())
            return redirect('admin');

        if(env('APP_URL') == 'https://computerclassapp.herokuapp.com/'){
            $message_info = "Heroku demo <br> Username: <strong>Admin</strong><br> Password: <strong>12345</strong>";
        }else {
            $message_info = null;
        }

        return view('dashboards.admin.pages.login')->with('message_info', $message_info);


    }



    public function home()
    {

        $variables = array(
            'dashboard_content' => 'dashboards.admin.pages.home',
            'stats' => $this->stats(),
        );

        return view('layouts.admin')->with($variables);

    }



    public function login(Request $request)
    {
      //Validate the form data
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = ucwords(strtolower($request->username));
        //if validated
        if(Auth::guard('admin')->attempt(['username' => $username, 'password' => $request->password]))
            return redirect()->intended('admin');


        return redirect()->back()->withInput($request->only($this->username()))->withErrors('Invalid credentials');

    }



    public function username()
    {

        return 'username';

    }



    public function stats()
    {

        $students = Student::all();
        $sections = Section::all();
        $activities = Activity::all();
        $activity_submits = 0;
        foreach ($students as $student)
            $activity_submits += count($student->Records);

        $stats = (object) array(
            'total_students' => count($students),
            'total_sections' => count($sections),
            'total_activities' => count($activities),
            'activity_submits' => $activity_submits
        );

        return $stats;
    }



    public function settings()
    {

        $variables = array(
            'dashboard_content' => 'dashboards.admin.pages.settings',
        );

        return view('layouts.admin')->with($variables);

    }



    public function theme(Request $request)
    {

        $admin = Admin::find(Auth::user()->id);
        $admin->theme = $request->get('theme');
        $admin->save();

        return redirect()->back();

    }



}
