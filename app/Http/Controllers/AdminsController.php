<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Admin;
use Auth;
use Image;
use App\Student;
use App\Section;
use App\Activity;
use App\FTRule;
use App\Record;
use App\Session;
use App\Post;
use App\Stats;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except('showLoginForm', 'login', 'store_first');
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
        $this->Validate($request, [
            'password' => 'confirmed|min:5',
            'username' => 'unique:admins',
        ]);

        $request->username = strtolower($request->username);
        $admin = new Admin($request->all());
        $admin->avatar = 'default-avatar.png';
        $admin->theme  = 'green';
        $admin->save();

        return redirect()->back()->withSuccess('Admin added');
    }

    public function store_first(Request $request)
    {
        $this->Validate($request, [
            'password' => 'confirmed|min:5'
        ]);
        $request->username = strtolower($request->username);
        $admin = new Admin($request->all());
        $admin->avatar = 'default-avatar.png';
        $admin->theme  = 'green';
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
        // $this->Validate($request, [
        //     'avatar_file' => 'file|max:1024',
        // ]);
        $validator = \Validator::make($request->all(), [
            'avatar_file' => 'file|max:1024',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $admin = Admin::find($id);

        if(!Hash::check($request->confirm_password, $admin->password))
            return redirect()->back()->withErrors('Invalid password');

        $admin->update($request->all());

        //new avatar
        if ($request->hasFile('avatar_file')) {
            $avatar = $request->file('avatar_file');
            $filename = $admin->lname."-".$admin->fname." - ".time().".".$avatar->getClientOriginalExtension();
            if ($admin->avatar != 'default-avatar.png') {
                Storage::delete("avatar/".$admin->avatar);
            }
            Image::make($avatar)->fit(250)->save(public_path().'/storage/avatar/'.$filename);

            $admin->avatar = $filename;
            $admin->update();
        }

        return redirect()->back()->withSuccess('Admin updated');
    }

    public function update_password(Request $request, $id)
    {
        $admin = Admin::find($id);
        if(!Hash::check($request->confirm_password, $admin->password))
            return redirect()->back()->withErrors('Invalid password');

        $this->Validate($request, [
            'password' => 'confirmed|min:5'
        ]);

        $admin->password = $request->password;
        $admin->save();

        return redirect()->back()->withSuccess('Password updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(count(Admin::all())  <= 1)
            return redirect()->back()->withError('Cannot delete the only admin account');

        $admin = Admin::find($id);
        $admin->delete();

        if(Auth::user()->id == $admin->id){
            Auth::logout();
            return redirect()->route('welcome');
        }

        return redirect()->back()->withSuccess('Account deleted');
    }



    public function showLoginForm()
    {
        $admins = Admin::all();
        if (count($admins) == 0) {
            return view('auth.register');
        }

        if (Auth::guard('admin')->check()) {
            return redirect('admin');
        }
        if (Auth::guard('web')->check()) {
            return redirect('home');
        }
        if (env('APP_URL') == 'https://computerclassapp.herokuapp.com/') {
            $message_info = "Heroku demo <br> Username: <strong>Admin</strong><br> Password: <strong>12345</strong>";
        } else {
            $message_info = null;
        }

        return view('dashboards.admin.pages.login')->with('message_info', $message_info);
    }



    public function home()
    {
        $current_date = date("M d Y", time());
        $variables = array(
            'dashboard_content' => 'dashboards.admin.pages.home',
            'current_date'      => $current_date
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
        if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $request->password])) {
            return redirect()->intended('admin');
        }


        return redirect()->back()->withInput($request->only($this->username()))->withErrors('Invalid credentials');
    }



    public function username()
    {
        return 'username';
    }


    public function ajaxStats()
    {
        $students         = Student ::all();
        $sections         = Section ::all();
        $activities       = Activity::all();
        $activity_submits = 0;
        $storage_size     = 0;
        $today            = date("Y-m-d", time());
        $login_list       = null;

        // get today's activities
        $todays_activities = Activity::where('date', $today)->get();
        $content = '';
        foreach ($todays_activities as $key => $activity) {
            $submits_count = count(Record::where(['activity_id' => $activity->id, 'active' => true])->distinct()->get(['student_id']));
            $section_students = count($activity->SectionTo->Students);

            $content .= '
            <div class="col-4 stats">
                <a href="'. route('activity.show', $activity->id) .'" class="btn btn-sm btn-primary">'. $activity->SectionTo->name .' '. $activity->name .' '. $activity->description .'</a>
                <div class="col-12 stat-col">
                    <div class="stat-icon">
                        <i class="fa fa-list-alt"></i>
                    </div>
                    <div class="stat">
                        <div class="value">'. $submits_count .'/'. $section_students .'</div>
                        <div class="name"> Submitted Activities </div>
                    </div>
                    <div class="progress stat-progress">
                        <div class="progress-bar" style="width: '. ($submits_count/$section_students) * 100 .'%;"></div>
                    </div>
                </div>
            </div>';
        }

        $todays_activities_content = $content;


        //get today's total number of student logins/sessions
        $logins_today = Student::where('last_login', $today)->distinct()->orderBy('section')->get();
        $content = '';
        foreach ($logins_today as $student) {
            $submit_status = '<span class="yellow"><i class="fa fa-info-circle"> </i> <strong>No Activity</strong></span>';
            foreach ($todays_activities as $key => $activity) {
                if($activity->section_id == $student->section){
                    $submit_status = $this->checkActivity($activity, $student);
                    break;
                }
            }

            $content .= '<tr>
                  <td width="10">'
                      . $this->sessionStatus($student) .
                  '</td>
                  <td >
                      <a href="'.route('student.show',$student->id).'"> '. $student->lname .', '.$student->fname.'</a>
                  </td>
                  <td >
                      '. $student->sectionTo->name .'
                  </td>
                  <td>
                      '. $submit_status .'
                  </td>
            </tr>';

        }
        if(count($logins_today) != null || count($logins_today) > 0){
            $sessions_content = '<table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th></th><th>Student</th><th>Section</th><th>Submitted</th>
                    </tr>
                </thead>
                <tbody>'. $content. '
                </tbody>
            </table>';
        }

        else
            $sessions_content = 'No Sessions';


        //get total activity submits
        foreach ($students as $student) {
            $activity_submits += count($student->Records);
        }

        $all_files = Storage::allfiles();
        //get total storage size
        foreach ($all_files as $file) {
            $storage_size += Storage::size($file);
        }
        //get total storage size per section
        $section_storage = $this->getSectionStorage();

        $stats = (object) array(
            'total_students'   => count($students),
            'total_sections'   => count($sections),
            'total_activities' => count($activities),
            'total_submits'    => $activity_submits,
            'total_storage'    => $this->bytesToHuman($storage_size),
        );


        return response()->json([
            'sessions'          => $sessions_content,
            'todays_activities' => $todays_activities_content,
            'stats'             => $stats,
            'section_storage'   => $section_storage
        ]);
    }


    public function stats()
    {
        $students         = Student::all();
        $sections         = Section::all();
        $activities       = Activity::all();
        $activity_submits = 0;
        $storage_size     = 0;
        $today            = date("Y-m-d", time());
        $login_list       = null;

        // get today's activities
        $todays_activities = Activity::where('date', $today)->get();
        foreach ($todays_activities as $key => $activity) {
            $submits_count = count(Record::where('activity_id', $activity->id)->distinct()->get(['student_id']));
            $section_students = count($activity->SectionTo->Students);
            $precentage = ($submits_count/$section_students) * 100;
            $todays_activities[$key]['section_name'] = $activity->SectionTo->name;
            $todays_activities[$key]['total_submits'] = $submits_count;
            $todays_activities[$key]['total_students'] = $section_students;
            $todays_activities[$key]['percentage'] = $precentage;
        }

        //get today's total number of student logins/sessions
        $logins_today = Student::where('last_login', $today)->distinct()->orderBy('section')->get();
        foreach ($logins_today as $student) {
            $submit_status = '<span class="yellow"><i class="fa fa-info-circle"> </i> <strong>No Activity</strong></span>';
            foreach ($todays_activities as $key => $activity) {
                if($activity->section_id == $student->section){
                    $submit_status = $this->checkActivity($activity, $student);
                    break;
                }
            }
            $login_list[] = (object) array(
            'id'      => $student->id,
            'fname'   => $student->fname,
            'lname'   => $student->lname,
            'section' => $student->sectionTo->name,
            'submit_status' => $submit_status,
            'online'  => $this->sessionStatus($student)
          );
        }

        //get total activity submits
        foreach ($students as $student) {
            $activity_submits += count($student->Records);
        }

        $all_files = Storage::allfiles();
        //get total storage size
        foreach ($all_files as $file) {
            $storage_size += Storage::size($file);
        }
        //get total storage size per section
        $section_storage = $this->getSectionStorage();

        //get login history
        // $login_history = $this->getLoginHistory();

        $stats = (object) array(
            'total_students'     => count($students),
            'total_sections'     => count($sections),
            'total_activities'   => count($activities),
            'activity_submits'   => $activity_submits,
            'total_storage_size' => $this->bytesToHuman($storage_size),
            'section_storage'    => $section_storage,
            'logins_today'       => $logins_today,
            'todays_activities'  => $todays_activities,
            'login_list'         => $login_list,
            // 'login_history'      => $login_history
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
        $section_storage = array();

        foreach ($section_paths as $section) {
            $size = 0;
            $files = Storage::allfiles($section->path);

            if ($files != null) {
                foreach ($files as $file) {
                    $size += Storage::size($file);
                }
            }
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

        $admins = Admin::all();

        $variables = array(
            'dashboard_content' => 'dashboards.admin.pages.settings',
            'filetype_rules'    => $rules,
            'admins'            => $admins
        );

        return view('layouts.admin')->with($variables);
    }



    public function theme(Request $request)
    {
        $admin = Auth::user();
        $admin->theme = $request->get('theme');
        $admin->save();

        return redirect()->back();
    }



    public function filetype_rule_store(Request $request)
    {
        $this->Validate($request, [
            'name' => 'unique:ftrules',
            'extensions' => 'required'
        ]);
        $rule = new FTRule($request->all());
        $rule->save();

        return response()->json($rule);

    }



    public function filetype_rule_update(Request $request, $id)
    {
        $this->Validate($request, [
            'name' => 'unique:ftrules,id,'.$id
        ]);

        $rule = FTRule::find($id);

        if ($rule->name == 'Default') {
            return redirect()->back()->withErrors('Default rule is locked');
        }

        $rule->update($request->all());

        return response()->json($rule);
    }


    public function filetype_rule_delete($id)
    {
        $rule = FTRule::find($id);
        if ($rule->name == 'Default') {
            return redirect()->back()->withErrors('Default rule is locked');
        }

        $activities = $rule->Activities;
        $default = FTRule::where('name', 'Default')->get()->first();
        if (count($activities) != 0) {
            foreach ($activities as $activity) {
                $activity->ftrule_id = $default->id;
                $activity->update();
            }
        }
        $rule->delete();

        return response()->json($rule);
    }

    public function sessionStatus($student)
    {
        $session = Session::where(['user_id' => $student->id, 'id' => $student->session_id])->get()->first();
        $today = date("Y-m-d", time());
        if($student->last_login != $today){
            return '<small><i class="fa fa-circle-o"></i></small>';
        }
        $current_time = time();
        if ($session == null || count($session) == 0 || ($current_time - $session->last_activity) >= 120) {
            return '<small><i class="fa fa-circle"></i></small>';
        }

        return '<small><i class="fa fa-circle green"></i></small>';
    }


    public function getLoginHistory()
    {
        $sections = Section::all();
        $labels = '';
        $ykeys = '';
        $data_string = array();
        foreach ($sections as $section) {
            $labels .= "'".$section->name."', ";
            $ykeys .= "'y".$section->id."', ";
        }
        $logs = Stats::where(['category' => 'Login History'])->orderBy('date')->take(30)->get();
        if($logs != null){
            foreach ($logs as $log) {
                $data_string[] = "{ x:'".$log->date."', y".$log->section_id.':'.$log->value."},";
            }
        }
        $data = (object) array(
            'labels' => '['.$labels.']',
            'ykeys' => '['.$ykeys.']',
            'data_string' => $data_string,
        );


        return $data;
    }



    public function test()
    {
        echo count(Student::where(['lname' => 'genon', 'fname' => 'dytch'])->get());
    }


    public function checkActivity($activity, $student)
    {
        $record = Record::where(['student_id' => $student->id, 'activity_id' => $activity->id, 'active' => true])->get()->first();

        if(count($record) != 0)
            return '<span class="green"><i class="fa fa-check"></i></span>';

        return '<span class="red"><i class="fa fa-close"></i></span>';
    }



    public function generalSearch(Request $request)
    {
        $keyword = $request->keyword;
        if($keyword == null)
        return redirect()->back()->withError('No search keyword');

        $no_result = false;

        $student_result = Student::SearchByKeyword($keyword)->get();
        $activity_result = Activity::SearchByKeyword($keyword)->get();
        $post_result = Post::SearchByKeyword($keyword)->get();

        if( count($student_result) == 0 && count($activity_result) == 0 && count($post_result) == 0)
            $no_result = true;

        $variables = [
                'dashboard_content' => 'dashboards.admin.pages.search',
                'student_result'    => $student_result,
                'activity_result'   => $activity_result,
                'post_result'       => $post_result,
                'no_result'         => $no_result,
                'keyword'           => $keyword
        ];
 

        return view('layouts.admin')->with($variables);
    }
}
