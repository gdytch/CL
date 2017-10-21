<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Admin;
use Auth;
use App\Student;
use App\Section;
use App\Activity;
use App\FTRule;


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
        //TODO: admin crud
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
        $request->username = strtolower($request->username);
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

        $username = strtolower($request->username);
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
        $storage_size = 0;

        foreach ($students as $student)
            $activity_submits += count($student->Records);

        $all_files = Storage::allfiles();

        foreach ($all_files as $file) {
            $storage_size += Storage::size($file);
        }

        $section_storage = $this->getSectionStorage();

        $stats = (object) array(
            'total_students' => count($students),
            'total_sections' => count($sections),
            'total_activities' => count($activities),
            'activity_submits' => $activity_submits,
            'total_storage_size' => $this->bytesToHuman($storage_size),
            'section_storage' => $section_storage
        );

        return $stats;

    }



    public function getSectionStorage()
    {

        $all_files = Storage::allfiles();
        $total_storage_size = 0;

        foreach ($all_files as $file) {
            $total_storage_size += Storage::size($file);
        }

        $section_paths = Section::select('path')->distinct()->get();
        $section_storage = null;

        foreach ($section_paths as $section)
        {
            $size = 0;
            $files = Storage::allfiles($section->path);

            if($files != null)
                foreach ($files as $file)
                    $size += Storage::size($file);
            $percent = ($size / $total_storage_size) * 100;

            $section_storage[] = (object) array('path' => $section->path, 'size' => $this->bytesToHuman($size), 'percent' => round($percent, 0));
        }

        return $section_storage;

    }


    public function bytesToHuman($bytes)
    {

        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];

    }



    public function settings()
    {

        $rules = FTRule::all();

        $variables = array(
            'dashboard_content' => 'dashboards.admin.pages.settings',
            'filetype_rules' => $rules
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



    public function filetype_rule_store(Request $request)
    {

        $this->Validate($request, [
            'name' => 'unique:ftrules'
        ]);
        $rule = new FTRule($request->all());
        $rule->save();

        return redirect()->back()->withSuccess('Rule saved');
    }



    public function filetype_rule_update(Request $request, $id)
    {

        $this->Validate($request, [
            'name' => 'unique:ftrules,id,'.$id
        ]);

        $rule = FTRule::find($id);
        $rule->update($request->all());

        return redirect()->back()->withSuccess('Rule updated');

    }


    public function filetype_rule_delete($id)
    {

        $rule = FTRule::find($id);
        $rule->delete();

        return redirect()->back()->withSuccess('Rule deleted');

    }



}
